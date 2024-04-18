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
