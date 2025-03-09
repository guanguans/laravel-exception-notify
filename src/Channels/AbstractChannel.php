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
use Guanguans\LaravelExceptionNotify\Exceptions\InvalidArgumentException;
use Guanguans\LaravelExceptionNotify\Jobs\ReportExceptionJob;
use Guanguans\LaravelExceptionNotify\Pipes\FixPrettyJsonPipe;
use Guanguans\LaravelExceptionNotify\Pipes\LimitLengthPipe;
use Illuminate\Config\Repository;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Stringable;
use function Guanguans\LaravelExceptionNotify\Support\json_pretty_encode;

abstract class AbstractChannel implements ChannelContract
{
    public const CHANNEL_KEY = '__channel';

    public function __construct(protected Repository $configRepository)
    {
        $validator = Validator::make(
            $this->configRepository->all(),
            $this->rules(),
            $this->messages(),
            $this->attributes()
        );

        throw_if($validator->fails(), InvalidArgumentException::class, $validator->errors()->first());
    }

    public function report(\Throwable $throwable): void
    {
        try {
            $pendingDispatch = ReportExceptionJob::dispatch($this->getChannel(), $this->getReport());

            if (
                'sync' === config('exception-notify.job.connection')
                && !app()->runningInConsole()
            ) {
                $pendingDispatch->afterResponse();
            }

            unset($pendingDispatch); // Trigger the job
        } catch (\Throwable $throwable) {
            Log::error($throwable->getMessage(), ['exception' => $throwable]);
        }
    }

    protected function rules(): array
    {
        return [
            'driver' => 'required|string',
            'collectors' => 'array',
            'pipes' => 'array',
            self::CHANNEL_KEY => 'string',
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

    protected function getReport(): string
    {
        return (string) (new Pipeline(app()))
            ->send($this->getCollectors())
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

    protected function getCollectors(): Collection
    {
        return collect(array_merge(
            config('exception-notify.collectors', []),
            $this->configRepository->get('collectors', [])
        ))->map(static function (array|string $parameters, int|string $class) {
            if (!\is_array($parameters)) {
                [$parameters, $class] = [(array) $class, $parameters];
            }

            return app()->make($class, $parameters);
        });
    }

    protected function getChannel(): string
    {
        return $this->configRepository->get(self::CHANNEL_KEY);
    }
}
