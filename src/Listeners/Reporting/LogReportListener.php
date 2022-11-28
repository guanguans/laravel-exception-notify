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
use Psr\Log\LoggerInterface;

class LogReportListener
{
    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function handle(ReportingEvent $reportingEvent): void
    {
        $this->logger->info($reportingEvent->channel->getName());
        $this->logger->info($reportingEvent->report);
    }
}
