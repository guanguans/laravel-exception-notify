<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-exception-notify.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

use Guanguans\LaravelExceptionNotify\Channels\DdChannel;
use Guanguans\LaravelExceptionNotify\ExceptionNotifyManager;

it('report', function (): void {
    $this->markTestSkipped(__METHOD__.' is skipped.');

    $channel = $this->app->make(ExceptionNotifyManager::class)->driver('dd');
    expect($channel)->toBeInstanceOf(DdChannel::class);
    $this->expectOutputString('report');
    $channel->report('report');
});
