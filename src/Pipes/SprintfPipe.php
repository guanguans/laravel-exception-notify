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

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Support\Stringable;

class SprintfPipe
{
    public function handle(Collection $collectors, \Closure $next, string $format): Stringable
    {
        return Str::of(\sprintf($format, $next($collectors)));
    }
}
