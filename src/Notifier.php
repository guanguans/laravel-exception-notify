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
use Guanguans\Notify\Clients\DingTalkClient;
use Guanguans\Notify\Clients\FeiShuClient;
use Guanguans\Notify\Clients\WeWorkClient;
use Guanguans\Notify\Clients\XiZhiClient;
use Guanguans\Notify\Factory;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use Throwable;

class Notifier extends BaseObject
{
    protected $clientMapMessage = [
        DingTalkClient::class => \Guanguans\Notify\Messages\DingTalk\TextMessage::class,
        FeiShuClient::class => \Guanguans\Notify\Messages\FeiShu\TextMessage::class,
        WeWorkClient::class => \Guanguans\Notify\Messages\WeWork\TextMessage::class,
        XiZhiClient::class => \Guanguans\Notify\Messages\XiZhiMessage::class,
    ];

    public $default;

    public $channels;

    protected $client;

    public function init()
    {
        parent::init();

        $options = $this->channels[$this->default];
        unset($options['keyword']);

        $this->client = Factory::{$this->default}($options);
    }

    public function report(Exception $exception)
    {
        $message = $this->transformToExceptionMessage($exception);

        try {
            dispatch(new ExceptionMessageSendJob($this->client, $message));
        } catch (Throwable $e) {
            Log::error($e->getMessage());
        }
    }

    protected function transformToExceptionMessage(Exception $exception)
    {
        $messages = [
            sprintf('request url: %s', Request::fullUrl()),
            sprintf('message: %s', $exception->getMessage()),
            sprintf('code: %s', $exception->getCode()),
            sprintf('file: %s', $exception->getFile()),
            sprintf('line: %s', $exception->getLine()),
            sprintf('trace: %s', $exception->getTraceAsString()),
        ];

        $textMessages = implode(PHP_EOL, $messages);

        $messageClass = $this->clientMapMessage[get_class($this->client)];

        if ($this->client instanceof DingTalkClient) {
            $message = new $messageClass([
                'content' => sprintf("%s\n%s", $this->channels[$this->default]['keyword'], $textMessages),
            ]);
        }
        if ($this->client instanceof FeiShuClient) {
            $message = new $messageClass([
                sprintf("%s\n%s", $this->channels[$this->default]['keyword'], $textMessages),
            ]);
        }
        if ($this->client instanceof WeWorkClient) {
            $message = new $messageClass([
                'content' => sprintf("%s\n%s", $this->channels[$this->default]['keyword'], $textMessages),
            ]);
        }
        if ($this->client instanceof XiZhiClient) {
            $message = new $messageClass([
                'title' => '异常报错',
                'content' => sprintf("%s\n%s", $this->channels[$this->default]['keyword'], $textMessages),
            ]);
        }

        return $message;
    }
}
