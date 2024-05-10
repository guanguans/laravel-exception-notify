<?php

/** @noinspection PhpUnhandledExceptionInspection */
/** @noinspection PhpInternalEntityUsedInspection */
/** @noinspection AnonymousFunctionStaticInspection */
/** @noinspection StaticClosureCanBeUsedInspection */
/** @noinspection NullPointerExceptionInspection */

declare(strict_types=1);

/**
 * Copyright (c) 2021-2024 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-exception-notify
 */

use Guanguans\LaravelExceptionNotify\CollectorManager;
use Guanguans\LaravelExceptionNotify\ExceptionNotifyManager;

it('can make object', function (): void {
    expect(make(ExceptionNotifyManager::class))->toBeInstanceOf(ExceptionNotifyManager::class)
        ->and(make(CollectorManager::class))->toBeInstanceOf(CollectorManager::class);
})->group(__DIR__, __FILE__);

it('can explode env', function (): void {
    expect(env_explode('ENV_EXPLODE_STRING'))->toBeArray()->toBeTruthy()
        ->and(env_explode('ENV_EXPLODE_EMPTY'))->toBe([])
        ->and(env_explode('ENV_EXPLODE_NOT_EXIST'))->toBeNull();
    // ->and(env_explode('ENV_EXPLODE_TRUE'))->toBeTrue()
    // ->and(env_explode('ENV_EXPLODE_FALSE'))->toBeFalse()
    // ->and(env_explode('ENV_EXPLODE_NULL'))->toBeNull()
})->group(__DIR__, __FILE__);

it('can human bytes', function (): void {
    expect([
        human_bytes(0),
        human_bytes(10),
        human_bytes(10000),
        human_bytes(10000000),
    ])->sequence(
        static fn (Pest\Expectation $expectation): Pest\Expectation => $expectation->toBe('0B'),
        static fn (Pest\Expectation $expectation): Pest\Expectation => $expectation->toBe('10B'),
        static fn (Pest\Expectation $expectation): Pest\Expectation => $expectation->toBe('9.77kB'),
        static fn (Pest\Expectation $expectation): Pest\Expectation => $expectation->toBe('9.54MB')
    );
})->group(__DIR__, __FILE__);

it('can human milliseconds', function (): void {
    expect([
        human_milliseconds(0),
        human_milliseconds(0.5),
        human_milliseconds(500),
        human_milliseconds(500000),
    ])->sequence(
        static fn (Pest\Expectation $expectation): Pest\Expectation => $expectation->toBe('0μs'),
        static fn (Pest\Expectation $expectation): Pest\Expectation => $expectation->toBe('500μs'),
        static fn (Pest\Expectation $expectation): Pest\Expectation => $expectation->toBe('500ms'),
        static fn (Pest\Expectation $expectation): Pest\Expectation => $expectation->toBe('500s')
    );
})->group(__DIR__, __FILE__);
