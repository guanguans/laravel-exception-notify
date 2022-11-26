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

class CollectorManager extends Fluent implements \Stringable
{
    /**
     * @var Collector[]
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

    public function toReport(\Throwable $e): string
    {
        return (string) collect($this)
            ->transform(function (Collector $collector) use ($e) {
                $collector instanceof ExceptionAware and $collector->setException($e);

                return $collector;
            })
            ->pipe(function (Collection $collectors): string {
                $report = $collectors->reduce(fn (string $carry, Collector $collector) => $carry.PHP_EOL.sprintf('%s: %s', $collector->getName(), $collector), '');

                return trim($report);
            });
    }

    public function __toString()
    {
        return $this->toReport(app('exception.notify.exception'));
    }
}
