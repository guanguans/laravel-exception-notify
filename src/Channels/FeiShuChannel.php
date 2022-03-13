<?php

/**
 * This file is part of the guanguans/laravel-exception-notify.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelExceptionNotify\Channels;

use Guanguans\Notify\Clients\FeiShuClient;
use Guanguans\Notify\Messages\FeiShu\TextMessage;

class FeiShuChannel extends Channel
{
    /**
     * @var \Guanguans\Notify\Clients\FeiShuClient
     */
    protected $client;

    public function __construct(FeiShuClient $client)
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
        return new TextMessage($report);
    }
}
