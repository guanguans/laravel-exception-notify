<?php

/**
 * This file is part of the guanguans/laravel-exception-notify.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelExceptionNotify\Tests\Channels;

use Guanguans\LaravelExceptionNotify\Channels\DingTalkChannel;
use Guanguans\LaravelExceptionNotify\ExceptionNotifyManager;
use Guanguans\LaravelExceptionNotify\Tests\TestCase;
use Guanguans\Notify\Contracts\MessageInterface;
use Nyholm\NSA;

class DingTalkChannelTest extends TestCase
{
    public function testCreateMessage()
    {
        $channel = $this->app->make(ExceptionNotifyManager::class)->driver('dingTalk');
        $this->assertInstanceOf(DingTalkChannel::class, $channel);
        $this->assertInstanceOf(MessageInterface::class, NSA::invokeMethod($channel, 'createMessage', 'report'));
    }
}
