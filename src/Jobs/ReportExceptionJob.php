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

namespace Guanguans\LaravelExceptionNotify\Jobs;

use Guanguans\LaravelExceptionNotify\Events\ExceptionReportedEvent;
use Guanguans\LaravelExceptionNotify\Events\ExceptionReportingEvent;
use Guanguans\LaravelExceptionNotify\ExceptionNotifyManager;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ReportExceptionJob implements ShouldQueue
{
    // use SerializesModels;
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;

    /** @var array<string, string> */
    private array $reports;

    public function __construct(array $reports)
    {
        $this->reports = $reports;

        $this->onConnection(config('exception-notify.job.connection'));

        if ($queue = config('exception-notify.job.queue')) {
            $this->onQueue($queue);
        }
    }

    public function handle(ExceptionNotifyManager $exceptionNotifyManager): void
    {
        foreach ($this->reports as $name => $report) {
            try {
                $channel = $exceptionNotifyManager->driver($name);

                event(new ExceptionReportingEvent($channel, $report));
                $result = $channel->report($report);
                event(new ExceptionReportedEvent($channel, $result));
            } catch (\Throwable $throwable) {
                Log::error($throwable->getMessage(), ['exception' => $throwable]);
            }
        }
    }
}
