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
use Guanguans\Notify\Messages\BarkMessage;

class BarkChannel extends NotifyChannel
{
    protected function createMessage(string $report): MessageInterface
    {
        $options = array_filter([
            'title' => config('exception-notify.title'),
            'body' => $report,
            'group' => config(sprintf('exception-notify.channels.%s.group', $this->getName())),
            'copy' => config(sprintf('exception-notify.channels.%s.copy', $this->getName())),
            'url' => config(sprintf('exception-notify.channels.%s.url', $this->getName())),
            'sound' => config(sprintf('exception-notify.channels.%s.sound', $this->getName())),
            'icon' => config(sprintf('exception-notify.channels.%s.icon', $this->getName())),
            'level' => config(sprintf('exception-notify.channels.%s.level', $this->getName())),
            'badge' => config(sprintf('exception-notify.channels.%s.badge', $this->getName())),
            'isArchive' => config(sprintf('exception-notify.channels.%s.isArchive', $this->getName())),
            'autoCopy' => config(sprintf('exception-notify.channels.%s.autoCopy', $this->getName())),
            'automaticallyCopy' => config(sprintf('exception-notify.channels.%s.automaticallyCopy', $this->getName())),
        ], function ($option) {
            return ! blank($option);
        });

        return new BarkMessage($options);
    }
}
