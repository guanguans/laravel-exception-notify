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
use Guanguans\Notify\Messages\QqChannelBotMessage;

class QqChannelBotChannel extends NotifyChannel
{
    protected function createMessage(string $report): MessageInterface
    {
        return QqChannelBotMessage::create(array_filter_filled([
            'content' => $report,
            'image' => config('exception-notify.channels.qqChannelBot.image'),
            'msg_id' => config('exception-notify.channels.qqChannelBot.msg_id'),
            'embed' => config('exception-notify.channels.qqChannelBot.embed'),
            'ark' => config('exception-notify.channels.qqChannelBot.ark'),
            'message_reference' => config('exception-notify.channels.qqChannelBot.message_reference'),
            'markdown' => config('exception-notify.channels.qqChannelBot.markdown'),
        ]));
    }
}
