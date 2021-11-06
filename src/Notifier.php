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
use Illuminate\Support\Facades\App;
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
        'trigger_time' => true,
        'usage_memory' => true,

        'app_name' => true,
        'app_environment' => true,
        'app_version' => true,
        'app_locale' => true,

        'php_version' => true,
        'php_interface' => true,

        'request_ip_address' => true,
        'request_url' => true,
        'request_method' => true,
        'request_controller_action' => true,
        'request_duration' => true,
        'request_middleware' => false,
        'request_all' => false,
        'request_input' => true,
        'request_header' => false,
        'request_query' => false,
        'request_post' => false,
        'request_server' => false,
        'request_cookie' => false,
        'request_session' => false,

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

            $dispatch = dispatch(
                new SendExceptionNotification(
                    // tap($this->client)->setMessage($this->createMessageByException($exception));
                    tap($this->client, function (Client $client) use ($exception) {
                        $client->setMessage($this->createMessageByException($exception));
                    })
                )
            );

            'sync' === config('queue.default') and method_exists($dispatch, 'afterResponse') and $dispatch->afterResponse();
        } catch (Throwable $e) {
            Log::error($e->getMessage(), ['exception' => $e]);
        }
    }

    protected function createMessageByException(Throwable $exception): Message
    {
        $formatInformation = $this->formatInformation($this->collectInformation($exception));

        return $this->createMessage($formatInformation);
    }

    protected function formatInformation(array $information): string
    {
        $information = array_filter($information);

        // ksort($information);

        $information = array_reduces($information, function ($carry, $val, $name) {
            is_scalar($val) or $val = var_export($val, true);

            return $carry.sprintf("%s: %s\n", $name, $val);
        }, '');

        return trim($information);
    }

    protected function collectInformation(Throwable $exception): array
    {
        $trace = collect($exception->getTrace())
            ->filter(function ($trace) {
                return isset($trace['file']) and isset($trace['line']);
            })
            ->map(function ($trace) {
                return $trace['file']."({$trace['line']})";
            })
            ->toArray();

        $startTime = defined('LARAVEL_START') ? LARAVEL_START : Request::server('REQUEST_TIME_FLOAT');

        $headers = collect(Request::header())
            ->map(function (array $header) {
                return $header[0];
            })
            ->toArray();

        return [
            'Trigger Time' => $this->collector['trigger_time'] ? Carbon::now()->toDateTimeString() : '',
            'Usage Memory' => $this->collector['usage_memory'] ? round(memory_get_peak_usage(true) / 1024 / 1024, 1).'M' : '',

            'App Name' => $this->collector['app_name'] ? config('app.name') : '',
            'App Version' => $this->collector['app_version'] ? App::version() : '',
            'App Environment' => $this->collector['app_environment'] ? App::environment() : '',
            'App Locale' => $this->collector['app_locale'] ? App::getLocale() : '',

            'PHP Version' => $this->collector['php_version'] ? implode('.', [PHP_MAJOR_VERSION, PHP_MINOR_VERSION, PHP_RELEASE_VERSION]) : '',
            'PHP Interface' => $this->collector['php_interface'] ? PHP_SAPI : '',

            'Exception Class' => get_class($exception),
            'Exception Message' => $exception->getMessage(),
            'Exception Code' => $exception->getCode(),
            'Exception File' => $exception->getFile(),
            'Exception Line' => $exception->getLine(),
            'Exception Line Preview' => ExceptionContext::getContextAsString($exception),
            'Exception Stack Trace' => $this->collector['exception_stack_trace'] ? $trace : '',

            'Request Ip Address' => $this->collector['request_ip_address'] ? Request::ip() : '',
            'Request Url' => $this->collector['request_url'] ? Request::fullUrl() : '',
            'Request Method' => $this->collector['request_method'] ? Request::method() : '',
            'Request Controller Action' => $this->collector['request_controller_action'] ? optional(Request::route())->getActionName() : '',
            'Request Duration' => $this->collector['request_duration'] ? ($startTime ? floor((microtime(true) - $startTime) * 1000).'ms' : null) : '',
            'Request Middleware' => $this->collector['request_middleware'] ? array_values(optional(Request::route())->gatherMiddleware() ?? []) : '',
            'Request All' => $this->collector['request_all'] ? Request::all() : '',
            'Request Input' => $this->collector['request_input'] ? Request::input() : '',
            'Request Header' => $this->collector['request_header'] ? $headers : '',
            'Request Query' => $this->collector['request_query'] ? Request::query() : '',
            'Request Post' => $this->collector['request_post'] ? Request::post() : '',
            'Request Server' => $this->collector['request_server'] ? Request::server() : '',
            'Request Cookie' => $this->collector['request_cookie'] ? Request::cookie() : '',
            'Request Session' => $this->collector['request_session'] ? optional(Request::getSession())->all() : '',

            'Keyword' => $this->channels[$this->defaultChannel]['keyword'] ?? '',
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
            $message = new \Guanguans\Notify\Messages\XiZhiMessage(
                $this->getMessageTitle(),
                transform($content, function ($content) {
                    return sprintf(self::MARKDOWN_TEMPLATE, $content);
                })
            );
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
        return ucfirst(sprintf('%s application exception notification', config('app.name')));
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

        if (! in_array('*', $this->env) && ! in_array(App::environment(), $this->env)) {
            return true;
        }

        return ! is_null(
            Arr::first($this->dontReport, function ($type) use ($e) {
                return $e instanceof $type;
            })
        );
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
