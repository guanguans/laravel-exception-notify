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
use Illuminate\Support\Str;

use function Pest\Faker\faker;

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
        ->reportIf(true, new Exception)->toBeNull();
})->group(__DIR__, __FILE__);

it('can report', function (): void {
    config()->set('exception-notify.enabled', false);
    expect(app(ExceptionNotifyManager::class))
        ->report(new Exception)->toBeNull();

    config()->set('exception-notify.enabled', true);
    $mockApplication = Mockery::spy(Illuminate\Foundation\Application::class);
    // $mockApplication->allows()->make('config')->atLeast()->once()->andReturn(config());
    $mockApplication->allows()->runningInConsole()->atLeast()->once()->andReturnFalse();

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
    config()->set('exception-notify.enabled', false);
    expect(app(ExceptionNotifyManager::class))->shouldReport(new Exception)->toBeFalse();

    config()->set('exception-notify.enabled', true);
    config()->set('exception-notify.env', ['production', 'local']);
    expect(app(ExceptionNotifyManager::class))->shouldReport(new Exception)->toBeFalse();

    config()->set('exception-notify.enabled', true);
    config()->set('exception-notify.env', '*');
    config()->set('exception-notify.except', [Exception::class]);
    expect(app(ExceptionNotifyManager::class))->shouldReport(new Exception)->toBeFalse();

    config()->set('exception-notify.enabled', true);
    config()->set('exception-notify.env', '*');
    config()->set('exception-notify.except', []);
    expect(app(ExceptionNotifyManager::class))->shouldReport(new Exception)->toBeTrue();
})->group(__DIR__, __FILE__);

it('can get default driver', function (): void {
    expect(app(ExceptionNotifyManager::class))
        ->getDefaultDriver()->toBeString();
})->group(__DIR__, __FILE__);

it('can attempt key', function (): void {
    // $uuid = faker()->uuid();
    $uuid = Str::uuid()->toString();
    expect(fn () => $this->attempt($uuid, 3))
        ->call(app(ExceptionNotifyManager::class))->toBeTrue()
        ->call(app(ExceptionNotifyManager::class))->toBeTrue()
        ->call(app(ExceptionNotifyManager::class))->toBeTrue()
        ->call(app(ExceptionNotifyManager::class))->toBeFalse();
})->group(__DIR__, __FILE__);
