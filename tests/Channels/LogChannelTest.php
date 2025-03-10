<?php

/** @noinspection AnonymousFunctionStaticInspection */
/** @noinspection StaticClosureCanBeUsedInspection */

declare(strict_types=1);

/**
 * Copyright (c) 2021-2025 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-exception-notify
 */

use Guanguans\LaravelExceptionNotify\ExceptionNotifyManager;

it('can report', function (): void {
    expect($this->app->make(ExceptionNotifyManager::class)->driver('log'))
        ->report(new Exception('test'))
        ->toBeNull();
})->group(__DIR__, __FILE__);
