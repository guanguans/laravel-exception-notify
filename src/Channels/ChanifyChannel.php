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

use Guanguans\Notify\Contracts\MessageInterface;
use Guanguans\Notify\Messages\Chanify\TextMessage;

class ChanifyChannel extends NotifyChannel
{
    protected function createMessage(string $report): MessageInterface
    {
        return TextMessage::create(array_filter_filled([
            'title' => config('exception-notify.title'),
            'text' => $report,
            'copy' => config('exception-notify.channels.chanify.copy'),
            'actions' => config('exception-notify.channels.chanify.actions'),
            'autocopy' => config('exception-notify.channels.chanify.autocopy'),
            'sound' => config('exception-notify.channels.chanify.sound'),
            'priority' => config('exception-notify.channels.chanify.priority'),
        ]));
    }
}
