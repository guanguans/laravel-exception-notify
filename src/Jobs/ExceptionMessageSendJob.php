<?php

/**
 * This file is part of the guanguans/laravel-exception-notify.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelExceptionNotify\Jobs;

use Guanguans\Notify\Clients\Client;
use Guanguans\Notify\Messages\Message;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ExceptionMessageSendJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * @var \Guanguans\Notify\Clients\Client
     */
    protected $client;

    /**
     * @var \Guanguans\Notify\Messages\Message
     */
    protected $message;

    /**
     * ExceptionMessageSendJob constructor.
     */
    public function __construct(Client $client, Message $message)
    {
        $this->client = $client;
        $this->message = $message;
    }

    /**
     * {@inheritdoc}
     */
    public function handle()
    {
        $this->client->send($this->message);
    }
}
