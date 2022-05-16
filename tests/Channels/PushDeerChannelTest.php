<?php

/**
 * This file is part of the guanguans/laravel-exception-notify.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelExceptionNotify\Tests\Channels;

use Guanguans\LaravelExceptionNotify\Channels\PushDeerChannel;
use Guanguans\LaravelExceptionNotify\ExceptionNotifyManager;
use Guanguans\LaravelExceptionNotify\Tests\TestCase;
use Guanguans\Notify\Contracts\MessageInterface;
use Nyholm\NSA;

class PushDeerChannelTest extends TestCase
{
    public function testCreateMessage()
    {
        $channel = $this->app->make(ExceptionNotifyManager::class)->driver('pushDeer');
        $this->assertInstanceOf(PushDeerChannel::class, $channel);
        $this->assertInstanceOf(MessageInterface::class, NSA::invokeMethod($channel, 'createMessage', 'report'));
    }
}
