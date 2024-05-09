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
use Guanguans\LaravelExceptionNotify\Exceptions\RuntimeException;
use Illuminate\Console\Command;

class TestCommand extends Command
{
    protected $signature = 'exception-notify:test {--c|channels=* : Specify channels to test}';
    protected $description = 'Test for exception-notify';

    public function handle(): void
    {
        if ($channels = $this->option('channels')) {
            config()->set('exception-notify.defaults', $channels);
        }

        collect(config('exception-notify.channels'))
            ->only($defaults = config('exception-notify.defaults'))
            ->each(static function (array $config, string $name): void {
                if ('notify' === $config['driver']) {
                    config()->set("exception-notify.channels.$name.client.extender", DefaultNotifyClientExtender::class);
                }
            });

        $this->output->note('Test for exception-notify start.');
        $this->output->section('Current default channels:');
        $this->output->listing($defaults);

        try {
            $this->output->warning(sprintf(
                <<<'warning'
                    Let's throw an exception to trigger exception notification monitoring.
                    Please check whether your channels(%s) received the exception notification reports.
                    If not, please find reason in the default log.
                    warning,
                implode('、', $defaults)
            ));

            throw new RuntimeException('Test for exception-notify.');
        } finally {
            $this->output->note('Test for exception-notify done.');
        }
    }
}
