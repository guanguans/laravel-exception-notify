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
use Guanguans\Notify\Messages\DingTalk\TextMessage;

class DingTalkChannel extends NotifyChannel
{
    protected function createMessage(string $report): MessageInterface
    {
        return TextMessage::create(array_filter_filled([
            'content' => $report,
            'atMobiles' => config('exception-notify.channels.dingTalk.atMobiles'),
            'atUserIds' => config('exception-notify.channels.dingTalk.atUserIds'),
            'isAtAll' => config('exception-notify.channels.dingTalk.isAtAll'),
        ]));
    }
}
