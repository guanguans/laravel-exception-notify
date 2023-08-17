<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-exception-notify.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelExceptionNotify\Pipes;

use Guanguans\LaravelExceptionNotify\Collectors\ChoreCollector;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Support\Stringable;

class AddChorePipe
{
    /**
     * @param mixed $value
     * @param array-key $key
     */
    public function handle(Collection $collectors, \Closure $next, $value, $key): Stringable
    {
        return $next(collect(Arr::add(
            $collectors->all(),
            Str::start($key, ChoreCollector::name().'.'),
            $value
        )));
    }
}
