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
use Illuminate\Support\Stringable;

class CollectorManager extends Fluent
{
    /**
     * @param array<CollectorContract> $collectors
     *
     * @throws \Guanguans\LaravelExceptionNotify\Exceptions\InvalidArgumentException
     *
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
     * @param array-key $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value): void
    {
        if (! $value instanceof CollectorContract) {
            throw new InvalidArgumentException(sprintf('The value must be an instance of %s', CollectorContract::class));
        }

        parent::offsetSet($offset, $value);
    }

    public function mapToReports(array $channels, \Throwable $throwable): array
    {
        $collectors = collect($this)->mapWithKeys(
            static function (CollectorContract $collector) use ($throwable): array {
                $collector instanceof ExceptionAwareContract and $collector->setException($throwable);

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

    /**
     * @psalm-suppress InvalidReturnType
     * @psalm-suppress InvalidReturnStatement
     */
    protected function mapToReport(string $channel, Collection $collectors): string
    {
        return (string) (new Pipeline(app()))
            ->send($collectors)
            ->through(config("exception-notify.channels.$channel.pipes", []))
            ->then(static fn (Collection $collectors): Stringable => str(json_pretty_encode(
                $collectors->jsonSerialize()
            )));
    }
}
