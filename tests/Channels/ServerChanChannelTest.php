<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-exception-notify.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

use Guanguans\LaravelExceptionNotify\Channels\ServerChanChannel;
use Guanguans\LaravelExceptionNotify\ExceptionNotifyManager;
use Guanguans\Notify\Contracts\MessageInterface;
use Nyholm\NSA;

it('create message', function (): void {
    $channel = $this->app->make(ExceptionNotifyManager::class)->driver('serverChan');
    expect($channel)->toBeInstanceOf(ServerChanChannel::class);
    // $this->assertInstanceOf(MessageInterface::class, NSA::invokeMethod($channel, 'createMessage', 'report'));
});
