<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-exception-notify.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelExceptionNotify\Listeners\Reported;

use Guanguans\LaravelExceptionNotify\Events\ReportedEvent;

class DdReportResultListener
{
    /**
     * @noinspection ForgottenDebugOutputInspection
     * @noinspection DebugFunctionUsageInspection
     *
     * @return never-return
     */
    public function handle(ReportedEvent $reportedEvent): void
    {
        dd($reportedEvent->channel->getName(), $reportedEvent->result);
    }
}
