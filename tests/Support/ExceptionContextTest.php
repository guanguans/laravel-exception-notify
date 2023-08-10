<?php

/** @noinspection NullPointerExceptionInspection */

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-exception-notify.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

use Guanguans\LaravelExceptionNotify\Support\ExceptionContext;

it('can get marked exception context', function (): void {
    expect(ExceptionContext::getMarked(new Exception()))->toBeArray();

    try {
        eval('throw new Exception("eval");');
    } catch (Exception $exception) {
        expect(ExceptionContext::getMarked($exception))->toBeArray();
    }
})->group(__DIR__, __FILE__);
