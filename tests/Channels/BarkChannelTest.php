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
use GuzzleHttp\Exception\ClientException;
use Nyholm\NSA;

/**
 * @internal
 *
 * @small
 */
class BarkChannelTest extends TestCase
{
    public function testCreateMessage(): void
    {
        $this->markTestSkipped('TODO');
        $legacyMock = \Mockery::mock(BarkChannel::class);
        $legacyMock->shouldAllowMockingProtectedMethods()
            ->shouldReceive('createMessage')
            ->once()
            ->with('report')
            ->andReturn(\Mockery::mock(MessageInterface::class));
        $this->assertInstanceOf(BarkChannel::class, $legacyMock);
        // $this->assertInstanceOf(MessageInterface::class, $legacyMock->createMessage('report'));

        $channel = $this->app->make(ExceptionNotifyManager::class)->driver('bark');
        $this->assertInstanceOf(BarkChannel::class, $channel);
        // $this->assertInstanceOf(MessageInterface::class, NSA::invokeMethod($channel, 'createMessage', 'report'));
    }

    public function testReport(): void
    {
        $legacyMock = \Mockery::mock(BarkChannel::class);
        $legacyMock->shouldAllowMockingProtectedMethods()
            ->shouldReceive('report')
            ->once()
            ->with('report')
            ->andReturnNull();
        $this->assertInstanceOf(BarkChannel::class, $legacyMock);
        $this->assertNull($legacyMock->report('report'));

        $channel = $this->app->make(ExceptionNotifyManager::class)->driver('bark');
        $this->assertInstanceOf(BarkChannel::class, $channel);
        $this->expectException(ClientException::class);
        $channel->report('report');
    }
}
