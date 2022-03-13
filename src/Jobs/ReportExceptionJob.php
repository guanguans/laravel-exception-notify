<?php

/**
 * This file is part of the guanguans/laravel-exception-notify.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelExceptionNotify\Jobs;

use Guanguans\LaravelExceptionNotify\Contracts\Channel;
use Guanguans\LaravelExceptionNotify\Events\ReportedEvent;
use Guanguans\LaravelExceptionNotify\Events\ReportingEvent;
use Guanguans\LaravelExceptionNotify\Support\Traits\CreateStatic;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Throwable;

class ReportExceptionJob implements ShouldQueue
{
    // use \Illuminate\Foundation\Bus\Dispatchable\Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;
    use CreateStatic;

    /**
     * 在超时之前任务可以运行的秒数.
     *
     * @var int
     */
    public $timeout = 30;

    /**
     * 任务可尝试的次数.
     *
     * @var int
     */
    public $tries = 3;

    /**
     * 任务失败前允许的最大异常数.
     *
     * @var int
     */
    public $maxExceptions = 3;

    /**
     * @var \Guanguans\LaravelExceptionNotify\Contracts\Channel
     */
    protected $channel;

    public function __construct(Channel $channel)
    {
        $this->channel = $channel;
    }

    /**
     * {@inheritdoc}
     */
    public function handle(string $report)
    {
        (new Pipeline(app()))
            ->send($report)
            ->through($this->getChannelPipeline())
            ->then(function ($report) {
                $this->fireReportingEvent($report);
                $result = $this->channel->report($report);
                $this->fireReportedEvent($result);
            });
    }

    protected function getChannelPipeline(): array
    {
        return array_merge(
            config('exception-notify.pipeline', []),
            config(sprintf('exception-notify.channels.%s.pipeline', $this->channel->getName()), [])
        );
    }

    protected function fireReportingEvent(string $report)
    {
        event(new ReportingEvent($this->channel, $report));
    }

    protected function fireReportedEvent($result)
    {
        event(new ReportedEvent($this->channel, $result));
    }

    /**
     * 任务未能处理.
     */
    public function failed(Throwable $e)
    {
        Log::error($e->getMessage(), ['exception' => $e]);
    }

    /**
     * 计算在重试任务之前需等待的秒数.
     */
    public function backoff()
    {
        return [1, 10, 30];
    }
}
