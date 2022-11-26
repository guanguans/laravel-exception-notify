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
use Guanguans\Notify\Messages\SlackMessage;

class SlackChannel extends NotifyChannel
{
    protected function createMessage(string $report): MessageInterface
    {
        return SlackMessage::create(array_filter_filled([
            'text' => $report,
            'channel' => config('exception-notify.channels.slack.channel'),
            'username' => config('exception-notify.channels.slack.username'),
            'icon_emoji' => config('exception-notify.channels.slack.icon_emoji'),
            'icon_url' => config('exception-notify.channels.slack.icon_url'),
            'unfurl_links' => config('exception-notify.channels.slack.unfurl_links'),
            'attachments' => config('exception-notify.channels.slack.attachments'),
        ]));
    }
}
