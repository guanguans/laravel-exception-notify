<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-exception-notify.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

use Guanguans\LaravelExceptionNotify\Collectors\RequestBasicCollector;

it('can collect request basic', function (): void {
    define('LARAVEL_START', microtime(true));

    expect(app(RequestBasicCollector::class))
        ->collect()->toBeArray();
})->group(__DIR__, __FILE__)->skip(defined('LARAVEL_START'));
