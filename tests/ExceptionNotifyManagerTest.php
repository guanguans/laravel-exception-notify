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
use Illuminate\Contracts\Foundation\Application;

use function Pest\Faker\faker;

it('can call', function (): void {
    ExceptionNotifyManager::macro('foo', fn ($param) => $param);
    expect($this->app->make(ExceptionNotifyManager::class))
        ->foo('foo')->toBe('foo');
})->group(__DIR__, __FILE__);

it('will throw error', function (): void {
    try {
        $this->app->make(ExceptionNotifyManager::class)->bar();
    } catch (Throwable $throwable) {
        expect($throwable)->toBeInstanceOf(Error::class);
    }
})->group(__DIR__, __FILE__);

it('can report if', function (): void {
    expect($this->app->make(ExceptionNotifyManager::class))
        ->reportIf(true, new Exception)->toBeNull();
})->group(__DIR__, __FILE__);

it('can report', function (): void {
    config()->set('exception-notify.enabled', false);
    expect($this->app->make(ExceptionNotifyManager::class))
        ->report(new Exception)->toBeNull();

    config()->set('exception-notify.enabled', true);
    $mockApplication = Mockery::spy(Application::class);
    // $mockApplication->allows('make')->with('config')->andReturn(config());
    $mockApplication->allows('runningInConsole')->andReturnFalse();

    /** @noinspection PhpVoidFunctionResultUsedInspection */
    expect(new ExceptionNotifyManager($mockApplication))
        ->report(new Exception)->toBeNull();

    config()->set('exception-notify.enabled', true);
    $mockApplication = Mockery::mock(Application::class);
    $mockApplication->allows('make')->with('config')->andReturn(config());
    // $mockApplication->allows('runningInConsole')->andReturnFalse();

    /** @noinspection PhpVoidFunctionResultUsedInspection */
    expect(new ExceptionNotifyManager($mockApplication))
        ->report(new Exception)->toBeNull();
})->group(__DIR__, __FILE__);

it('should not report', function (): void {
    $shouldntReporter = fn () => $this->shouldntReport(new Exception);

    config()->set('exception-notify.enabled', false);
    expect($shouldntReporter)
        ->call($this->app->make(ExceptionNotifyManager::class))->toBeTrue();

    config()->set('exception-notify.enabled', true);
    config()->set('exception-notify.env', ['production', 'local']);
    expect($shouldntReporter)
        ->call($this->app->make(ExceptionNotifyManager::class))->toBeTrue();

    config()->set('exception-notify.enabled', true);
    config()->set('exception-notify.env', '*');
    config()->set('exception-notify.except', [Exception::class]);
    expect($shouldntReporter)
        ->call($this->app->make(ExceptionNotifyManager::class))->toBeTrue();

    config()->set('exception-notify.enabled', true);
    config()->set('exception-notify.env', '*');
    config()->set('exception-notify.except', []);
    config()->set('exception-notify.rate_limit.max_attempts', 1);
    expect($shouldntReporter)
        ->call($this->app->make(ExceptionNotifyManager::class))->toBeFalse()
        ->call($this->app->make(ExceptionNotifyManager::class))->toBeFalse();
})->group(__DIR__, __FILE__);

it('can get default driver', function (): void {
    expect($this->app->make(ExceptionNotifyManager::class))
        ->getDefaultDriver()->toBeString();
})->group(__DIR__, __FILE__);

it('can attempt key', function (): void {
    $uuid = faker()->uuid();
    expect(fn () => $this->attempt($uuid, 3))
        ->call($this->app->make(ExceptionNotifyManager::class))->toBeTrue()
        ->call($this->app->make(ExceptionNotifyManager::class))->toBeTrue()
        ->call($this->app->make(ExceptionNotifyManager::class))->toBeTrue()
        ->call($this->app->make(ExceptionNotifyManager::class))->toBeFalse();
})->group(__DIR__, __FILE__);
