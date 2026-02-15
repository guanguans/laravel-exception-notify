<?php

/** @noinspection AnonymousFunctionStaticInspection */
/** @noinspection NullPointerExceptionInspection */
/** @noinspection PhpFieldAssignmentTypeMismatchInspection */
/** @noinspection PhpPossiblePolymorphicInvocationInspection */
/** @noinspection PhpUndefinedClassInspection */
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

use Guanguans\LaravelExceptionNotify\Collectors\RequestBasicCollector;
use Illuminate\Support\Facades\Request;

it('can collect request basic', function (): void {
    // $defined = $this->getFunctionMock(class_namespace(RequestBasicCollector::class), 'defined');
    // $defined->expects($this->once())->willReturn(false);

    Request::spy()
        ->allows('server')
        ->withArgs(['REQUEST_TIME_FLOAT'])
        ->once()
        ->andReturnNull();

    expect(resolve(RequestBasicCollector::class))
        ->collect()->toBeArray();
})->group(__DIR__, __FILE__);
