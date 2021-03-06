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
use Guanguans\Notify\Messages\XiZhiMessage;

class XiZhiChannel extends NotifyChannel
{
    protected function createMessage(string $content): MessageInterface
    {
        return new XiZhiMessage(config('exception-notify.title'), $content);
    }
}
