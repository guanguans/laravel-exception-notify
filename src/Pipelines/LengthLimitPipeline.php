<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-exception-notify.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelExceptionNotify\Pipelines;

class LengthLimitPipeline
{
    public function handle(string $report, \Closure $next, int $length = -1): string
    {
        $length > 0 and $report = substr($report, 0, (int) ($length * 90 / 100));

        return $next($report);
    }
}
