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
use Guanguans\Notify\Messages\DiscordMessage;

class DiscordChannel extends NotifyChannel
{
    protected function createMessage(string $report): MessageInterface
    {
        return DiscordMessage::create(array_filter_filled([
            'content' => $report,
            'username' => config('exception-notify.channels.discord.username'),
            'avatar_url' => config('exception-notify.channels.discord.avatar_url'),
            'tts' => config('exception-notify.channels.discord.tts'),
            'embeds' => config('exception-notify.channels.discord.embeds'),
        ]));
    }
}
