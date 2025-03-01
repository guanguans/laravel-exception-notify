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

use Composer\Semver\Comparator;
use Guanguans\LaravelExceptionNotify\ExceptionNotifyManager;
use Illuminate\Foundation\Application;

it('can report', function (): void {
    expect($this->app->make(ExceptionNotifyManager::class)->driver('log'))
        ->report('report')
        ->toBeNull();
})->group(__DIR__, __FILE__)->skip(
    Comparator::greaterThanOrEqualTo(Application::VERSION, '9.0.0')
    && Comparator::lessThan(Application::VERSION, '10.0.0')
);
