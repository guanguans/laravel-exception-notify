<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-exception-notify.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

use Guanguans\LaravelExceptionNotify\ExceptionNotifyServiceProvider;
use Laravel\Lumen\Application;

it('can register', function (): void {
    /** @noinspection PhpVoidFunctionResultUsedInspection */
    /** @noinspection PhpParamsInspection */
    expect(new ExceptionNotifyServiceProvider(new Application))
        ->register()->toBeNull();
})->group(__DIR__, __FILE__);

it('can get provides', function (): void {
    expect(new ExceptionNotifyServiceProvider(app()))
        ->provides()->toBeArray();
})->group(__DIR__, __FILE__);
