<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-exception-notify.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

use Guanguans\LaravelExceptionNotify\Channels\NullChannel;
use Guanguans\LaravelExceptionNotify\ExceptionNotifyManager;

it('report', function (): void {
    $channel = $this->app->make(ExceptionNotifyManager::class)->driver('null');
    expect($channel)->toBeInstanceOf(NullChannel::class);
    expect($channel->report('report'))->toBeNull();
});
