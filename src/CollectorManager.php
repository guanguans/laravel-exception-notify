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

namespace Guanguans\LaravelExceptionNotify;

use Guanguans\LaravelExceptionNotify\Contracts\Collector;
use Guanguans\LaravelExceptionNotify\Contracts\ExceptionAware;
use Guanguans\LaravelExceptionNotify\Pipes\FixPrettyJsonPipe;
use Guanguans\LaravelExceptionNotify\Pipes\LimitLengthPipe;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Collection;
use Illuminate\Support\Fluent;
use Illuminate\Support\Str;
use Illuminate\Support\Stringable;

class CollectorManager extends Fluent
{
    public function mapToReports(array $channels, \Throwable $throwable): array
    {
        $collectors = collect($this)->mapWithKeys(
            static function (Collector $collector) use ($throwable): array {
                $collector instanceof ExceptionAware and $collector->setException($throwable);

                return [$collector::name() => $collector->collect()];
            }
        );

        return collect($channels)
            ->mapWithKeys(fn (string $channel): array => [$channel => $this->mapToReport(
                $channel,
                $collectors
            )])
            ->all();
    }

    private function mapToReport(string $channel, Collection $collectors): string
    {
        return (string) (new Pipeline(app()))
            ->send($collectors)
            ->through($this->toPipes($channel))
            ->then(static fn (Collection $collectors): Stringable => str(\Guanguans\LaravelExceptionNotify\Support\json_pretty_encode(
                $collectors->jsonSerialize()
            )));
    }

    private function toPipes(string $channel): array
    {
        $index = collect($pipes = config("exception-notify.channels.$channel.pipes", []))->search(
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
}
