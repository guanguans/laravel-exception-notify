<?php

/**
 * This file is part of the guanguans/laravel-exception-notify.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelExceptionNotify\Jobs;

use Guanguans\Notify\Clients\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Throwable;

class SendExceptionNotification implements ShouldQueue
{
    // use \Illuminate\Foundation\Bus\Dispatchable\Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

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
     * @var \Guanguans\Notify\Clients\Client
     */
    protected $client;

    /**
     * SendExceptionNotification constructor.
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * {@inheritdoc}
     */
    public function handle()
    {
        $response = $this->client->send();

        config('exception-notify.debug') and Log::debug('Exception notify debugging: ', $response);
    }

    /**
     * 任务未能处理.
     */
    public function failed(Throwable $exception)
    {
        Log::error($exception->getMessage());
    }

    /**
     * 计算在重试任务之前需等待的秒数.
     */
    public function backoff()
    {
        return [1, 10, 30];
    }
}
