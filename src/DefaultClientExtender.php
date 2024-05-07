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

namespace Guanguans\LaravelExceptionNotify;

use Guanguans\Notify\Foundation\Client;
use GuzzleHttp\MessageFormatter;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Log;

class DefaultClientExtender
{
    private string $channel;
    private string $template;
    private string $logLevel;

    public function __construct(
        string $channel = 'daily',
        string $template = MessageFormatter::DEBUG,
        string $logLevel = 'debug'
    ) {
        $this->channel = $channel;
        $this->template = $template;
        $this->logLevel = $logLevel;
    }

    public function __invoke(Client $client): Client
    {
        return $client->push(
            Middleware::log(
                Log::channel($this->channel),
                new MessageFormatter($this->template),
                $this->logLevel
            ),
            'log',
        );
    }
}
