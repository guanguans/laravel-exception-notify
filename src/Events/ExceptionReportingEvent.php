<?php

declare(strict_types=1);

/**
 * Copyright (c) 2021-2024 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-exception-notify
 */

namespace Guanguans\LaravelExceptionNotify\Events;

use Guanguans\LaravelExceptionNotify\Contracts\Channel;

class ExceptionReportingEvent
{
    public Channel $channel;
    public string $report;

    public function __construct(Channel $channel, string $report)
    {
        $this->channel = $channel;
        $this->report = $report;
    }
}
