<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-exception-notify.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelExceptionNotify\Tests\Channels;

use Guanguans\LaravelExceptionNotify\Channels\SlackChannel;
use Guanguans\LaravelExceptionNotify\ExceptionNotifyManager;
use Guanguans\LaravelExceptionNotify\Tests\TestCase;
use Guanguans\Notify\Contracts\MessageInterface;
use Nyholm\NSA;

/**
 * @internal
 *
 * @small
 */
class SlackChannelTest extends TestCase
{
    public function testCreateMessage(): void
    {
        $channel = $this->app->make(ExceptionNotifyManager::class)->driver('slack');
        $this->assertInstanceOf(SlackChannel::class, $channel);
        $this->assertInstanceOf(MessageInterface::class, NSA::invokeMethod($channel, 'createMessage', 'report'));
    }
}
