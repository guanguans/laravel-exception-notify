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
