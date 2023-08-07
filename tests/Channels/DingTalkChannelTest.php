<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-exception-notify.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

use Guanguans\LaravelExceptionNotify\ExceptionNotifyManager;
use Guanguans\Notify\Contracts\MessageInterface;

it('can create message', function (): void {
    expect((fn () => $this->createMessage('report'))->call(
        $this
            ->app
            ->make(ExceptionNotifyManager::class)
            ->driver('dingTalk')
    ))->toBeInstanceOf(MessageInterface::class);
})->group(__DIR__, __FILE__);
