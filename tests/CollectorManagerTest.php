<?php

declare(strict_types=1);

/**
 * Copyright (c) 2021-2024 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-exception-notify
 */

use Guanguans\LaravelExceptionNotify\CollectorManager;
use Guanguans\LaravelExceptionNotify\Exceptions\InvalidArgumentException;

it('will throw `InvalidArgumentException`', function (): void {
    /** @noinspection PhpParamsInspection */
    new CollectorManager(['foo']);
})->group(__DIR__, __FILE__)->throws(InvalidArgumentException::class);
