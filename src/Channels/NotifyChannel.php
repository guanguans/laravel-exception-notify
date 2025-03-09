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
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Psr\Http\Message\ResponseInterface;
use function Guanguans\LaravelExceptionNotify\Support\make;

/**
 * @see \Illuminate\Log\LogManager
 */
class NotifyChannel extends AbstractChannel
{
    public const TITLE_TEMPLATE = '{title}';
    public const CONTENT_TEMPLATE = '{content}';

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
        $configuration = $this->configRepository->get('message');

        array_walk_recursive($configuration, static function (mixed &$value) use ($content): void {
            \is_string($value) and $value = str_replace(
                [self::TITLE_TEMPLATE, self::CONTENT_TEMPLATE],
                [config('exception-notify.title'), $content],
                $value
            );
        });

        return $this->applyConfigurationToObject(make($configuration), $configuration);
    }

    private function applyConfigurationToObject(
        object $object,
        array $configuration,
        ?array $except = null
    ): object {
        return collect($configuration)
            ->except($except)
            // ->filter(static fn (mixed $value): bool => \is_array($value) && !array_is_list($value))
            ->each(static function (mixed $value, string $key) use ($object): void {
                foreach (
                    [
                        static fn (string $key): string => $key,
                        static fn (string $key): string => Str::camel($key),
                        static fn (string $key): string => 'set'.Str::studly($key),
                        static fn (string $key): string => 'on'.Str::studly($key),
                    ] as $case
                ) {
                    if (method_exists($object, $method = $case($key))) {
                        $numberOfParameters = (new \ReflectionMethod($object, $method))->getNumberOfParameters();

                        if (1 === $numberOfParameters) {
                            $object->{$method}($value);

                            return;
                        }

                        app()->call([$object, $method], $value);

                        return;
                    }
                }
            })
            ->pipe(static fn (Collection $configuration): object => $object);
    }
}
