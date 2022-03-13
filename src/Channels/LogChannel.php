<?php

/**
 * This file is part of the guanguans/laravel-exception-notify.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelExceptionNotify\Channels;

use Illuminate\Support\Facades\Log;

class LogChannel extends Channel
{
    public function report(string $report)
    {
        Log::error($report);
    }
}
