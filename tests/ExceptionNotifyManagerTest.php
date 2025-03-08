<?php

/** @noinspection NullPointerExceptionInspection */
/** @noinspection PhpVoidFunctionResultUsedInspection */
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

use Guanguans\LaravelExceptionNotify\Contracts\Channel;
use Guanguans\LaravelExceptionNotify\ExceptionNotifyManager;
use Guanguans\LaravelExceptionNotify\Exceptions\InvalidArgumentException;
use Guanguans\LaravelExceptionNotify\Exceptions\RuntimeException;
use Guanguans\LaravelExceptionNotify\Facades\ExceptionNotify;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

it('can call', function (): void {
    ExceptionNotifyManager::macro('foo', fn ($param) => $param);
    expect(app(ExceptionNotifyManager::class))
        ->foo('foo')->toBe('foo');
})->group(__DIR__, __FILE__);

it('will throw error', function (): void {
    try {
        app(ExceptionNotifyManager::class)->bar();
    } catch (Throwable $throwable) {
        expect($throwable)->toBeInstanceOf(Error::class);
    }
})->group(__DIR__, __FILE__);

it('can report if', function (): void {
    expect(app(ExceptionNotifyManager::class))
        ->reportIf(true, new RuntimeException)->toBeNull();
})->group(__DIR__, __FILE__);

it('can report', function (): void {
    config()->set('exception-notify.enabled', false);
    expect(app(ExceptionNotifyManager::class))
        ->report(new RuntimeException)->toBeNull();

    config()->set('exception-notify.enabled', true);
    // $mockApplication = Mockery::spy(Illuminate\Foundation\Application::class);
    // $mockApplication->allows()->make('config')->atLeast()->once()->andReturn(config());
    // $mockApplication->allows()->runningInConsole()->atLeast()->once()->andReturnFalse();
    (function (): void {
        $this->isRunningInConsole = false;
    })->call(app());
    expect(new ExceptionNotifyManager(app()))
        ->report(new RuntimeException)->toBeNull();

    config()->set('exception-notify.enabled', true);
    $mockApplication = Mockery::mock(Application::class);
    $mockApplication->allows('make')->with('config')->andReturn(config());
    // $mockApplication->allows('runningInConsole')->andReturnFalse();
    expect(new ExceptionNotifyManager($mockApplication))
        ->report(new RuntimeException)->toBeNull();
})->group(__DIR__, __FILE__);

it('should not report', function (): void {
    config()->set('exception-notify.enabled', false);
    expect(app(ExceptionNotifyManager::class))->shouldReport(new RuntimeException)->toBeFalse();

    config()->set('exception-notify.enabled', true);
    config()->set('exception-notify.environments', 'production');
    expect(app(ExceptionNotifyManager::class))->shouldReport(new RuntimeException)->toBeFalse();

    config()->set('exception-notify.enabled', true);
    config()->set('exception-notify.environments', '*');
    ExceptionNotify::skipWhen(static fn (Throwable $throwable) => Arr::first(
        [
            Exception::class,
        ],
        static fn (string $exception): bool => $throwable instanceof $exception
    ));
    expect(app(ExceptionNotifyManager::class))->shouldReport(new RuntimeException)->toBeFalse();
})->group(__DIR__, __FILE__);

it('should report', function (): void {
    expect(app(ExceptionNotifyManager::class))->shouldReport(new RuntimeException)->toBeTrue();
})->group(__DIR__, __FILE__);

it('can get default driver', function (): void {
    expect(app(ExceptionNotifyManager::class))
        ->getDefaultDriver()->toBeString();
})->group(__DIR__, __FILE__);

it('can attempt key', function (): void {
    $uuid = Str::uuid()->toString();
    expect(fn () => $this->attempt($uuid, 3))
        ->call(app(ExceptionNotifyManager::class))->toBeTrue()
        ->call(app(ExceptionNotifyManager::class))->toBeTrue()
        ->call(app(ExceptionNotifyManager::class))->toBeTrue()
        ->call(app(ExceptionNotifyManager::class))->toBeFalse();
})->group(__DIR__, __FILE__)->skip();

it('will throw `InvalidArgumentException`', function (): void {
    app(ExceptionNotifyManager::class)->driver('foo');
})->group(__DIR__, __FILE__)->throws(InvalidArgumentException::class);

it('can create custom driver', function (): void {
    app(ExceptionNotifyManager::class)->extend('foo', static fn (): Channel => new class implements Channel {
        public function report(Throwable $throwable): void {}

        public function reportRaw(string $report): mixed
        {
            return null;
        }
    });

    expect(app(ExceptionNotifyManager::class))->driver('foo')->toBeInstanceOf(Channel::class);
})->group(__DIR__, __FILE__);
