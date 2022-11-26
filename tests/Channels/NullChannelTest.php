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

use Guanguans\LaravelExceptionNotify\Channels\NullChannel;
use Guanguans\LaravelExceptionNotify\ExceptionNotifyManager;
use Guanguans\LaravelExceptionNotify\Tests\TestCase;

class NullChannelTest extends TestCase
{
    public function testReport(): void
    {
        $channel = $this->app->make(ExceptionNotifyManager::class)->driver('null');
        $this->assertInstanceOf(NullChannel::class, $channel);
        $this->assertNull($channel->report('report'));
    }
}
