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
use Guanguans\LaravelExceptionNotify\Pipes\LimitLengthPipe;
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
    public const CHANNEL_CONFIGURATION_KEY = '__channel';
    public const TITLE_TEMPLATE = '{title}';
    public const CONTENT_TEMPLATE = '{content}';

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
                    $attribute => str('exception-notify.channels.')
                        ->append($this->getChannel(), '.', $attribute)
                        ->toString(),
                ])
                // ->dump()
                ->all()
        );

        throw_if($validator->fails(), InvalidConfigurationException::fromValidator($validator));
    }

    public function report(\Throwable $throwable): void
    {
        $pendingDispatch = dispatch($this->makeJob($throwable));

        if (
            'sync' === config('exception-notify.job.connection', config('queue.default'))
            && !app()->runningInConsole()
        ) {
            $pendingDispatch->afterResponse();
        }

        // unset($pendingDispatch); // Trigger the job
    }

    protected function makeJob(\Throwable $throwable): ShouldQueue
    {
        return $this->applyConfigurationToObject(
            new (config('exception-notify.job.class'))($this->getChannel(), $this->getContent($throwable)),
            config('exception-notify.job')
        );
    }

    protected function rules(): array
    {
        return [
            'driver' => 'required|string',
            self::CHANNEL_CONFIGURATION_KEY => 'required|string',
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

    protected function getContent(\Throwable $throwable): string
    {
        return (string) (new Pipeline(app()))
            ->send($this->getCollectors($throwable))
            ->through($this->getPipes())
            ->then(static fn (Collection $collectors): Stringable => str(json_pretty_encode($collectors->jsonSerialize())));
    }

    protected function getPipes(): array
    {
        $index = collect($pipes = $this->configRepository->get('pipes', []))->search(
            static fn (string $pipe) => Str::contains($pipe, LimitLengthPipe::class)
        );

        if (false === $index) {
            return $pipes;
        }

        return collect($pipes)
            ->push(FixPrettyJsonPipe::class)
            ->sort(static function (string $a, string $b): int {
                if (FixPrettyJsonPipe::class === $a && !Str::contains($b, LimitLengthPipe::class)) {
                    return 1;
                }

                $rules = [
                    FixPrettyJsonPipe::class,
                    LimitLengthPipe::class,
                ];

                return collect($rules)->search(static fn (string $rule) => Str::contains($a, $rule))
                    <=> collect($rules)->search(static fn (string $rule) => Str::contains($b, $rule));
            })
            // ->dump()
            ->all();
    }

    protected function getCollectors(\Throwable $throwable): Collection
    {
        return collect(array_merge(
            config('exception-notify.collectors', []),
            $this->configRepository->get('collectors', [])
        ))->map(static function (array|string $parameters, int|string $class): CollectorContract {
            if (!\is_array($parameters)) {
                [$parameters, $class] = [(array) $class, $parameters];
            }

            return app()->make($class, $parameters);
        })->mapWithKeys(
            static function (CollectorContract $collectorContract) use ($throwable): array {
                $collectorContract instanceof ExceptionAwareContract and $collectorContract->setException($throwable);

                return [$collectorContract->name() => $collectorContract->collect()];
            }
        );
    }

    protected function getChannel(): string
    {
        return $this->configRepository->get(self::CHANNEL_CONFIGURATION_KEY);
    }

    protected function applyContentToConfiguration(array $configuration, string $content): array
    {
        array_walk_recursive($configuration, static function (mixed &$value) use ($content): void {
            \is_string($value) and $value = str_replace(
                [self::TITLE_TEMPLATE, self::CONTENT_TEMPLATE],
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
                        '__abstract',
                        '__class',
                        '__name',
                        '_abstract',
                        '_class',
                        '_name',
                        self::CHANNEL_CONFIGURATION_KEY,
                    )
                    ->all()
            )
            // ->filter(static fn (mixed $value): bool => \is_array($value) && !array_is_list($value))
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

                if (!\is_callable($extender) && (\is_array($extender) || \is_string($extender))) {
                    $extender = make($extender);
                }

                return $extender($object);
            });
    }
}
