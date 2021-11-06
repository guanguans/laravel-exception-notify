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
use Illuminate\Support\Str;
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
     * @var array
     */
    public $customCollector = [];

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
                    tap($this->client, function (Client $client) use ($exception) {
                        $formatInformation = $this->formatInformation(
                            $this->collectInformation($exception)
                        );
                        // dd($formatInformation);
                        $client->setMessage(
                            $this->createClientMessage($client, $formatInformation)
                        );
                    })
                )
            );

            'sync' === config('queue.default') and method_exists($dispatch, 'afterResponse') and $dispatch->afterResponse();
        } catch (Throwable $e) {
            Log::error($e->getMessage(), ['exception' => $e]);
        }
    }

    protected function formatInformation(array $information): string
    {
        $information = array_filter($information, function ($info) {
            return filled($info);
        });

        $information = array_reduces($information, function ($carry, $val, $name) {
            is_scalar($val) or $val = var_export($val, true);

            return $carry.sprintf("%s: %s\n", str_replace('_', ' ', Str::title($name)), $val);
        }, '');

        return trim($information);
    }

    protected function collectInformation(Throwable $exception): array
    {
        $collector = [
            'Trigger Time' => $this->_collector['trigger_time'] ? Carbon::now()->toDateTimeString() : null,
            'Usage Memory' => $this->_collector['usage_memory'] ? round(memory_get_peak_usage(true) / 1024 / 1024, 1).'M' : null,

            'App Name' => $this->_collector['app_name'] ? config('app.name') : null,
            'App Version' => $this->_collector['app_version'] ? App::version() : null,
            'App Environment' => $this->_collector['app_environment'] ? App::environment() : null,
            'App Locale' => $this->_collector['app_locale'] ? App::getLocale() : null,

            'PHP Version' => $this->_collector['php_version'] ? implode('.', [PHP_MAJOR_VERSION, PHP_MINOR_VERSION, PHP_RELEASE_VERSION]) : null,
            'PHP Interface' => $this->_collector['php_interface'] ? PHP_SAPI : null,

            'Exception Class' => get_class($exception),
            'Exception Message' => $exception->getMessage(),
            'Exception Code' => $exception->getCode(),
            'Exception File' => $exception->getFile(),
            'Exception Line' => $exception->getLine(),
            'Exception Line Preview' => ExceptionContext::getContextAsString($exception),
            'Exception Stack Trace' => with($exception->getTrace(), function ($trace) {
                if (! $this->_collector['exception_stack_trace']) {
                    return null;
                }

                return collect($trace)
                    ->filter(function ($trace) {
                        return isset($trace['file']) and isset($trace['line']);
                    })
                    ->map(function ($trace) {
                        return $trace['file']."({$trace['line']})";
                    })
                    ->values()
                    ->toArray();
            }),

            'Request Ip Address' => $this->_collector['request_ip_address'] ? Request::ip() : null,
            'Request Url' => $this->_collector['request_url'] ? Request::fullUrl() : null,
            'Request Method' => $this->_collector['request_method'] ? Request::method() : null,
            'Request Controller Action' => $this->_collector['request_controller_action'] ? optional(Request::route())->getActionName() : null,
            'Request Duration' => value(function () {
                $startTime = defined('LARAVEL_START') ? LARAVEL_START : Request::server('REQUEST_TIME_FLOAT');
                if (! $this->_collector['request_duration'] || ! $startTime) {
                    return null;
                }

                return floor((microtime(true) - $startTime) * 1000).'ms';
            }),
            'Request Middleware' => $this->_collector['request_middleware'] ? array_values(optional(Request::route())->gatherMiddleware() ?? []) : null,
            'Request All' => $this->_collector['request_all'] ? Request::all() : null,
            'Request Input' => $this->_collector['request_input'] ? Request::input() : null,
            'Request Header' => value(function () {
                if (! $this->_collector['request_header']) {
                    return null;
                }

                return collect(Request::header())
                    ->map(function ($header) {
                        return $header[0];
                    })
                    ->toArray();
            }),
            'Request Query' => $this->_collector['request_query'] ? Request::query() : null,
            'Request Post' => $this->_collector['request_post'] ? Request::post() : null,
            'Request Server' => $this->_collector['request_server'] ? Request::server() : null,
            'Request Cookie' => $this->_collector['request_cookie'] ? Request::cookie() : null,
            'Request Session' => $this->_collector['request_session'] ? optional(Request::getSession())->all() : null,

            'Keyword' => $this->channels[$this->defaultChannel]['keyword'] ?? null,
        ];

        $customCollector = collect($this->customCollector)
            ->map(function ($collector) {
                if (! is_callable($collector)) {
                    return $collector;
                }

                return App::call($collector);
            })
            ->toArray();

        return array_merge($collector, $customCollector);
    }

    protected function createClientMessage(Client $client, string $content): Message
    {
        if ($client instanceof DingTalkClient) {
            $message = new \Guanguans\Notify\Messages\DingTalk\TextMessage(['content' => $content]);
        }

        if ($client instanceof FeiShuClient) {
            $message = new \Guanguans\Notify\Messages\FeiShu\TextMessage($content);
        }

        if ($client instanceof ServerChanClient) {
            $message = new \Guanguans\Notify\Messages\ServerChanMessage($this->getMessageTitle(), $content);
        }

        if ($client instanceof WeWorkClient) {
            $content = substr($content, 0, 5100).'...';

            $message = new \Guanguans\Notify\Messages\WeWork\TextMessage(['content' => $content]);
        }

        if ($client instanceof XiZhiClient) {
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
        $this->_collector = array_merge($this->_collector, $collector);
    }

    /**
     * @return bool[]
     */
    public function getCollector(): array
    {
        return $this->_collector;
    }
}
