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

use Guanguans\LaravelExceptionNotify\Commands\TestCommand;
use Guanguans\LaravelExceptionNotify\Exceptions\RuntimeException;
use Guanguans\LaravelExceptionNotify\Facades\ExceptionNotify;
use Guanguans\Notify\Foundation\Client;
use GuzzleHttp\Psr7\Response;
use Symfony\Component\Console\Command\Command;
use function Pest\Laravel\artisan;

afterEach(function (): void {
    app()->terminate();
});

it('can testing for when is not enabled', function (): void {
    config()->set('exception-notify.enabled', false);
    artisan(TestCommand::class)->assertExitCode(Command::INVALID);
})->group(__DIR__, __FILE__);

it('can testing for when should not report', function (): void {
    ExceptionNotify::skipWhen(
        static fn (Throwable $throwable): bool => $throwable instanceof RuntimeException
    );
    artisan(TestCommand::class)->assertExitCode(Command::INVALID);
})->group(__DIR__, __FILE__);

it('will throws RuntimeException', function (): void {
    artisan(TestCommand::class, [
        '--job-connection' => 'database',
    ]);
})->group(__DIR__, __FILE__)->throws(RuntimeException::class, 'This is a test.');

it('will catch RuntimeException and can report it', function (): void {
    try {
        artisan(TestCommand::class, [
            '--channel' => $channel = 'bark',
            '--job-connection' => 'sync',
            '--configuration' => 'app.name='.fake()->name(),
            '--verbose' => true,
        ]);
    } catch (RuntimeException $runtimeException) {
        ExceptionNotify::forgetDrivers();

        $extender = config($configurationKey = "exception-notify.channels.$channel.client.extender");

        config()->set(
            $configurationKey,
            static fn (Client $client): Client => $extender($client)->mock([
                new Response(body: \sprintf('{"code":200,"message":"%s","timestamp":1708331409}', fake()->text())),
            ])
        );

        expect(ExceptionNotify::report($runtimeException))->toBeNull();
    }
})->group(__DIR__, __FILE__);
