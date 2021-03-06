<?php

/**
 * This file is part of the guanguans/laravel-exception-notify.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelExceptionNotify\Pipelines;

use Closure;

class UrlEncodePipeline
{
    public function handle(string $report, Closure $next): string
    {
        return $next(urlencode($report));
    }
}
