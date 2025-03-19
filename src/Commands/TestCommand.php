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
    use Configureable {
        Configureable::initialize as configureableInitialize;
    }

    /** @noinspection ClassOverridesFieldOfSuperClassInspection */
    protected $signature = <<<'SIGNATURE'
        exception-notify:test
        {--c|channel= : Specify channel to test}
        SIGNATURE;

    /** @noinspection ClassOverridesFieldOfSuperClassInspection */
    protected $description = 'Test for exception-notify';

    public function handle(ExceptionNotifyManager $exceptionNotifyManager): int
    {
        $this->output->info('Test for exception-notify start.');

        if (!config($configurationKey = 'exception-notify.enabled')) {
            $this->output->warning("The configuration [$configurationKey] is false. Please configure it to true.");

            return self::INVALID;
        }

        if (!app()->environment($environments = config('exception-notify.environments'))) {
            $this->output->warning(\sprintf(
                <<<'warning'
                    The current environment is [%s], which is not in the configuration [%s].
                    Please check the configuration.
                    warning,
                app()->environment(),
                implode('、', $environments)
            ));

            return self::INVALID;
        }

        $runtimeException = new RuntimeException('Test for exception-notify.');

        if (!$exceptionNotifyManager->shouldReport($runtimeException)) {
            $this->output->warning(\sprintf(
                <<<'warning'
                    The exception [%s] should not be reported.
                    Please check the configuration.
                    warning,
                $runtimeException::class
            ));

            return self::INVALID;
        }

        try {
            throw $runtimeException;
        } finally {
            $this->laravel->terminating(function (): void {
                $this->output->section(\sprintf('The current channel: %s', $default = config('exception-notify.default')));
                $this->output->section(\sprintf('The current job : %s', config('exception-notify.job.connection')));
                $this->output->warning(\sprintf(
                    <<<'warning'
                        An exception has been thrown to trigger the exception notification monitor.
                        Please check whether your channel [%s] received the exception notification reports.
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
     * @noinspection PhpMissingParentCallCommonInspection
     */
    protected function initialize(InputInterface $input, OutputInterface $output): void
    {
        $this->configureableInitialize($input, $output);

        $channel = $this->option('channel') and config()->set('exception-notify.default', $channel);

        collect(config('exception-notify.channels'))->each(function (array $configuration, string $name): void {
            if ('notify' === ($configuration['driver'] ?? $name)) {
                config()->set(
                    "exception-notify.channels.$name.client.extender",
                    function (Client $client): Client {
                        $client->push(Middleware::log(Log::channel(), new MessageFormatter(MessageFormatter::DEBUG), 'debug'));

                        if ($this->output->isVerbose()) {
                            $client->before(
                                \Guanguans\Notify\Foundation\Middleware\Response::class,
                                Middleware::mapResponse(static fn (Response $response): Response => $response->dump()),
                            );
                        }

                        return $client;
                    }
                );
            }
        });
    }
}
