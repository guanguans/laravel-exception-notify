<?php

declare(strict_types=1);

/**
 * Copyright (c) 2021-2024 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-exception-notify
 */

namespace Guanguans\LaravelExceptionNotify\Commands;

use Guanguans\LaravelExceptionNotify\DefaultNotifyClientExtender;
use Guanguans\LaravelExceptionNotify\ExceptionNotifyManager;
use Guanguans\LaravelExceptionNotify\Exceptions\RuntimeException;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TestCommand extends Command
{
    protected $signature = 'exception-notify:test {--c|channels=* : Specify channels to test}';
    protected $description = 'Test for exception-notify';

    public function handle(ExceptionNotifyManager $exceptionNotifyManager): int
    {
        $this->output->info('Test for exception-notify start.');

        if (!config('exception-notify.enabled')) {
            $this->output->warning('The exception-notify is not enabled. Please enable it first.');

            return self::INVALID;
        }

        if (empty(config('exception-notify.defaults'))) {
            $this->output->warning('The exception-notify default channels is empty. Please configure it first.');

            return self::INVALID;
        }

        $runtimeException = new RuntimeException('Test for exception-notify.');

        if (!$exceptionNotifyManager->shouldReport($runtimeException)) {
            $this->output->warning(sprintf(
                <<<'warning'
                    The exception [%s] should not be reported.
                    Please check the configuration.
                    warning,
                \get_class($runtimeException)
            ));

            return self::INVALID;
        }

        try {
            throw $runtimeException;
        } finally {
            $this->laravel->terminating(function (): void {
                $this->output->section('Current default channels:');
                $this->output->listing($defaults = config('exception-notify.defaults'));
                $this->output->warning(sprintf(
                    <<<'warning'
                        An exception has been thrown to trigger the exception notification monitor.
                        Please check whether your channels(%s) received the exception notification reports.
                        If not, please find reason in the default log.
                        warning,
                    implode('、', $defaults)
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
        if ($channels = $this->option('channels')) {
            config()->set('exception-notify.defaults', $channels);
        }

        collect(config('exception-notify.channels'))
            ->only(config('exception-notify.defaults'))
            ->each(static function (array $config, string $name): void {
                if ('notify' === $config['driver']) {
                    config()->set("exception-notify.channels.$name.client.extender", DefaultNotifyClientExtender::class);
                }
            });
    }
}
