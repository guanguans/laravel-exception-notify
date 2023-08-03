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

class LengthLimitPipe
{
    public function handle(Collection $collectors, \Closure $next, int $length = -1): string
    {
        $report = $next($collectors);
        if ($length > 0) {
            $report = substr($report, 0, (int) ($length * 90 / 100));
        }

        return $report;
    }
}
