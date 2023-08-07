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

it('can report', function (): void {
    expect($this->app->make(ExceptionNotifyManager::class)->driver('null'))
        ->report('report')
        ->toBeNull();
})->group(__DIR__, __FILE__);
