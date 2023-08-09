<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-exception-notify.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

use Illuminate\Http\UploadedFile;

it('can report exception', function (): void {
    $this
        ->post('report-exception?foo=bar&bar=baz', [
            'foo' => 'bar',
            'bar' => 'baz',
            'password' => 'password',
            'file' => new UploadedFile(__FILE__, basename(__FILE__)),
        ])
        ->assertOk();
})->group(__DIR__, __FILE__);

it('can auto report exception', function (): void {
    $this
        ->post('exception?foo=bar&bar=baz', [
            'foo' => 'bar',
            'bar' => 'baz',
            'password' => 'password',
            'file' => new UploadedFile(__FILE__, basename(__FILE__)),
        ])
        ->assertStatus(500);
})->group(__DIR__, __FILE__);
