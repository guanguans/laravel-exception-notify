<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-exception-notify.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelExceptionNotify\Channels;

use Guanguans\LaravelExceptionNotify\Contracts\ChannelContract;

class LogChannel implements ChannelContract
{
    protected string $level;

    protected string $channel;

    public function __construct(string $channel = 'daily', string $level = 'error')
    {
        $this->channel = $channel;
        $this->level = $level;
    }

    public function report(string $report): void
    {
        app('log')->channel($this->channel)->log($this->level, $report);
    }
}
