<?php

/** @noinspection AnonymousFunctionStaticInspection */
/** @noinspection DebugFunctionUsageInspection */
/** @noinspection ForgottenDebugOutputInspection */
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

use Guanguans\LaravelExceptionNotify\Events\ReportedEvent;
use Guanguans\LaravelExceptionNotify\Events\ReportingEvent;
use Guanguans\LaravelExceptionNotify\ExceptionNotifyManager;
use Guanguans\LaravelExceptionNotify\Exceptions\RuntimeException;
use Guanguans\LaravelExceptionNotify\Facades\ExceptionNotify;
use Illuminate\Support\Facades\Log;

it('can not report', function (): void {
    config()->set('exception-notify.rate_limiter.max_attempts', 0);
    expect($this->app->make(ExceptionNotifyManager::class))
        ->report(new RuntimeException('testing'))
        ->toBeNull();
})->group(__DIR__, __FILE__);

it('can listen reporting and reported event', function (): void {
    ExceptionNotify::reporting(function (ReportingEvent $reportingEvent): void {
        Log::info($reportingEvent::class);
    });

    ExceptionNotify::reported(function (ReportedEvent $reportedEvent): void {
        Log::info($reportedEvent::class);
    });

    expect($this->app->make(ExceptionNotifyManager::class))
        ->report(new RuntimeException('testing'))
        ->toBeNull();
})->group(__DIR__, __FILE__);

it('can attempt Exception', function (): void {
    config()->set('exception-notify.rate_limiter.max_attempts', 3);
    expect(fn () => $this->attempt(new RuntimeException(microtime())))
        ->call($logChannel = resolve(ExceptionNotifyManager::class)->channel('log'))->toBeTrue()
        ->call($logChannel)->toBeTrue()
        ->call($logChannel)->toBeTrue()
        ->call($logChannel)->toBeFalse();
})->group(__DIR__, __FILE__);

it('are same fingerprints for exceptions of throw in the same position', function (): void {
    collect(range(1, 10))
        ->map(fn (): string => (fn () => $this->fingerprintFor(new RuntimeException(microtime())))->call(ExceptionNotify::driver('log')))
        ->reduce(static function (?string $previousFingerprint, string $fingerprint): string {
            $previousFingerprint and expect($previousFingerprint)->toBe($fingerprint);

            return $fingerprint;
        });
})->group(__DIR__, __FILE__);
