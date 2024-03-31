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

it('can get provides', function (): void {
    expect(new ExceptionNotifyServiceProvider(app()))
        ->provides()->toBeArray();
})->group(__DIR__, __FILE__);
