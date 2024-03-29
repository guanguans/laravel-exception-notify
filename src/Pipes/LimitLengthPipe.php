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

use Illuminate\Support\Collection;
use Illuminate\Support\Stringable;

class LimitLengthPipe
{
    public function handle(Collection $collectors, \Closure $next, int $length, float $percentage = 0.9): Stringable
    {
        return $next($collectors)->substr(0, (int) ($length * $percentage));
    }
}
