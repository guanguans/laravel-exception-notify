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

use Guanguans\LaravelExceptionNotify\Support\Utils;
use Guanguans\Notify\Foundation\Contracts\Authenticator;
use Guanguans\Notify\Foundation\Contracts\Client;
use Guanguans\Notify\Foundation\Message;
use Illuminate\Contracts\Container\BindingResolutionException;
use Psr\Http\Message\ResponseInterface;
use function Guanguans\LaravelExceptionNotify\Support\make;

/**
 * @see \Guanguans\Notify\Foundation\Client
 * @see \Guanguans\Notify\Foundation\Message
 * @see \Guanguans\Notify\Foundation\Authenticators
 */
class NotifyChannel extends AbstractChannel
{
    /**
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
        ] + parent::rules();
    }

    /**
     * @throws BindingResolutionException
     */
    private function makeClient(): Client
    {
        return Utils::applyConfigurationToObject(
            make($configuration = $this->configRepository->get('client') + [
                'authenticator' => $this->makeAuthenticator(),
            ]),
            $configuration
        );
    }

    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    private function makeAuthenticator(): Authenticator
    {
        return Utils::applyConfigurationToObject(
            make($configuration = $this->configRepository->get('authenticator')),
            $configuration
        );
    }

    /**
     * @throws BindingResolutionException
     */
    private function makeMessage(string $content): Message
    {
        return Utils::applyConfigurationToObject(
            make($configuration = Utils::applyContentToConfiguration($this->configRepository->get('message'), $content)),
            $configuration
        );
    }
}
