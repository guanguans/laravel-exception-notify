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
use Guanguans\Notify\Messages\WeWork\TextMessage;

class WeWorkChannel extends NotifyChannel
{
    protected function createMessage(string $report): MessageInterface
    {
        return TextMessage::create(array_filter_filled([
            'content' => $report,
            'mentioned_list' => config('exception-notify.channels.weWork.mentioned_list'),
            'mentioned_mobile_list' => config('exception-notify.channels.weWork.mentioned_mobile_list'),
        ]));
    }
}
