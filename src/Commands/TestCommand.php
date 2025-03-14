<?php

declare(strict_types=1);

/**
 * Copyright (c) 2021-2025 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-exception-notify
 */

namespace Guanguans\LaravelExceptionNotify\Commands;

use Guanguans\LaravelExceptionNotify\Commands\Concerns\Configureable;
use Guanguans\LaravelExceptionNotify\ExceptionNotifyManager;
use Guanguans\LaravelExceptionNotify\Exceptions\RuntimeException;
use Guanguans\Notify\Foundation\Client;
use Guanguans\Notify\Foundation\Response;
use GuzzleHttp\MessageFormatter;
use GuzzleHttp\Middleware;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TestCommand extends Command
{
    use Configureable;
    protected $signature = <<<'SIGNATURE'
        exception-notify:test
        {--c|channel=* : Specify channel to test}
        {--j|job-connection=* : Specify job connection to test}
        SIGNATURE;
    protected $description = 'Test for exception-notify';

    public function handle(ExceptionNotifyManager $exceptionNotifyManager): int
    {
        $this->output->info('Test for exception-notify start.');

        if (!config('exception-notify.enabled')) {
            $this->output->warning('The exception-notify is not enabled. Please enable it first.');

            return self::INVALID;
        }

        if (blank(config('exception-notify.default'))) {
            $this->output->warning('The exception-notify default channel is empty. Please configure it first.');

            return self::INVALID;
        }

        $runtimeException = new RuntimeException('Test for exception-notify.');

        if (!$exceptionNotifyManager->shouldReport($runtimeException)) {
            $this->output->warning(\sprintf(
                <<<'warning'
                    The exception [%s] should not be reported.
                    Please check the configuration.
                    warning,
                RuntimeException::class
            ));

            return self::INVALID;
        }

        try {
            throw $runtimeException;
        } finally {
            $this->laravel->terminating(function (): void {
                $this->output->section($default = \sprintf('Current default channel: %s', config('exception-notify.default')));
                $this->output->warning(\sprintf(
                    <<<'warning'
                        An exception has been thrown to trigger the exception notification monitor.
                        Please check whether your channel(%s) received the exception notification reports.
                        If not, please find reason in the default log.
                        warning,
                    $default
                ));
                $this->output->success('Test for exception-notify done.');
            });
        }
    }

    /**
     * @noinspection MethodVisibilityInspection
     */
    protected function initialize(InputInterface $input, OutputInterface $output): void
    {
        $channel = $this->option('channel') and config()->set('exception-notify.default', $channel);
        $connection = $this->option('job-connection') and config()->set('exception-notify.job.connection', $connection);

        collect(config('exception-notify.channels'))->each(static function (array $config, string $name): void {
            if ('notify' === ($config['driver'] ?? $name)) {
                config()->set(
                    "exception-notify.channels.$name.client.extender",
                    static fn (Client $client): Client => $client
                        // ->before(
                        //     \Guanguans\Notify\Foundation\Middleware\Response::class,
                        //     Middleware::mapResponse(static fn (Response $response): Response => $response->dump()),
                        // )
                        ->push(Middleware::log(Log::channel(), new MessageFormatter(MessageFormatter::DEBUG), 'debug'))
                );
            }
        });
    }
}
