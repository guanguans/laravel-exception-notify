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
