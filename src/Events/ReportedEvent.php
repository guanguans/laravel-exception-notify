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

class ReportedEvent
{
    public ChannelContract $channel;

    /**
     * @var mixed
     */
    public $result;

    public function __construct(ChannelContract $channel, $result)
    {
        $this->channel = $channel;
        $this->result = $result;
    }
}
