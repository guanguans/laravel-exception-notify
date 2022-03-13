<?php

/**
 * This file is part of the guanguans/laravel-exception-notify.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelExceptionNotify\Channels;

use Guanguans\Notify\Clients\ChanifyClient;
use Guanguans\Notify\Messages\Chanify\TextMessage;

class ChanifyChannel extends Channel
{
    /**
     * @var \Guanguans\Notify\Clients\ChanifyClient
     */
    protected $client;

    public function __construct(ChanifyClient $client)
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
        return new TextMessage([
            'title' => config('exception-notify.title'),
            'text' => $report,
        ]);
    }
}
