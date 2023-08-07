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

it('report exception', function (): void {
    $this->post('report-exception?foo=bar&bar=baz', [
        'foo' => 'bar',
        'bar' => 'baz',
        'file' => new UploadedFile(__FILE__, basename(__FILE__)),
    ])->assertSuccessful();
})->group(__DIR__, __FILE__);
