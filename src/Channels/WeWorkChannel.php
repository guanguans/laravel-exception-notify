<?php

/**
 * This file is part of the guanguans/laravel-exception-notify.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelExceptionNotify\Channels;

use Guanguans\Notify\Clients\WeWorkClient;
use Guanguans\Notify\Messages\WeWork\TextMessage;

class WeWorkChannel extends Channel
{
    /**
     * @var \Guanguans\Notify\Clients\WeWorkClient
     */
    protected $client;

    public function __construct(WeWorkClient $client)
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
