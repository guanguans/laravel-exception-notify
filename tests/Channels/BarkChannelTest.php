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

use Guanguans\LaravelExceptionNotify\Channels\BarkChannel;
use Guanguans\LaravelExceptionNotify\ExceptionNotifyManager;
use Guanguans\LaravelExceptionNotify\Tests\TestCase;
use Guanguans\Notify\Contracts\MessageInterface;
use Nyholm\NSA;

class BarkChannelTest extends TestCase
{
    public function testCreateMessage(): void
    {
        $m = \Mockery::mock(BarkChannel::class);
        $m->shouldAllowMockingProtectedMethods()
            ->shouldReceive('createMessage')
            ->once()
            ->with('report')
            ->andReturn(\Mockery::mock(MessageInterface::class));
        $this->assertInstanceOf(BarkChannel::class, $m);
        $this->assertInstanceOf(MessageInterface::class, $m->createMessage('report'));

        $channel = $this->app->make(ExceptionNotifyManager::class)->driver('bark');
        $this->assertInstanceOf(BarkChannel::class, $channel);
        $this->assertInstanceOf(MessageInterface::class, NSA::invokeMethod($channel, 'createMessage', 'report'));
    }

    public function testReport(): void
    {
        $m = \Mockery::mock(BarkChannel::class);
        $m->shouldAllowMockingProtectedMethods()
            ->shouldReceive('report')
            ->once()
            ->with('report')
            ->andReturnNull();
        $this->assertInstanceOf(BarkChannel::class, $m);
        $this->assertNull($m->report('report'));

        $channel = $this->app->make(ExceptionNotifyManager::class)->driver('bark');
        $this->assertInstanceOf(BarkChannel::class, $channel);
        $this->expectException(\GuzzleHttp\Exception\ClientException::class);
        $channel->report('report');
    }
}
