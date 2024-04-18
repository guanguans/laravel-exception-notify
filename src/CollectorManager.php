<?php

declare(strict_types=1);

/**
 * Copyright (c) 2021-2024 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-exception-notify
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
     * @noinspection MagicMethodsValidityInspection
     * @noinspection PhpMissingParentConstructorInspection
     * @noinspection MissingParentCallInspection
     *
     * @param list<CollectorContract> $collectors
     *
     * @throws \Guanguans\LaravelExceptionNotify\Exceptions\InvalidArgumentException
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
        if (!$value instanceof CollectorContract) {
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
