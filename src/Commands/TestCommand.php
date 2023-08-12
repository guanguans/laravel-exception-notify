<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-exception-notify.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
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

    private ?string $error = null;

    public function __destruct()
    {
        if ($this->error) {
            $this->output->error($this->error);

            return;
        }

        $this->output->newLine();
        $this->output->note(
            <<<'note'
                Test for exception-notify done.
                Please check whether your channels received the exception notification report.
                If not, please find reason in the default log.
                note
        );
    }

    public function handle(ExceptionNotifyManager $exceptionNotifyManager): void
    {
        $this->output->note('Test for exception-notify start.');
        $this->output->section('The current main configuration is as follows:');
        $this->output->listing($this->getMainConfigurations());

        $runtimeException = new RuntimeException('Test for exception-notify.');
        if ($exceptionNotifyManager->shouldReport($runtimeException)) {
            throw $runtimeException;
        }

        $this->error = sprintf(
            'The exception [%s] should not be reported. Please check the configuration.',
            \get_class($runtimeException)
        );
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
