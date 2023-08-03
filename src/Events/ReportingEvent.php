<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-exception-notify.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelExceptionNotify\Events;

use Guanguans\LaravelExceptionNotify\Contracts\ChannelContract;

class ReportingEvent
{
    public ChannelContract $channel;

    public string $report;

    public function __construct(ChannelContract $channel, string $report)
    {
        $this->channel = $channel;
        $this->report = $report;
    }
}
