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

namespace Guanguans\LaravelExceptionNotify\Pipes;

use Guanguans\LaravelExceptionNotify\Collectors\ChoreCollector;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Support\Stringable;

class AddChorePipe
{
    /**
     * @noinspection MissingParameterTypeDeclarationInspection
     *
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
