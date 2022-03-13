<?php

/**
 * This file is part of the guanguans/laravel-exception-notify.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelExceptionNotify\Channels;

use Guanguans\Notify\Clients\ServerChanClient;
use Guanguans\Notify\Messages\ServerChanMessage;

class ServerChanChannel extends Channel
{
    /**
     * @var \Guanguans\Notify\Clients\ServerChanClient
     */
    protected $client;

    public function __construct(ServerChanClient $client)
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

    protected function createMessage(string $content)
    {
        return new ServerChanMessage(config('exception-notify.title'), $content);
    }
}
