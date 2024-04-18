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
use Guanguans\Notify\Messages\DingTalk\TextMessage;

class DingTalkChannel extends NotifyChannel
{
    protected function createMessage(string $report): MessageInterface
    {
        return TextMessage::create(array_filter_filled([
            'content' => $report,
            'atMobiles' => config('exception-notify.channels.dingTalk.atMobiles'),
            'atDingtalkIds' => config('exception-notify.channels.dingTalk.atDingtalkIds'),
            'isAtAll' => config('exception-notify.channels.dingTalk.isAtAll'),
        ]));
    }
}
