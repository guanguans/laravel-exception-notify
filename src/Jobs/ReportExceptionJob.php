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

namespace Guanguans\LaravelExceptionNotify\Jobs;

use Guanguans\LaravelExceptionNotify\ExceptionNotifyManager;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;

class ReportExceptionJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;

    public function __construct(
        private string $channel,
        private string $content
    ) {
        $this->onConnection(config('exception-notify.job.connection'));

        if ($queue = config('exception-notify.job.queue')) {
            $this->onQueue($queue);
        }
    }

    public function handle(ExceptionNotifyManager $exceptionNotifyManager): void
    {
        $exceptionNotifyManager->driver($this->channel)->reportContent($this->content);
    }
}
