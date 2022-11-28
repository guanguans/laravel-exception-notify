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

    /**
     * @var string
     */
    protected $report;

    /**
     * @var string
     */
    protected $pipedReport;

    public function __construct(Channel $channel, string $report)
    {
        $this->channel = $channel;
        $this->report = $report;
        $this->pipedReport = $this->pipelineReport($report);
    }

    public function handle(): void
    {
        $this->fireReportingEvent($this->pipedReport);
        $result = $this->channel->report($this->pipedReport);
        $this->fireReportedEvent($result);
    }

    /**
     * @return mixed[]
     */
    protected function getChannelPipeline(): array
    {
        return config(sprintf('exception-notify.channels.%s.pipeline', $this->channel->getName()), []);
    }

    protected function pipelineReport(string $report): string
    {
        return (new Pipeline(app()))
            ->send($report)
            ->through($this->getChannelPipeline())
            ->then(static function ($report) {
                return $report;
            });
    }

    protected function fireReportingEvent(string $report): void
    {
        event(new ReportingEvent($this->channel, $report));
    }

    protected function fireReportedEvent($result): void
    {
        event(new ReportedEvent($this->channel, $result));
    }

    /**
     * 任务未能处理.
     */
    public function failed(\Throwable $throwable): void
    {
        Log::error($throwable->getMessage(), ['exception' => $throwable]);
    }

    /**
     * 计算在重试任务之前需等待的秒数.
     *
     * @return int[]
     */
    public function backoff(): array
    {
        return [1, 10, 30];
    }
}
