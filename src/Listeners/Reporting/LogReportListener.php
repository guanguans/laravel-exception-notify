<?php

/**
 * This file is part of the guanguans/laravel-exception-notify.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelExceptionNotify\Listeners\Reporting;

use Guanguans\LaravelExceptionNotify\Events\ReportingEvent;
use Illuminate\Log\Logger;

class LogReportListener
{
    /**
     * @var \Illuminate\Log\Logger
     */
    protected $logger;

    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
    }

    public function handle(ReportingEvent $event)
    {
        $this->logger->info($event->channel->getName());
        $this->logger->info($event->report);
    }
}
