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

use Guanguans\LaravelExceptionNotify\Contracts\ChannelContract;
use Guanguans\LaravelExceptionNotify\Events\ReportedEvent;
use Guanguans\LaravelExceptionNotify\Events\ReportingEvent;
use Guanguans\LaravelExceptionNotify\Facades\ExceptionNotify;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ReportExceptionJob implements ShouldQueue
{
    // use \Illuminate\Foundation\Bus\Dispatchable\Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * 任务可尝试的次数
     */
    public int $tries = 1;

    /**
     * 在超时之前任务可以运行的秒数
     */
    public int $timeout = 30;

    /**
     * 重试任务前等待的秒数
     */
    public int $retryAfter = 300;

    /**
     * @var array<string, string>
     */
    private array $reports;

    private ?\Throwable $lastThrowable = null;

    public function __construct(array $reports)
    {
        $this->reports = $reports;

        $this->onConnection(config('exception-notify.job.connection'));

        if ($queue = config('exception-notify.job.queue')) {
            $this->onQueue($queue);
        }

        if ($tries = config('exception-notify.job.tries')) {
            $this->tries = $tries;
        }

        if ($timeout = config('exception-notify.job.timeout')) {
            $this->timeout = $timeout;
        }

        if ($retryAfter = config('exception-notify.job.retry_after')) {
            $this->retryAfter = $retryAfter;
        }
    }

    /**
     * @throws \Throwable
     */
    public function handle(): void
    {
        foreach ($this->reports as $name => $report) {
            try {
                /** @var ChannelContract $channel */
                $channel = ExceptionNotify::driver($name);

                event(new ReportingEvent($channel, $report));
                $result = $channel->report($report);
                event(new ReportedEvent($channel, $result));
            } catch (\Throwable $throwable) {
                $this->lastThrowable = $throwable;
            }
        }

        if ($this->lastThrowable instanceof \Throwable) {
            throw $this->lastThrowable;
        }
    }
}
