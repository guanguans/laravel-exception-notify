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

abstract class Channel implements \Guanguans\LaravelExceptionNotify\Contracts\Channel
{
    public function __construct(protected Repository $configRepository)
    {
        $validator = Validator::make(
            $this->configRepository->all(),
            $this->rules(),
            $this->messages(),
            $this->attributes()
        );

        if ($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first());
        }
    }

    final public function report(\Throwable $throwable): void
    {
        try {
            $dispatch = dispatch(new ReportExceptionJob([
                $this->getChannel() => $this->getReport(),
            ]));

            if (
                'sync' === config('exception-notify.job.connection')
                && !app()->runningInConsole()
            ) {
                $dispatch->afterResponse();
            }

            unset($dispatch);
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
            '__channel' => 'string',
            '_channel' => 'string',
            'channel' => 'string',
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
            ->then(static fn (Collection $collectors): Stringable => str(json_pretty_encode(
                $collectors->jsonSerialize()
            )));
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
        return collect([
            ...config('exception-notify.collectors', []),
            ...$this->configRepository->get('collectors', []),
        ])->map(static function (array|string $parameters, int|string $class) {
            if (!\is_array($parameters)) {
                [$parameters, $class] = [(array) $class, $parameters];
            }

            return app()->make($class, $parameters);
        });
    }

    protected function getChannel(): string
    {
        foreach (['__channel', '_channel', 'channel'] as $key) {
            if ($this->configRepository->has($key)) {
                return $this->configRepository->get($key);
            }
        }

        throw new \InvalidArgumentException('The channel is not set.');
    }
}
