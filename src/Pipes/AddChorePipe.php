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

namespace Guanguans\LaravelExceptionNotify\Pipes;

use Guanguans\LaravelExceptionNotify\Collectors\ChoreCollector;
use Guanguans\LaravelExceptionNotify\Support\Traits\WithPipeArgs;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Support\Stringable;

class AddChorePipe
{
    use WithPipeArgs;

    /**
     * @param array-key $key
     */
    public function handle(Collection $collectors, \Closure $next, mixed $value, mixed $key): Stringable
    {
        return $next(collect(Arr::add(
            $collectors->all(),
            Str::start($key, ChoreCollector::name().'.'),
            $value
        )));
    }
}
