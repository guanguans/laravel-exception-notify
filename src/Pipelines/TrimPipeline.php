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

class TrimPipeline
{
    public function handle(string $report, \Closure $next, string $chars = " \t\n\r\0\x0B"): string
    {
        return $next(trim($report, $chars));
    }
}
