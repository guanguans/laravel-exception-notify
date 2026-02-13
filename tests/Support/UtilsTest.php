<?php

/** @noinspection AnonymousFunctionStaticInspection */
/** @noinspection NullPointerExceptionInspection */
/** @noinspection PhpInternalEntityUsedInspection */
/** @noinspection PhpUnhandledExceptionInspection */
/** @noinspection PhpVoidFunctionResultUsedInspection */
/** @noinspection StaticClosureCanBeUsedInspection */

declare(strict_types=1);

/**
 * Copyright (c) 2021-2026 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-exception-notify
 */

use Guanguans\LaravelExceptionNotify\Mail\ReportExceptionMail;
use Guanguans\LaravelExceptionNotify\Support\Utils;
use Guanguans\LaravelExceptionNotifyTests\Fixtures\MailableExtender;
use Pest\Expectation;

it('can apply configuration to object', function (): void {
    expect(Utils::applyConfigurationToObject(
        new ReportExceptionMail($this->faker()->title(), $this->faker()->text()),
        [
            'render' => 'value',
            'theme' => 'default',
            'extender' => MailableExtender::class,
        ]
    ))->toBeInstanceOf(ReportExceptionMail::class);
})->group(__DIR__, __FILE__);

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
        Utils::humanMilliseconds(0.05),
        Utils::humanMilliseconds(50),
        Utils::humanMilliseconds(50000),
        Utils::humanMilliseconds(50000000),
    ])->sequence(
        static fn (Expectation $expectation): Expectation => $expectation->toBe('50µs'),
        static fn (Expectation $expectation): Expectation => $expectation->toBe('50ms'),
        static fn (Expectation $expectation): Expectation => $expectation->toBe('50s'),
        static fn (Expectation $expectation): Expectation => $expectation->toBe('13h, 53m, 20s')
    );
})->group(__DIR__, __FILE__);
