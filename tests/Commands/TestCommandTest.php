<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-exception-notify.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

use Guanguans\LaravelExceptionNotify\Commands\TestCommand;
use Symfony\Component\Console\Command\Command;

use function Pest\Laravel\artisan;

it('can test for exception-notify', function (): void {
    config()->set('exception-notify.enabled', false);
    artisan(TestCommand::class)->assertExitCode(Command::SUCCESS);
})->group(__DIR__, __FILE__);

it('will throws RuntimeException', function (): void {
    artisan(TestCommand::class);
})->group(__DIR__, __FILE__)->throws(RuntimeException::class, 'Test for exception-notify.');
