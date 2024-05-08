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

use Guanguans\LaravelExceptionNotify\Commands\TestCommand;
use function Pest\Laravel\artisan;

it('can test for exception-notify', function (): void {
    config()->set('exception-notify.enabled', false);
    artisan(TestCommand::class)->assertSuccessful();
})->group(__DIR__, __FILE__);

it('will throws RuntimeException', function (): void {
    artisan(TestCommand::class);
})->group(__DIR__, __FILE__)->throws(RuntimeException::class, 'Test for exception-notify.');
