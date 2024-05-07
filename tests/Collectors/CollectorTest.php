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

use Guanguans\LaravelExceptionNotify\Collectors\RequestBasicCollector;

it('can collect request basic', function (): void {
    \define('LARAVEL_START', microtime(true));

    expect(app(RequestBasicCollector::class))
        ->collect()->toBeArray();
})->group(__DIR__, __FILE__)->skip(\defined('LARAVEL_START'));
