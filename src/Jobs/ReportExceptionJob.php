<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-exception-notify.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelExceptionNotify\Jobs;

use Guanguans\LaravelExceptionNotify\Events\ReportedEvent;
use Guanguans\LaravelExceptionNotify\Events\ReportingEvent;
use Guanguans\LaravelExceptionNotify\ExceptionNotifyManager;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ReportExceptionJob implements ShouldQueue
{
    // use \Illuminate\Foundation\Bus\Dispatchable\Dispatchable;
    // use \Illuminate\Queue\SerializesModels;
    use InteractsWithQueue;
    use Queueable;

    /**
     * @var array<string, string>
     */
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

                event(new ReportingEvent($channel, $report));
                $result = $channel->report($report);
                event(new ReportedEvent($channel, $result));
            } catch (\Throwable $throwable) {
                app('log')->error($throwable->getMessage(), ['exception' => $throwable]);
            }
        }
    }
}
