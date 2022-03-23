<?php

/**
 * This file is part of the guanguans/laravel-exception-notify.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelExceptionNotify\Channels;

use Guanguans\Notify\Contracts\MessageInterface;
use Guanguans\Notify\Messages\DiscordMessage;

class DiscordChannel extends NotifyChannel
{
    protected function createMessage(string $report): MessageInterface
    {
        $options = array_filter([
            'content' => $report,
            'username' => config('exception-notify.channels.discord.username'),
            'avatar_url' => config('exception-notify.channels.discord.avatar_url'),
            'tts' => config('exception-notify.channels.discord.tts'),
            'embeds' => config('exception-notify.channels.discord.embeds'),
        ], function ($option) {
            return ! blank($option);
        });

        return DiscordMessage::create($options);
    }
}
