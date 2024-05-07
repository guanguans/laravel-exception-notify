<?php

/** @noinspection AnonymousFunctionStaticInspection */
/** @noinspection StaticClosureCanBeUsedInspection */

declare(strict_types=1);

/**
 * Copyright (c) 2021-2024 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-exception-notify
 */

use Illuminate\Http\Request;

it('can get headers', function (): void {
    expect($this->app->make(Request::class))
        ->headers()->toBeArray()
        ->headers('user-agent')->toBeString();
})->group(__DIR__, __FILE__);
