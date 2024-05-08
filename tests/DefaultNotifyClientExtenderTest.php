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

namespace Guanguans\LaravelExceptionNotify\Tests;

use Guanguans\LaravelExceptionNotify\DefaultNotifyClientExtender;
use Guanguans\Notify\Foundation\Client;

it('can extend notify client', function (): void {
    expect(app(DefaultNotifyClientExtender::class)(new Client))->toBeInstanceOf(Client::class);
})->group(__DIR__, __FILE__);
