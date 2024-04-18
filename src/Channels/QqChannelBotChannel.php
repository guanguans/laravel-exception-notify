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
