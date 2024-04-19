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
use Guanguans\Notify\Foundation\Client;
use Guanguans\Notify\Foundation\Message;
use Guanguans\Notify\Foundation\Response;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Config\Repository;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Psr\Http\Message\ResponseInterface;

class NotifyChannel implements ChannelContract
{
    public const TAGS = [
        'title' => '{title}',
        'report' => '{report}',
    ];
    private Repository $configRepository;

    public function __construct(array $config)
    {
        $validator = validator($config, [
            'authenticator' => 'required|array',
            'authenticator.class' => 'required|string',

            'client' => 'required|array',
            'client.class' => 'required|string',
            'client.http_options' => 'array',
            // 'client.tapper' => 'string|callable',

            'message' => 'required|array',
            'message.class' => 'required|string',
        ]);

        if ($validator->errors()->isNotEmpty()) {
            throw new \InvalidArgumentException($validator->errors()->first());
        }

        $this->configRepository = new Repository($config);
    }

    /**
     * @throws BindingResolutionException
     * @throws GuzzleException
     *
     * @return Response|ResponseInterface
     */
    public function report(string $report)
    {
        return $this->createClient()->send($this->createMessage($report));
    }

    /**
     * @throws BindingResolutionException
     */
    private function createClient(): Client
    {
        /** @var Client $client */
        $client = make($this->configRepository->get('client.class'), [
            'authenticator' => make($this->configRepository->get('authenticator')),
        ]);

        if ($this->configRepository->has('client.http_options')) {
            $client->setHttpOptions($this->configRepository->get('client.http_options'));
        }

        if ($this->configRepository->has('client.tapper')) {
            app()->call($this->configRepository->get('client.tapper'), ['client' => $client]);
        }

        return $client;
    }

    /**
     * @throws BindingResolutionException
     */
    private function createMessage(string $report): Message
    {
        $replace = [config('exception-notify.title'), $report];

        $options = Arr::except($this->configRepository->get('message'), 'class');

        array_walk_recursive($options, static function (&$value) use ($replace): void {
            \is_string($value) and $value = Str::replace(self::TAGS, $replace, $value);
        });

        return make($this->configRepository->get('message.class'), ['options' => $options]);
    }
}
