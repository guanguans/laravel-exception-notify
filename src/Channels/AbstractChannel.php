<?php

declare(strict_types=1);

/**
 * Copyright (c) 2021-2026 guanguans<ityaozm@gmail.com>
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
use Guanguans\LaravelExceptionNotify\Jobs\ReportExceptionJob;
use Guanguans\LaravelExceptionNotify\Support\Utils;
use Illuminate\Config\Repository;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Stringable;
use function Guanguans\LaravelExceptionNotify\Support\make;

abstract class AbstractChannel implements ChannelContract
{
    /**
     * @throws \Throwable
     */
    public function __construct(protected readonly Repository $configRepository)
    {
        $validator = Validator::make(
            $this->configRepository->all(),
            $rules = $this->rules() + [
                '__channel' => 'required|string',
                'driver' => 'required|string',
                'collectors' => 'array',
                'pipes' => 'array',
            ],
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
     * @throws \ReflectionException
     */
    public function report(\Throwable $throwable): void
    {
        $pendingDispatch = dispatch($this->makeJob($throwable));
        Utils::isSyncJobConnection() and $pendingDispatch->afterResponse();
        // unset($pendingDispatch);
    }

    /**
     * @see \Illuminate\Foundation\Http\FormRequest
     *
     * @return array<string, list<mixed>|mixed>
     */
    abstract protected function rules(): array;

    /**
     * @return array<string, string>
     */
    protected function messages(): array
    {
        return [];
    }

    /**
     * @return array<string, string>
     */
    protected function attributes(): array
    {
        return [];
    }

    /**
     * @throws \ReflectionException
     */
    private function makeJob(\Throwable $throwable): ShouldQueue
    {
        return make((array) config('exception-notify.job') + [
            'class' => ReportExceptionJob::class,
            'channel' => $this->getChannel(),
            'content' => $this->getContent($throwable),
        ]);
    }

    private function getChannel(): string
    {
        return $this->configRepository->get('__channel');
    }

    private function getContent(\Throwable $throwable): string
    {
        return (string) (new Pipeline(app()))
            ->send($this->getCollectors($throwable))
            ->through($this->getPipes())
            ->then(static fn (Collection $collectors): Stringable => str($collectors->toJson(
                \JSON_PRETTY_PRINT | \JSON_UNESCAPED_UNICODE | \JSON_UNESCAPED_SLASHES | \JSON_THROW_ON_ERROR | \JSON_FORCE_OBJECT
            )));
    }

    /**
     * @return \Illuminate\Support\Collection<string, array<string, mixed>>
     */
    private function getCollectors(\Throwable $throwable): Collection
    {
        return collect([
            ...(array) config('exception-notify.collectors'),
            ...(array) $this->configRepository->get('collectors'),
        ])->mapWithKeys(static function (array|string $parameters, int|string $class) use ($throwable): array {
            if (!\is_array($parameters)) {
                [$parameters, $class] = [(array) $class, $parameters];
            }

            $collectorContract = resolve($class, $parameters);
            \assert($collectorContract instanceof CollectorContract);
            $collectorContract instanceof ExceptionAwareContract and $collectorContract->setException($throwable);

            return [$collectorContract->name() => $collectorContract->collect()];
        });
    }

    /**
     * @return list<mixed>
     */
    private function getPipes(): array
    {
        return collect($this->configRepository->get('pipes'))->all();
    }
}
