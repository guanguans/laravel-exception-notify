<?php

/**
 * This file is part of the guanguans/laravel-exception-notify.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelExceptionNotify\Channels;

use Guanguans\Notify\Clients\DingTalkClient;
use Guanguans\Notify\Messages\DingTalk\TextMessage;

class DingTalkChannel extends Channel
{
    /**
     * @var \Guanguans\Notify\Clients\DingTalkClient
     */
    protected $client;

    public function __construct(DingTalkClient $client)
    {
        $this->client = $client;
    }

    public function report(string $report)
    {
        return $this
            ->client
            ->setMessage($this->createMessage($report))
            ->send();
    }

    protected function createMessage(string $report)
    {
        return new TextMessage(['content' => $report]);
    }
}
