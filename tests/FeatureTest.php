<?php

declare(strict_types=1);

/**
 * Copyright (c) 2021-2024 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-exception-notify
 */

use Guanguans\LaravelExceptionNotify\Facades\ExceptionNotify;
use Illuminate\Http\UploadedFile;

it('can report exception', function (): void {
    ExceptionNotify::report(new \Exception('What happened?'), ['lark']);
    $this
        ->post('report-exception?foo=bar', [
            'bar' => 'baz',
            'password' => 'password',
            'file' => new UploadedFile(__FILE__, basename(__FILE__)),
        ])
        ->assertOk();
})->group(__DIR__, __FILE__);

it('can auto report exception', function (): void {
    $this
        ->post('exception?foo=bar', [
            'bar' => 'baz',
            'password' => 'password',
            'file' => new UploadedFile(__FILE__, basename(__FILE__)),
        ])
        ->assertStatus(500);
})->group(__DIR__, __FILE__);
