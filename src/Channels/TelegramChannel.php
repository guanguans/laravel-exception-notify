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
use Guanguans\Notify\Messages\Telegram\TextMessage;

class TelegramChannel extends NotifyChannel
{
    protected function createMessage(string $report): MessageInterface
    {
        return TextMessage::create(array_filter_filled([
            'chat_id' => config('exception-notify.channels.telegram.chat_id'),
            'text' => $report,
            'parse_mode' => config('exception-notify.channels.telegram.parse_mode'),
            'entities' => config('exception-notify.channels.telegram.entities'),
            'disable_web_page_preview' => config('exception-notify.channels.telegram.disable_web_page_preview'),
            'disable_notification' => config('exception-notify.channels.telegram.disable_notification'),
            'protect_content' => config('exception-notify.channels.telegram.protect_content'),
            'reply_to_message_id' => config('exception-notify.channels.telegram.reply_to_message_id'),
            'allow_sending_without_reply' => config('exception-notify.channels.telegram.allow_sending_without_reply'),
            'reply_markup' => config('exception-notify.channels.telegram.reply_markup'),
        ]));
    }
}
