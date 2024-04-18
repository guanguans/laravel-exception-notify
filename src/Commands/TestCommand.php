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

use Guanguans\LaravelExceptionNotify\ExceptionNotifyManager;
use Guanguans\LaravelExceptionNotify\Exceptions\RuntimeException;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;

class TestCommand extends Command
{
    protected $signature = 'exception-notify:test';
    protected $description = 'Test for exception-notify';

    public function handle(ExceptionNotifyManager $exceptionNotifyManager): void
    {
        $this->output->note('Test for exception-notify start.');
        $this->output->section('The main configuration is as follows.');
        $this->output->listing($this->getMainConfigurations());

        try {
            $runtimeException = new RuntimeException('Test for exception-notify.');

            if ($exceptionNotifyManager->shouldReport($runtimeException)) {
                throw $runtimeException;
            }

            $warning = sprintf(
                'The exception [%s] should not be reported. Please check the configuration.',
                \get_class($runtimeException)
            );
        } finally {
            $this->output->warning(
                $warning ?? <<<'warning'
                    Please check whether your channels received the exception notification report.
                    If not, please find reason in the default log.
                    warning
            );

            $this->output->note('Test for exception-notify done.');
        }
    }

    private function getMainConfigurations(): array
    {
        $mainConfigurations = collect(config('exception-notify'))
            ->except(['collectors', 'title', 'channels'])
            ->transform(static function ($item) {
                if (\is_array($item)) {
                    if ([] === $item) {
                        return '[]';
                    }

                    if (array_is_list($item)) {
                        return implode(',', $item);
                    }

                    return $item;
                }

                /** @noinspection DebugFunctionUsageInspection */
                return var_export($item, true);
            });

        return collect(Arr::dot($mainConfigurations))
            ->transform(static fn (?string $item, string $key): string => sprintf(
                "$key: <fg=yellow>%s</>",
                $item ?? 'null'
            ))
            ->all();
    }
}
