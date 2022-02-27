<?php

/**
 * This file is part of the guanguans/laravel-exception-notify.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelExceptionNotify\Listeners\Reported;

use Guanguans\LaravelExceptionNotify\Events\ReportedEvent;
use Illuminate\Log\Logger;

class LogReportResultListener
{
    /**
     * @var \Illuminate\Log\Logger
     */
    protected $logger;

    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
    }

    public function handle(ReportedEvent $event)
    {
        $this->logger->info($event->channel->getName(), (array) $event->result);
    }
}
