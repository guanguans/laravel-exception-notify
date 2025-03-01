<?php

/** @noinspection AnonymousFunctionStaticInspection */
/** @noinspection StaticClosureCanBeUsedInspection */

declare(strict_types=1);

/**
 * Copyright (c) 2021-2025 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-exception-notify
 */

use Guanguans\LaravelExceptionNotify\Commands\TestCommand;
use Guanguans\LaravelExceptionNotify\Facades\ExceptionNotify;
use Symfony\Component\Console\Command\Command;
use function Pest\Laravel\artisan;

afterEach(function (): void {
    app()->terminate();
});

it('can test for exception-notify when is not enabled', function (): void {
    config()->set('exception-notify.enabled', false);
    artisan(TestCommand::class)->assertExitCode(Command::INVALID);
})->group(__DIR__, __FILE__);

it('can test for exception-notify when default channels is empty', function (): void {
    config()->set('exception-notify.defaults', []);
    artisan(TestCommand::class)->assertExitCode(Command::INVALID);
})->group(__DIR__, __FILE__);

it('can test for exception-notify when should not report', function (): void {
    ExceptionNotify::skipWhen(
        static fn (\Throwable $throwable): bool => $throwable instanceof RuntimeException
    );
    artisan(TestCommand::class)->assertExitCode(Command::INVALID);
})->group(__DIR__, __FILE__);

it('will throws RuntimeException', function (): void {
    artisan(TestCommand::class, [
        '--channels' => ['bark', 'log'],
    ]);
})->group(__DIR__, __FILE__)->throws(RuntimeException::class, 'Test for exception-notify.');
