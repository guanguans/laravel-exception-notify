<?php

declare(strict_types=1);

/**
 * Copyright (c) 2021-2025 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-exception-notify
 */

namespace Guanguans\LaravelExceptionNotify\Channels;

use Guanguans\LaravelExceptionNotify\Contracts\ChannelContract;
use Guanguans\LaravelExceptionNotify\Contracts\CollectorContract;
use Guanguans\LaravelExceptionNotify\Contracts\ExceptionAwareContract;
use Guanguans\LaravelExceptionNotify\Exceptions\InvalidConfigurationException;
use Guanguans\LaravelExceptionNotify\Pipes\FixPrettyJsonPipe;
use Guanguans\LaravelExceptionNotify\Template;
use Illuminate\Config\Repository;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Stringable;
use function Guanguans\LaravelExceptionNotify\Support\json_pretty_encode;
use function Guanguans\LaravelExceptionNotify\Support\make;

abstract class AbstractChannel implements ChannelContract
{
    /**
     * @throws \Throwable
     */
    public function __construct(protected Repository $configRepository)
    {
        $validator = Validator::make(
            $this->configRepository->all(),
            $rules = $this->rules(),
            $this->messages(),
            $this->attributes() + collect(Arr::dot($rules))
                ->keys()
                ->mapWithKeys(fn (string $attribute): array => [
                    $attribute => str($this->getChannel())->append('.', $attribute)->toString(),
                ])
                ->all()
        );

        throw_if($validator->fails(), InvalidConfigurationException::fromValidator($validator));
    }

    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function report(\Throwable $throwable): void
    {
        $pendingDispatch = dispatch($this->makeJob($throwable));

        if (
            'sync' === (config('exception-notify.job.connection') ?? config('queue.default'))
            && !app()->runningInConsole()
        ) {
            $pendingDispatch->afterResponse();
        }

        // unset($pendingDispatch);
    }

    protected function rules(): array
    {
        return [
            '__channel' => 'required|string',
            'driver' => 'required|string',
            'collectors' => 'array',
            'pipes' => 'array',
        ];
    }

    protected function messages(): array
    {
        return [];
    }

    protected function attributes(): array
    {
        return [];
    }

    protected function applyContentToConfiguration(array $configuration, string $content): array
    {
        array_walk_recursive($configuration, static function (mixed &$value) use ($content): void {
            \is_string($value) and $value = str_replace(
                [Template::TITLE, Template::CONTENT],
                [config('exception-notify.title'), $content],
                $value
            );
        });

        return $configuration;
    }

    protected function applyConfigurationToObject(object $object, array $configuration, ?array $except = null): object
    {
        return collect($configuration)
            ->except(
                $except ?? collect((new \ReflectionObject($object))->getConstructor()?->getParameters())
                    ->map(static fn (\ReflectionParameter $reflectionParameter): string => $reflectionParameter->getName())
                    ->push(
                        '__channel',
                        '__abstract',
                        '__class',
                        '__name',
                        '_abstract',
                        '_class',
                        '_name',
                    )
                    ->all()
            )
            ->each(static function (mixed $value, string $key) use ($object): void {
                foreach (
                    [
                        static fn (string $key): string => $key,
                        static fn (string $key): string => Str::camel($key),
                        static fn (string $key): string => 'set'.Str::studly($key),
                        static fn (string $key): string => 'on'.Str::studly($key),
                    ] as $caster
                ) {
                    if (method_exists($object, $method = $caster($key))) {
                        $numberOfParameters = (new \ReflectionMethod($object, $method))->getNumberOfParameters();

                        if (0 === $numberOfParameters) {
                            continue;
                        }

                        if (1 === $numberOfParameters) {
                            $object->{$method}($value);

                            return;
                        }

                        app()->call([$object, $method], $value);

                        return;
                    }
                }
            })
            ->pipe(static function (Collection $configuration) use ($object): object {
                $extender = $configuration->get('extender');

                if (!$extender) {
                    return $object;
                }

                if (!\is_callable($extender)) {
                    $extender = make($extender);
                }

                return $extender($object);
            });
    }

    private function getChannel(): string
    {
        return $this->configRepository->get('__channel');
    }

    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    private function makeJob(\Throwable $throwable): ShouldQueue
    {
        return $this->applyConfigurationToObject(
            make($configuration = config('exception-notify.job') + [
                'channel' => $this->getChannel(),
                'content' => $this->getContent($throwable),
            ]),
            $configuration
        );
    }

    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    private function getContent(\Throwable $throwable): string
    {
        return (string) (new Pipeline(app()))
            ->send($this->getCollectors($throwable))
            ->through($this->getPipes())
            ->then(static fn (Collection $collectors): Stringable => str(json_pretty_encode($collectors->jsonSerialize())));
    }

    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    private function getCollectors(\Throwable $throwable): Collection
    {
        return collect([
            ...config('exception-notify.collectors', []),
            ...$this->configRepository->get('collectors', []),
        ])->mapWithKeys(static function (array|string $parameters, int|string $class) use ($throwable): array {
            if (!\is_array($parameters)) {
                [$parameters, $class] = [(array) $class, $parameters];
            }

            /** @var CollectorContract $collectorContract */
            $collectorContract = app()->make($class, $parameters);
            $collectorContract instanceof ExceptionAwareContract and $collectorContract->setException($throwable);

            return [$collectorContract->name() => $collectorContract->collect()];
        });
    }

    private function getPipes(): array
    {
        return collect($this->configRepository->get('pipes', []))->prepend(FixPrettyJsonPipe::class)->all();
    }
}
