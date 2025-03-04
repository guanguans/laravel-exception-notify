<?php

/** @noinspection PhpUnhandledExceptionInspection */
/** @noinspection PhpInternalEntityUsedInspection */
/** @noinspection AnonymousFunctionStaticInspection */
/** @noinspection StaticClosureCanBeUsedInspection */
/** @noinspection NullPointerExceptionInspection */

declare(strict_types=1);

/**
 * Copyright (c) 2021-2025 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-exception-notify
 */

use Guanguans\LaravelExceptionNotify\Exceptions\InvalidArgumentException;

it('will throw `InvalidArgumentException` when abstract is empty array', function (): void {
    \Guanguans\LaravelExceptionNotify\Support\make([]);
})->group(__DIR__, __FILE__)->throws(InvalidArgumentException::class);

it('can explode env', function (): void {
    expect([
        \Guanguans\LaravelExceptionNotify\Support\env_explode('ENV_EXPLODE_STRING'),
        \Guanguans\LaravelExceptionNotify\Support\env_explode('ENV_EXPLODE_EMPTY'),
        \Guanguans\LaravelExceptionNotify\Support\env_explode('ENV_EXPLODE_NOT_EXIST'),
        // env_explode('ENV_EXPLODE_FALSE'),
        // env_explode('ENV_EXPLODE_NULL'),
        // env_explode('ENV_EXPLODE_TRUE'),
    ])->sequence(
        static fn (Pest\Expectation $expectation): Pest\Expectation => $expectation->toBeArray()->toBeTruthy(),
        static fn (Pest\Expectation $expectation): Pest\Expectation => $expectation->toBeArray()->toBeFalsy(),
        static fn (Pest\Expectation $expectation): Pest\Expectation => $expectation->toBeNull(),
        // static fn (Pest\Expectation $expectation): Pest\Expectation => $expectation->toBeFalse(),
        // static fn (Pest\Expectation $expectation): Pest\Expectation => $expectation->toBeNull(),
        // static fn (Pest\Expectation $expectation): Pest\Expectation => $expectation->toBeTrue(),
    );
})->group(__DIR__, __FILE__);

it('can human bytes', function (): void {
    expect([
        \Guanguans\LaravelExceptionNotify\Support\human_bytes(0),
        \Guanguans\LaravelExceptionNotify\Support\human_bytes(10),
        \Guanguans\LaravelExceptionNotify\Support\human_bytes(10000),
        \Guanguans\LaravelExceptionNotify\Support\human_bytes(10000000),
    ])->sequence(
        static fn (Pest\Expectation $expectation): Pest\Expectation => $expectation->toBe('0B'),
        static fn (Pest\Expectation $expectation): Pest\Expectation => $expectation->toBe('10B'),
        static fn (Pest\Expectation $expectation): Pest\Expectation => $expectation->toBe('9.77kB'),
        static fn (Pest\Expectation $expectation): Pest\Expectation => $expectation->toBe('9.54MB')
    );
})->group(__DIR__, __FILE__);

it('can human milliseconds', function (): void {
    expect([
        \Guanguans\LaravelExceptionNotify\Support\human_milliseconds(0),
        \Guanguans\LaravelExceptionNotify\Support\human_milliseconds(0.5),
        \Guanguans\LaravelExceptionNotify\Support\human_milliseconds(500),
        \Guanguans\LaravelExceptionNotify\Support\human_milliseconds(500000),
    ])->sequence(
        static fn (Pest\Expectation $expectation): Pest\Expectation => $expectation->toBe('0μs'),
        static fn (Pest\Expectation $expectation): Pest\Expectation => $expectation->toBe('500μs'),
        static fn (Pest\Expectation $expectation): Pest\Expectation => $expectation->toBe('500ms'),
        static fn (Pest\Expectation $expectation): Pest\Expectation => $expectation->toBe('500s')
    );
})->group(__DIR__, __FILE__);
