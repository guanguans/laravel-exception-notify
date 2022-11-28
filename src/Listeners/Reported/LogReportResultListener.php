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
use Psr\Log\LoggerInterface;

class LogReportResultListener
{
    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function handle(ReportedEvent $reportedEvent): void
    {
        $this->logger->info($reportedEvent->channel->getName(), (array) $reportedEvent->result);
    }
}
