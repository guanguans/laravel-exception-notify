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
    protected $signature = 'exception-notify:test {--c|channel= : The channel of report exception}';

    /** @noinspection ClassOverridesFieldOfSuperClassInspection */
    protected $description = 'Testing for exception-notify';

    public function handle(ExceptionNotifyManager $exceptionNotifyManager): int
    {
        $this->output->info('Testing for exception-notify start.');

        if (!config($configurationKey = 'exception-notify.enabled')) {
            $this->output->warning("The value of this configuration [$configurationKey] is false, please configure it to true.");

            return self::INVALID;
        }

        $runtimeException = new RuntimeException('Testing for exception-notify.');

        if (!$exceptionNotifyManager->shouldReport($runtimeException)) {
            $this->output->warning(\sprintf(
                'The exception [%s] should not be reported, please check the configuration.',
                $runtimeException::class
            ));

            return self::INVALID;
        }

        try {
            throw $runtimeException;
        } finally {
            $this->laravel->terminating(function () use ($runtimeException): void {
                $this->output->warning(\sprintf(
                    <<<'warning'
                        The exception [%s] has been thrown.
                        Please check whether the channel [%s] has received an exception report.
                        If not, please find the reason in the default log channel.
                        warning,
                    $runtimeException::class,
                    config('exception-notify.default'),
                ));
                $this->output->success('Testing for exception-notify done.');
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
