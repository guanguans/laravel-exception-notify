<?php

/**
 * This file is part of the guanguans/laravel-exception-notify.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelExceptionNotify;

use Exception;
use Guanguans\LaravelExceptionNotify\Jobs\ExceptionMessageSendJob;
use Guanguans\Notify\Clients\Client;
use Guanguans\Notify\Clients\DingTalkClient;
use Guanguans\Notify\Clients\FeiShuClient;
use Guanguans\Notify\Clients\ServerChanClient;
use Guanguans\Notify\Clients\WeWorkClient;
use Guanguans\Notify\Clients\XiZhiClient;
use Guanguans\Notify\Factory;
use Guanguans\Notify\Messages\Message;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use Throwable;

class Notifier extends BaseObject
{
    protected const MARKDOWN_TEMPLATE = <<<'md'
``` text
%s
```
md;

    /**
     * @var string
     */
    public $default;

    /**
     * @var bool
     */
    public $debug;

    /**
     * @var bool[]
     */
    public $collector = [
        'app_name' => true,
        'app_env' => true,
        'trigger_time' => true,
        'request_method' => true,
        'request_url' => true,
        'request_ip' => true,
        'request_data' => true,
        'exception_trace' => true,
    ];

    /**
     * @var array[]
     */
    public $channels = [];

    /**
     * @var \Guanguans\Notify\Clients\Client
     */
    protected $client;

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        $options = $this->channels[$this->default];

        unset($options['keyword']);

        ! $this->client instanceof Client and $this->client = Factory::{$this->default}($options);
    }

    public function report(Exception $exception)
    {
        try {
            dispatch(new ExceptionMessageSendJob(
                tap($this->client, function (Client $client) use ($exception) {
                    $information = $this->collectInformation($exception);

                    $message = $this->createMessage($this->formatInformation($information));

                    $client->setMessage($message);
                })
            ));
        } catch (Throwable $e) {
            Log::error($e->getMessage());
        }
    }

    protected function formatInformation(array $information): string
    {
        return trim(array_reduce($information, function ($carry, $item) {
            return $carry.$item.PHP_EOL;
        }, ''));
    }

    protected function collectInformation(Exception $exception): array
    {
        return array_merge($this->collectExtraInformation(), $this->collectExceptionInformation($exception));
    }

    protected function collectExceptionInformation(Exception $exception): array
    {
        return array_filter([
            sprintf('Exception Class: %s', get_class($exception)),
            sprintf('Exception Message: %s', $exception->getMessage()),
            sprintf('Exception Code: %s', $exception->getCode()),
            sprintf('Exception File: %s', $exception->getFile()),
            sprintf('Exception Line: %s', $exception->getLine()),
            $this->collector['exception_trace'] ? sprintf('Exception Trace: %s', $exception->getTraceAsString()) : '',
        ]);
    }

    protected function collectExtraInformation(): array
    {
        return array_filter([
            $this->collector['app_name'] ? sprintf('Application Name: %s', config('app.name')) : '',
            $this->collector['app_env'] ? sprintf('Application Environment: %s', config('app.env')) : '',
            $this->collector['trigger_time'] ? sprintf('Trigger Time: %s', Carbon::now()->toDateTimeString()) : '',
            $this->collector['request_method'] ? sprintf('Request method: %s', Request::method()) : '',
            $this->collector['request_url'] ? sprintf('Request Url: %s', Request::fullUrl()) : '',
            $this->collector['request_ip'] ? sprintf('Request IP: %s', Request::ip()) : '',
            $this->collector['request_data'] ? sprintf('Request Data: %s', var_export(Request::all(), true)) : '',
            isset($this->channels[$this->default]['keyword']) ? sprintf('Keyword: %s', $this->channels[$this->default]['keyword']) : '',
        ]);
    }

    protected function createMessage(string $content): Message
    {
        if ($this->client instanceof DingTalkClient) {
            $message = new \Guanguans\Notify\Messages\DingTalk\TextMessage(['content' => $content]);
        }

        if ($this->client instanceof FeiShuClient) {
            $message = new \Guanguans\Notify\Messages\FeiShu\TextMessage($content);
        }

        if ($this->client instanceof ServerChanClient) {
            $message = new \Guanguans\Notify\Messages\ServerChanMessage($this->getMessageTitle(), $content);
        }

        if ($this->client instanceof WeWorkClient) {
            $message = new \Guanguans\Notify\Messages\WeWork\TextMessage(['content' => $content]);
        }

        if ($this->client instanceof XiZhiClient) {
            $message = new \Guanguans\Notify\Messages\XiZhiMessage($this->getMessageTitle(), $this->transformToMarkdown($content));
        }

        return $message;
    }

    protected function getMessageTitle(): string
    {
        return sprintf('%s application exception notification', config('app.name'));
    }

    protected function transformToMarkdown(string $content): string
    {
        return sprintf(self::MARKDOWN_TEMPLATE, $content);
    }
}
