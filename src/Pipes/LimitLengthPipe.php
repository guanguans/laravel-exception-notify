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

use Illuminate\Support\Collection;
use Illuminate\Support\Stringable;

class LimitLengthPipe
{
    public function handle(Collection $collectors, \Closure $next, int $length, float $percentage = 0.9): Stringable
    {
        return $next($collectors)->substr(0, (int) ($length * $percentage));
    }
}
