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

class VarOutputPipeline
{
    public function handle(string $report, Closure $next): string
    {
        return $next(var_output($report, true));
    }
}
