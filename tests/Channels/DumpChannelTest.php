<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-exception-notify.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

use Guanguans\LaravelExceptionNotify\Channels\DumpChannel;
use Guanguans\LaravelExceptionNotify\ExceptionNotifyManager;

it('report', function (): void {
    $channel = $this->app->make(ExceptionNotifyManager::class)->driver('dump');
    expect($channel)->toBeInstanceOf(DumpChannel::class);

    // $this->expectOutputString('report');
    // $channel->report('report');
    expect($channel->report('report'))->toBe('report');
});
