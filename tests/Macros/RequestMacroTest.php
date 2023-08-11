<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-exception-notify.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

use Illuminate\Http\Request;

it('can get headers', function (): void {
    expect($this->app->make(Request::class))
        ->headers()->toBeArray()
        ->headers('user-agent')->toBeString();
})->group(__DIR__, __FILE__);
