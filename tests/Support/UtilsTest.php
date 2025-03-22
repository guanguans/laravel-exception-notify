<?php

/** @noinspection AnonymousFunctionStaticInspection */
/** @noinspection NullPointerExceptionInspection */
/** @noinspection PhpInternalEntityUsedInspection */
/** @noinspection PhpUnhandledExceptionInspection */
/** @noinspection PhpVoidFunctionResultUsedInspection */
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

use Guanguans\LaravelExceptionNotify\Support\Utils;
use Pest\Expectation;

it('can human bytes', function (): void {
    expect([
        Utils::humanBytes(0),
        Utils::humanBytes(10),
        Utils::humanBytes(10000),
        Utils::humanBytes(10000000),
    ])->sequence(
        static fn (Expectation $expectation): Expectation => $expectation->toBe('0 B'),
        static fn (Expectation $expectation): Expectation => $expectation->toBe('10 B'),
        static fn (Expectation $expectation): Expectation => $expectation->toBe('9.77 KB'),
        static fn (Expectation $expectation): Expectation => $expectation->toBe('9.54 MB')
    );
})->group(__DIR__, __FILE__);

it('can human milliseconds', function (): void {
    expect([
        Utils::humanMilliseconds(0),
        Utils::humanMilliseconds(0.5),
        Utils::humanMilliseconds(500),
        Utils::humanMilliseconds(500000),
    ])->sequence(
        static fn (Expectation $expectation): Expectation => $expectation->toBe('0 μs'),
        static fn (Expectation $expectation): Expectation => $expectation->toBe('500 μs'),
        static fn (Expectation $expectation): Expectation => $expectation->toBe('500 ms'),
        static fn (Expectation $expectation): Expectation => $expectation->toBe('500 s')
    );
})->group(__DIR__, __FILE__);
