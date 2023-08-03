<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-exception-notify.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelExceptionNotify;

use Guanguans\LaravelExceptionNotify\Contracts\CollectorContract;
use Guanguans\LaravelExceptionNotify\Contracts\ExceptionAwareContract;
use Guanguans\LaravelExceptionNotify\Exceptions\InvalidArgumentException;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Collection;
use Illuminate\Support\Fluent;

class CollectorManager extends Fluent
{
    /**
     * @param array<CollectorContract> $collectors
     *
     * @throws \Guanguans\LaravelExceptionNotify\Exceptions\InvalidArgumentException
     *
     * @noinspection MagicMethodsValidityInspection
     * @noinspection MagicMethodsValidityInspection
     * @noinspection PhpMissingParentConstructorInspection
     * @noinspection MissingParentCallInspection
     */
    public function __construct(array $collectors = [])
    {
        foreach ($collectors as $index => $collector) {
            $this->offsetSet($index, $collector);
        }
    }

    /**
     * @noinspection PhpMissingParentCallCommonInspection
     * @noinspection MissingParentCallInspection
     *
     * @param array-key $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value): void
    {
        if (! $value instanceof CollectorContract) {
            throw new InvalidArgumentException(sprintf('Collector must be instance of %s', CollectorContract::class));
        }

        $this->attributes[$offset] = $value;
    }

    public function toReports(array $channels, \Throwable $throwable): array
    {
        return collect($channels)
            ->mapWithKeys(fn (string $channel): array => [$channel => $this->toReport($channel, $throwable)])
            ->all();
    }

    protected function toReport(string $channel, \Throwable $throwable): string
    {
        $collectors = collect($this)
            ->mapWithKeys(static function (CollectorContract $collector) use ($throwable): array {
                $collector instanceof ExceptionAwareContract and $collector->setException($throwable);

                return [$collector->name() => $collector->collect()];
            });

        return (new Pipeline(app()))
            ->send($collectors)
            ->through(config("exception-notify.channels.$channel.pipes", []))
            ->then(fn (Collection $collectors): string => $collectors->toJson(
                JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT
            ));
    }
}
