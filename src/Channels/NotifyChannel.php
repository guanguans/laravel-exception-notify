<?php

declare(strict_types=1);

/**
 * Copyright (c) 2021-2024 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-exception-notify
 */

namespace Guanguans\LaravelExceptionNotify\Channels;

use Guanguans\LaravelExceptionNotify\Contracts\ChannelContract;
use Guanguans\Notify\Clients\Client;
use Guanguans\Notify\Contracts\MessageInterface;

abstract class NotifyChannel implements ChannelContract
{
    protected Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    final public function report(string $report)
    {
        return $this->client->send($this->createMessage($report));
    }

    abstract protected function createMessage(string $report): MessageInterface;
}
