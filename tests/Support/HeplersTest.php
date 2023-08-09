<?php

/** @noinspection NullPointerExceptionInspection */

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-exception-notify.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

use Laravel\Lumen\Application;

it('can explode env', function (): void {
    expect(env_explode('ENV_EXPLODE_STRING'))->toBeArray()->toBeTruthy();
    expect(env_explode('ENV_EXPLODE_EMPTY'))->toBe(['']);
    expect(env_explode('ENV_EXPLODE_NOT_EXIST'))->toBeNull();
    // expect(env_explode('ENV_EXPLODE_TRUE'))->toBeTrue();
    // expect(env_explode('ENV_EXPLODE_FALSE'))->toBeFalse();
    // expect(env_explode('ENV_EXPLODE_NULL'))->toBeNull();
})->group(__DIR__, __FILE__);

it('can return Stringable', function (): void {
    expect(str())->toBeInstanceOf(Stringable::class);
    expect(str('foo'))->toBeInstanceOf(Illuminate\Support\Stringable::class);
})->group(__DIR__, __FILE__);

it('can is lumen', function (): void {
    expect(is_lumen())->toBeFalse();
    expect(is_lumen(app()))->toBeFalse();
    expect(is_lumen(app(Application::class)))->toBeTrue();
})->group(__DIR__, __FILE__);
