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
use Illuminate\Support\Facades\Log;

class ReportExceptionJob implements ShouldQueue
{
    // use \Illuminate\Foundation\Bus\Dispatchable\Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    protected array $reports;

    public function __construct(array $reports)
    {
        $this->reports = $reports;

        $this->onConnection(config('exception-notify.job.connection'));

        if ($queue = config('exception-notify.job.queue')) {
            $this->onQueue($queue);
        }
    }

    /**
     * @noinspection PhpUnreachableStatementInspection
     */
    public function handle(): void
    {
        foreach ($this->reports as $channelName => $report) {
            /** @var ChannelContract $channel */
            $channel = ExceptionNotify::driver($channelName);

            event(new ReportingEvent($channel, $report));
            $result = $channel->report($report);
            event(new ReportedEvent($channel, $result));
        }
    }

    /**
     * 任务未能处理.
     */
    public function failed(\Throwable $throwable): void
    {
        Log::error($throwable->getMessage(), ['exception' => $throwable]);
    }
}
