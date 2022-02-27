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
use Illuminate\Support\Collection;

class CollectorTransformer
{
    public function handle(Collection $collectors): string
    {
        return $collectors->reduce(function ($carry, Collector $collector) {
            return $carry.PHP_EOL.sprintf('%s: %s'.PHP_EOL, $collector->getName(), (string) $collector);
        }, '');
    }
}
