<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-exception-notify.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

use Guanguans\LaravelExceptionNotify\Channels\BarkChannel;
use Guanguans\LaravelExceptionNotify\ExceptionNotifyManager;
use Guanguans\Notify\Contracts\MessageInterface;
use GuzzleHttp\Exception\ClientException;
use Nyholm\NSA;

it('create message', function (): void {
    $this->markTestSkipped('TODO');
    $legacyMock = Mockery::mock(BarkChannel::class);
    $legacyMock->shouldAllowMockingProtectedMethods()
        ->shouldReceive('createMessage')
        ->once()
        ->with('report')
        ->andReturn(Mockery::mock(MessageInterface::class));
    expect($legacyMock)->toBeInstanceOf(BarkChannel::class);

    // $this->assertInstanceOf(MessageInterface::class, $legacyMock->createMessage('report'));
    $channel = $this->app->make(ExceptionNotifyManager::class)->driver('bark');
    expect($channel)->toBeInstanceOf(BarkChannel::class);
    // $this->assertInstanceOf(MessageInterface::class, NSA::invokeMethod($channel, 'createMessage', 'report'));
});

it('report', function (): void {
    $legacyMock = Mockery::mock(BarkChannel::class);
    $legacyMock->shouldAllowMockingProtectedMethods()
        ->shouldReceive('report')
        ->once()
        ->with('report')
        ->andReturnNull();
    expect($legacyMock)->toBeInstanceOf(BarkChannel::class);
    expect($legacyMock->report('report'))->toBeNull();

    $channel = $this->app->make(ExceptionNotifyManager::class)->driver('bark');
    expect($channel)->toBeInstanceOf(BarkChannel::class);
    $this->expectException(ClientException::class);
    $channel->report('report');
});
