<?php

declare(strict_types=1);

/**
 * Copyright (c) 2021-2025 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-exception-notify
 */

namespace Guanguans\LaravelExceptionNotify\Channels;

use Guanguans\Notify\Foundation\Client;
use Guanguans\Notify\Foundation\Contracts\Authenticator;
use Guanguans\Notify\Foundation\Message;
use Illuminate\Contracts\Container\BindingResolutionException;
use Psr\Http\Message\ResponseInterface;
use function Guanguans\LaravelExceptionNotify\Support\make;

/**
 * @see \Illuminate\Log\LogManager
 */
class NotifyChannel extends AbstractChannel
{
    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function reportContent(string $content): ResponseInterface
    {
        return $this->makeClient()->send($this->makeMessage($content));
    }

    protected function rules(): array
    {
        return [
            'authenticator' => 'required|array',
            'authenticator.class' => 'required|string',
            'client' => 'required|array',
            'client.class' => 'required|string',
            'message' => 'required|array',
            'message.class' => 'required|string',
            // 'message.options' => 'required|array',
        ] + parent::rules();
    }

    /**
     * @throws BindingResolutionException
     */
    private function makeClient(): Client
    {
        return $this->applyConfigurationToObject(
            make($this->configRepository->get('client.class'), ['authenticator' => $this->makeAuthenticator()]),
            $this->configRepository->get('client')
        );
    }

    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    private function makeAuthenticator(): Authenticator
    {
        return $this->applyConfigurationToObject(
            make($configuration = $this->configRepository->get('authenticator')),
            $configuration
        );
    }

    /**
     * @throws BindingResolutionException
     */
    private function makeMessage(string $content): Message
    {
        return $this->applyConfigurationToObject(
            make($configuration = $this->applyContentToConfiguration($this->configRepository->get('message'), $content)),
            $configuration
        );
    }
}
