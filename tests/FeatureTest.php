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

use Guanguans\LaravelExceptionNotify\Exceptions\RuntimeException;
use Guanguans\LaravelExceptionNotify\Facades\ExceptionNotify;
use Illuminate\Http\UploadedFile;

it('can proactive report exception', function (): void {
    $this
        ->post('proactive-report-exception?foo=bar', [
            'bar' => 'baz',
            'password' => 'password',
            'file' => new UploadedFile(__FILE__, basename(__FILE__)),
        ])
        ->assertOk();
})->group(__DIR__, __FILE__);

it('can automatic report exception', function (): void {
    $this
        ->post('automatic-report-exception?foo=bar', [
            'bar' => 'baz',
            'password' => 'password',
            'file' => new UploadedFile(__FILE__, basename(__FILE__)),
        ])
        ->assertStatus(500);
})->group(__DIR__, __FILE__);

it('can all report exception', function (): void {
    collect(config('exception-notify.channels'))
        ->keys()
        ->each(function (string $channel): void {
            expect(ExceptionNotify::driver($channel))->report(new RuntimeException('testing'))->toBeNull();
        });
})->group(__DIR__, __FILE__);
