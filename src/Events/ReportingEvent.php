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

use Guanguans\LaravelExceptionNotify\Contracts\Channel;

class ReportingEvent
{
    /**
     * @var \Guanguans\LaravelExceptionNotify\Contracts\Channel
     */
    public $channel;

    /**
     * @var string
     */
    public $report;

    public function __construct(Channel $channel, string $report)
    {
        $this->channel = $channel;
        $this->report = $report;
    }
}
