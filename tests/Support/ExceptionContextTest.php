<?php

/** @noinspection AnonymousFunctionStaticInspection */
/** @noinspection NullPointerExceptionInspection */
/** @noinspection PhpInternalEntityUsedInspection */
/** @noinspection PhpUnhandledExceptionInspection */
/** @noinspection PhpVoidFunctionResultUsedInspection */
/** @noinspection StaticClosureCanBeUsedInspection */

declare(strict_types=1);

/**
 * Copyright (c) 2021-2026 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-exception-notify
 */

use Guanguans\LaravelExceptionNotify\Exceptions\RuntimeException;
use Guanguans\LaravelExceptionNotify\Support\ExceptionContext;

it('can get marked exception context', function (): void {
    expect(ExceptionContext::getMarked(new RuntimeException))->toBeArray();

    try {
        eval('throw new Exception("eval");');
    } catch (Exception $exception) {
        expect(ExceptionContext::getMarked($exception))->toBeArray();
    }
})->group(__DIR__, __FILE__);
