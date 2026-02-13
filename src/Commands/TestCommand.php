<?php

declare(strict_types=1);

/**
 * Copyright (c) 2021-2026 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-exception-notify
 */

namespace Guanguans\LaravelExceptionNotify\Commands;

use Guanguans\LaravelExceptionNotify\Commands\Concerns\Configurable;
use Guanguans\LaravelExceptionNotify\ExceptionNotifyManager;
use Guanguans\LaravelExceptionNotify\Exceptions\RuntimeException;
use Guanguans\LaravelExceptionNotify\Support\Utils;
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
    use Configurable {
        Configurable::initialize as configurableInitialize;
    }

    /** @noinspection ClassOverridesFieldOfSuperClassInspection */
    protected $signature = <<<'SIGNATURE'
        exception-notify:test
        {--c|channel= : The channel of report exception}
        {--job-connection= : The connection of report exception job}
        SIGNATURE;

    /** @noinspection ClassOverridesFieldOfSuperClassInspection */
    protected $description = 'Test whether exception can be monitored and reported to notification channel';

    /**
     * @throws \ReflectionException
     */
    public function handle(ExceptionNotifyManager $exceptionNotifyManager): int
    {
        if (!config($configurationKey = 'exception-notify.enabled')) {
            $this->components->warn(\sprintf(
                'The value of this configuration [%s] is false, please configure it to true.',
                $this->warned($configurationKey)
            ));

            return self::INVALID;
        }

        $runtimeException = new RuntimeException('This is a test.');

        if (!$exceptionNotifyManager->shouldReport($runtimeException)) {
            $this->components->warn(\sprintf(
                'The exception [%s] should not be reported, please check the related configuration:',
                $this->warned($runtimeException::class),
            ));

            $this->components->bulletList([
                'exception-notify.environments',
                'exception-notify.rate_limiter',
            ]);

            return self::INVALID;
        }

        try {
            throw $runtimeException;
        } finally {
            $this->laravel->terminating(function () use ($runtimeException): void {
                $this->components->warn(\sprintf(
                    'The exception [%s] has been thrown.',
                    $this->warned($runtimeException::class)
                ));
                $this->components->warn(\sprintf(
                    'Please check whether the exception-notify channel [%s] has received an exception report.',
                    $this->warned(config('exception-notify.default'))
                ));
                $this->components->warn(\sprintf(
                    'If not, please find the reason in the default log channel [%s].',
                    $this->warned(config('logging.default'))
                ));

                if (!Utils::isSyncJobConnection()) {
                    $this->components->warn(\sprintf(
                        'Or please ensure that the queue is working [%s].',
                        $this->warned(\sprintf(
                            'php artisan queue:work %s --queue=%s --ansi -v',
                            Utils::jobConnection(),
                            Utils::jobQueue()
                        ))
                    ));
                }

                $this->components->info('Testing done.');
            });
        }
    }

    /**
     * @noinspection MethodVisibilityInspection
     * @noinspection PhpMissingParentCallCommonInspection
     */
    protected function initialize(InputInterface $input, OutputInterface $output): void
    {
        $this->configurableInitialize($input, $output);

        $channel = $this->option('channel') and config()->set('exception-notify.default', $channel);
        $connection = $this->option('job-connection') and config()->set('exception-notify.job.connection', $connection);

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

    private function warned(string $string): string
    {
        return "<fg=yellow;options=bold>$string</>";
    }
}
