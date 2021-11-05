<?php

/**
 * This file is part of the guanguans/laravel-exception-notify.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelExceptionNotify;

use Guanguans\LaravelExceptionNotify\Jobs\SendExceptionNotification;
use Guanguans\Notify\Clients\Client;
use Guanguans\Notify\Clients\DingTalkClient;
use Guanguans\Notify\Clients\FeiShuClient;
use Guanguans\Notify\Clients\ServerChanClient;
use Guanguans\Notify\Clients\WeWorkClient;
use Guanguans\Notify\Clients\XiZhiClient;
use Guanguans\Notify\Factory;
use Guanguans\Notify\Messages\Message;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use Throwable;

class Notifier extends BaseObject
{
    protected const MARKDOWN_TEMPLATE = <<<'md'
```plain text
%s
```
md;

    /**
     * @var bool
     */
    public $enabled = true;

    /**
     * @var string[]
     */
    public $env = ['*'];

    /**
     * @var string[]
     */
    public $dontReport = [];

    /**
     * @var bool
     */
    public $debug = false;

    /**
     * @var bool[]
     */
    protected $_collector = [
        'app_name' => true,
        'app_env' => true,
        'trigger_time' => true,
        'request_method' => true,
        'request_url' => true,
        'request_ip' => true,
        'request_header' => true,
        'request_data' => true,
        'exception_stack_trace' => true,
    ];

    /**
     * @var string
     */
    public $defaultChannel;

    /**
     * @var array[]
     */
    public $channels = [];

    /**
     * @var \Guanguans\Notify\Clients\Client
     */
    protected $client;

    /**
     * @var array
     */
    protected $clientOptions = [];

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        $this->clientOptions = $this->getDefaultChannelOptions();

        $this->client instanceof Client or $this->client = Factory::{$this->defaultChannel}($this->clientOptions);
    }

    public function report(Throwable $exception)
    {
        try {
            if ($this->shouldntReport($exception)) {
                return;
            }

            $dispatch = dispatch(new SendExceptionNotification(
                // tap($this->client)->setMessage($this->createMessageByException($exception));
                tap($this->client, function (Client $client) use ($exception) {
                    $client->setMessage($this->createMessageByException($exception));
                })
            ));

            'sync' === config('queue.default') and method_exists($dispatch, 'afterResponse') and $dispatch->afterResponse();
        } catch (Throwable $e) {
            Log::error($e->getMessage());
        }
    }

    protected function createMessageByException(Throwable $exception): Message
    {
        $information = array_merge($this->collectExtraInformation(), $this->collectExceptionInformation($exception));

        $formatInformation = $this->formatInformation($information);

        return $this->createMessage($formatInformation);
    }

    protected function formatInformation(array $information): string
    {
        $information = array_filter($information);

        $information = array_reduces($information, function ($carry, $val, $name) {
            $names = explode('_', $name);
            $name = array_reduce($names, function ($carry, $name) {
                return $carry.' '.ucfirst($name);
            }, '');

            return $carry.sprintf("%s: %s\n", trim($name), $val);
        }, '');

        return trim($information);
    }

    protected function collectExceptionInformation(Throwable $exception): array
    {
        return [
            'exception_class' => get_class($exception),
            'exception_message' => $exception->getMessage(),
            'exception_code' => $exception->getCode(),
            'exception_file' => $exception->getFile(),
            'exception_line' => $exception->getLine(),
            'exception_stack_trace' => $exception->getTraceAsString(),
        ];
    }

    protected function collectExtraInformation(): array
    {
        $headers = collect(Request::header())
            ->map(function (array $header) {
                return $header[0];
            })
            ->toArray();

        return [
            'app_name' => $this->collector['app_name'] ? config('app.name') : '',
            'app_env' => $this->collector['app_env'] ? config('app.env') : '',
            'trigger_time' => $this->collector['trigger_time'] ? Carbon::now()->toDateTimeString() : '',
            'request_method' => $this->collector['request_method'] ? Request::method() : '',
            'request_url' => $this->collector['request_url'] ? Request::fullUrl() : '',
            'request_ip' => $this->collector['request_ip'] ? Request::ip() : '',
            'request_header' => $this->collector['request_header'] ? var_export($headers, true) : '',
            'request_data' => $this->collector['request_data'] ? var_export(Request::all(), true) : '',
            'keyword' => $this->channels[$this->defaultChannel]['keyword'] ?? '',
        ];
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
            $content = substr($content, 0, 5100).'...';

            $message = new \Guanguans\Notify\Messages\WeWork\TextMessage(['content' => $content]);
        }

        if ($this->client instanceof XiZhiClient) {
            $message = new \Guanguans\Notify\Messages\XiZhiMessage($this->getMessageTitle(), $this->transformToMarkdown($content));
        }

        return $message;
    }

    protected function getDefaultChannelOptions(): array
    {
        $options = $this->channels[$this->defaultChannel];

        unset($options['keyword']);

        return $options;
    }

    protected function getMessageTitle(): string
    {
        return sprintf('%s application exception notification', config('app.name'));
    }

    protected function transformToMarkdown(string $content): string
    {
        return sprintf(self::MARKDOWN_TEMPLATE, $content);
    }

    public function shouldReport(Throwable $e): bool
    {
        return ! $this->shouldntReport($e);
    }

    public function shouldntReport(Throwable $e): bool
    {
        if (! $this->enabled) {
            return true;
        }

        if (! in_array('*', $this->env) && ! in_array(config('app.env'), $this->env)) {
            return true;
        }

        return ! is_null(Arr::first($this->dontReport, function ($type) use ($e) {
            return $e instanceof $type;
        }));
    }

    /**
     * @param bool[] $collector
     */
    public function setCollector(array $collector): void
    {
        $this->_collector = array_merge($this->collector, $collector);
    }

    /**
     * @return bool[]
     */
    public function getCollector(): array
    {
        return $this->_collector;
    }
}
