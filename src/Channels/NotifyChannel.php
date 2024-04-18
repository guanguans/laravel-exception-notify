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
use Guanguans\Notify\Foundation\Contracts\Client;
use Guanguans\Notify\Foundation\Contracts\Message;
use GuzzleHttp\UriTemplate\UriTemplate;
use Illuminate\Config\Repository;

class NotifyChannel implements ChannelContract
{
    private Repository $configRepository;

    public function __construct(array $config)
    {
        $this->configRepository = new Repository($config);
    }

    final public function report(string $report)
    {
        return $this->createClient()->send($this->createMessage($report));
    }

    private function createClient(): Client
    {
        /** @var \Guanguans\Notify\Foundation\Contracts\Authenticator $authenticator */
        $authenticator = make($this->configRepository->get('authenticator'));

        /** @var Client $client */
        // $client = new ($this->configRepository->get('client'))($authenticator);
        if ($this->configRepository->has('client_options')) {
            $client->setHttpOptions($this->configRepository->get('client_options'));
        }

        return $client;
    }

    private function createMessage(string $report): Message
    {
        $options = array_map(static function ($value) use ($report) {
            if (\is_string($value)) {
                return UriTemplate::expand($value, [
                    'title' => config('exception-notify.title'),
                    'report' => $report,
                ]);
            }

            return $value;
        }, $this->configRepository->get('message.options'));

        // return new ($this->configRepository->get('message.class'))($options);
    }
}
