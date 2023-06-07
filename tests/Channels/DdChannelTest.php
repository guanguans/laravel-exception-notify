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

use Guanguans\LaravelExceptionNotify\Channels\DdChannel;
use Guanguans\LaravelExceptionNotify\ExceptionNotifyManager;
use Guanguans\LaravelExceptionNotify\Tests\TestCase;

/**
 * @internal
 *
 * @small
 */
class DdChannelTest extends TestCase
{
    public function testReport(): void
    {
        $this->markTestSkipped(__METHOD__.' is skipped.');

        $channel = $this->app->make(ExceptionNotifyManager::class)->driver('dd');
        $this->assertInstanceOf(DdChannel::class, $channel);
        $this->expectOutputString('report');
        $channel->report('report');
    }
}
