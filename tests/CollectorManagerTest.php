<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-exception-notify.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

use Guanguans\LaravelExceptionNotify\CollectorManager;
use Guanguans\LaravelExceptionNotify\Exceptions\InvalidArgumentException;

it('will throw `InvalidArgumentException`', function (): void {
    /** @noinspection PhpParamsInspection */
    new CollectorManager(['foo']);
})->group(__DIR__, __FILE__)->throws(InvalidArgumentException::class);

it('can map to reports', function (): void {
    expect(new CollectorManager([]))
        ->mapToReports(['null', 'log'], new Exception())->toBeArray();
})->group(__DIR__, __FILE__);
