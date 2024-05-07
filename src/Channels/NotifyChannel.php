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

use Guanguans\LaravelExceptionNotify\Exceptions\InvalidArgumentException;
use Guanguans\Notify\Foundation\Client;
use Guanguans\Notify\Foundation\Message;
use Guanguans\Notify\Foundation\Response;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Config\Repository;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Psr\Http\Message\ResponseInterface;

class NotifyChannel extends Channel
{
    public const TEMPLATES = [
        'title' => '{title}',
        'report' => '{report}',
    ];

    public function __construct(Repository $config)
    {
        $validator = validator($config->all(), [
            'authenticator' => 'required|array',
            'authenticator.class' => 'required|string',

            'client' => 'required|array',
            'client.class' => 'required|string',
            'client.http_options' => 'array',
            'client.extender' => static function (string $attribute, $value, \Closure $fail): void {
                if (\is_string($value) || \is_callable($value)) {
                    return;
                }

                $fail("The $attribute must be a callable or string.");
            },

            'message' => 'required|array',
            'message.class' => 'required|string',
        ]);

        if ($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first());
        }

        parent::__construct($config);
    }

    /**
     * @throws BindingResolutionException
     * @throws GuzzleException
     *
     * @return Response|ResponseInterface
     */
    public function report(string $report): ResponseInterface
    {
        return $this->createClient()->send($this->createMessage($report));
    }

    /**
     * @throws BindingResolutionException
     */
    private function createClient(): Client
    {
        /** @var Client $client */
        $client = make($this->config->get('client.class'), [
            'authenticator' => make($this->config->get('authenticator')),
        ]);

        if ($this->config->has('client.http_options')) {
            $client->setHttpOptions($this->config->get('client.http_options'));
        }

        return $this->config->has('client.extender')
            ? app()->call($this->config->get('client.extender'), ['client' => $client])
            : $client;
    }

    /**
     * @throws BindingResolutionException
     */
    private function createMessage(string $report): Message
    {
        $replace = [config('exception-notify.title'), $report];
        $options = Arr::except($this->config->get('message'), 'class');

        array_walk_recursive($options, static function (&$value) use ($replace): void {
            \is_string($value) and $value = Str::replace(self::TEMPLATES, $replace, $value);
        });

        return make($this->config->get('message.class'), ['options' => $options]);
    }
}
