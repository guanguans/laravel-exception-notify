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

use Guanguans\LaravelExceptionNotify\ExceptionNotifyServiceProvider;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use function Pest\Laravel\artisan;

it('can add section to about command', function (): void {
    artisan('about');
})->group(__DIR__, __FILE__)->throws(FileNotFoundException::class);

it('can get provides', function (): void {
    expect(new ExceptionNotifyServiceProvider(app()))
        ->provides()->toBeArray();
})->group(__DIR__, __FILE__);
