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

class LimitLengthPipe
{
    public function handle(Collection $collectors, \Closure $next, int $length, float $percentage = 0.9): string
    {
        return substr($next($collectors), 0, (int) ($length * $percentage));
    }
}
