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
use Illuminate\Support\Fluent;

class CollectorManager extends Fluent implements \Stringable
{
    /**
     * @param array<CollectorContract> $collectors
     *
     * @throws \Guanguans\LaravelExceptionNotify\Exceptions\InvalidArgumentException
     *
     * @noinspection MagicMethodsValidityInspection
     * @noinspection PhpMissingParentConstructorInspection
     */
    public function __construct(array $collectors = [])
    {
        foreach ($collectors as $index => $collector) {
            $this->offsetSet($index, $collector);
        }
    }

    public function __toString()
    {
        return $this->toReport(app('exception.notify.exception'));
    }

    public function offsetSet($offset, $value): void
    {
        if (! $value instanceof CollectorContract) {
            throw new InvalidArgumentException(sprintf('Collector must be instance of %s', CollectorContract::class));
        }

        $this->attributes[$offset] = $value;
    }

    public function toReport(\Throwable $throwable): string
    {
        return collect($this)
            ->mapWithKeys(static function (CollectorContract $collector) use ($throwable): array {
                $collector instanceof ExceptionAwareContract and $collector->setException($throwable);

                return [$collector->name() => $collector->toArray()];
            })
            ->toJson(JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    }
}
