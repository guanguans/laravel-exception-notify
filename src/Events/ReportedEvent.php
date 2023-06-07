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

class ReportedEvent
{
    /**
     * @var \Guanguans\LaravelExceptionNotify\Contracts\Channel
     */
    public $channel;

    public $result;

    public function __construct(Channel $channel, $result)
    {
        $this->channel = $channel;
        $this->result = $result;
    }
}
