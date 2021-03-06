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

class DdReportResultListener
{
    public function handle(ReportedEvent $event)
    {
        dd($event->channel->getName(), $event->result);
    }
}
