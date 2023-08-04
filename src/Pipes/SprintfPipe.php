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

class SprintfPipe
{
    public function handle(Collection $collectors, \Closure $next, string $format): Stringable
    {
        return str(sprintf($format, $next($collectors)));
    }
}
