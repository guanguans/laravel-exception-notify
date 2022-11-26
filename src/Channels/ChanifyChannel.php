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
