<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-exception-notify.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelExceptionNotify\Listeners\Reporting;

use Guanguans\LaravelExceptionNotify\Events\ReportingEvent;

class DdReportListener
{
    public function handle(ReportingEvent $reportingEvent): void
    {
        /** @noinspection ForgottenDebugOutputInspection */
        dd($reportingEvent->channel->getName(), $reportingEvent->report);
    }
}
