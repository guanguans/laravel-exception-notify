<?php

/**
 * This file is part of the guanguans/laravel-exception-notify.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelExceptionNotify;

use Guanguans\LaravelExceptionNotify\Contracts\Collector;
use Guanguans\LaravelExceptionNotify\Contracts\ExceptionProperty;
use Guanguans\LaravelExceptionNotify\Exceptions\InvalidArgumentException;
use Illuminate\Support\Collection;
use Illuminate\Support\Fluent;
use Stringable;

class CollectorManager extends Fluent implements Stringable
{
    /**
     * @var Collector[]
     */
    public function __construct($collectors = [])
    {
        foreach ($collectors as $index => $collector) {
            $this->offsetSet($index, $collector);
        }

        parent::__construct($collectors);
    }

    public function offsetSet($offset, $value): void
    {
        if (! $value instanceof Collector) {
            throw new InvalidArgumentException(sprintf('Collector must be instance of %s', Collector::class));
        }

        $this->attributes[$offset] = $value;
    }

    public function __toString()
    {
        return (string) collect($this)
            ->transform(function (Collector $collector) {
                $collector instanceof ExceptionProperty and $collector->setException(app('exception.notify.exception'));

                return $collector;
            })
            ->pipe(function (Collection $collectors): string {
                return call(config('exception-notify.collector.transformer'), ['collectors' => $collectors]);
            });
    }
}
