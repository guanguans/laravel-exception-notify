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
use Guanguans\Notify\Messages\BarkMessage;

class BarkChannel extends NotifyChannel
{
    protected function createMessage(string $report): MessageInterface
    {
        return BarkMessage::create(array_filter_filled([
            'title' => config('exception-notify.title'),
            'body' => $report,
            'group' => config('exception-notify.channels.bark.group'),
            'copy' => config('exception-notify.channels.bark.copy'),
            'url' => config('exception-notify.channels.bark.url'),
            'sound' => config('exception-notify.channels.bark.sound'),
            'icon' => config('exception-notify.channels.bark.icon'),
            'level' => config('exception-notify.channels.bark.level'),
            'badge' => config('exception-notify.channels.bark.badge'),
            'isArchive' => config('exception-notify.channels.bark.isArchive'),
            'autoCopy' => config('exception-notify.channels.bark.autoCopy'),
            'automaticallyCopy' => config('exception-notify.channels.bark.automaticallyCopy'),
        ]));
    }
}
