<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-exception-notify.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelExceptionNotify\Channels;

use Guanguans\Notify\Clients\Client;
use Guanguans\Notify\Contracts\MessageInterface;

abstract class NotifyChannel extends Channel
{
    /**
     * @var \Guanguans\Notify\Clients\Client
     */
    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function report(string $report)
    {
        return $this->client->send($this->createMessage($report));
    }

    abstract protected function createMessage(string $report): MessageInterface;
}
