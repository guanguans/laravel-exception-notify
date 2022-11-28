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

use Guanguans\LaravelExceptionNotify\Contracts\Collector;
use Guanguans\LaravelExceptionNotify\Contracts\ExceptionAware;
use Guanguans\LaravelExceptionNotify\Exceptions\InvalidArgumentException;
use Illuminate\Support\Collection;
use Illuminate\Support\Fluent;
use Stringable;
use Throwable;

class CollectorManager extends Fluent implements Stringable
{
    /**
     * @param Collector[] $collectors
     *
     * @throws \Guanguans\LaravelExceptionNotify\Exceptions\InvalidArgumentException
     * @noinspection MagicMethodsValidityInspection
     * @noinspection PhpMissingParentConstructorInspection
     */
    public function __construct($collectors = [])
    {
        foreach ($collectors as $index => $collector) {
            $this->offsetSet($index, $collector);
        }
    }

    public function offsetSet($offset, $value): void
    {
        if (! $value instanceof Collector) {
            throw new InvalidArgumentException(sprintf('Collector must be instance of %s', Collector::class));
        }

        $this->attributes[$offset] = $value;
    }

    public function toReport(Throwable $throwable): string
    {
        return (string) collect($this)
            ->transform(static function (Collector $collector) use ($throwable) {
                $collector instanceof ExceptionAware and $collector->setException($throwable);

                return $collector;
            })
            ->pipe(static function (Collection $collection): string {
                $report = $collection->reduce(static function (string $carry, Collector $collector): string {
                    return $carry.PHP_EOL.sprintf('%s: %s', $collector->getName(), (string) $collector);
                }, '');

                return trim($report);
            });
    }

    public function __toString()
    {
        return $this->toReport(app('exception.notify.exception'));
    }
}
