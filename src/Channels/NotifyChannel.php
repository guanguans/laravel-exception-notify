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
use Guanguans\Notify\Foundation\Support\Str;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Psr\Http\Message\ResponseInterface;
use function Guanguans\LaravelExceptionNotify\Support\make;

/**
 * @see \Illuminate\Log\LogManager
 */
class NotifyChannel extends Channel
{
    public const TEMPLATES = [
        'title' => '{title}',
        'report' => '{report}',
    ];

    /**
     * @throws BindingResolutionException
     * @throws GuzzleException
     */
    public function report(string $report): ResponseInterface
    {
        return $this->createClient()->send($this->createMessage($report));
    }

    protected function rules(): array
    {
        return [
            'authenticator' => 'required|array',
            'authenticator.class' => 'required|string',

            'client' => 'required|array',
            'client.class' => 'required|string',
            'client.http_options' => 'array',
            'client.extender' => static function (string $attribute, mixed $value, \Closure $fail): void {
                if (\is_string($value) || \is_callable($value)) {
                    return;
                }

                $fail("The $attribute must be a callable or string.");
            },

            'message' => 'required|array',
            'message.class' => 'required|string',
        ] + parent::rules();
    }

    /**
     * @throws BindingResolutionException
     */
    private function createClient(): Client
    {
        /** @var Client $client */
        $client = make($this->configRepository->get('client.class'), [
            'authenticator' => $this->createAuthenticator(),
        ]);

        if ($this->configRepository->has('client.http_options')) {
            $client->setHttpOptions($this->configRepository->get('client.http_options'));
        }

        return $this->configRepository->has('client.extender')
            ? app()->call($this->configRepository->get('client.extender'), ['client' => $client])
            : $client;
    }

    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    private function createAuthenticator(): Authenticator
    {
        $options = $this->configRepository->get('authenticator');

        return $this->applyOptionsToObject($options, make($options));
    }

    /**
     * @throws BindingResolutionException
     */
    private function createMessage(string $report): Message
    {
        $replace = [config('exception-notify.title'), $report];
        $options = Arr::except($this->configRepository->get('message'), 'class');

        array_walk_recursive($options, static function (mixed &$value) use ($replace): void {
            \is_string($value) and $value = str_replace(self::TEMPLATES, $replace, $value);
        });

        return make($this->configRepository->get('message.class'), ['options' => $options]);
    }

    private function applyOptionsToObject(array $options, object $object): object
    {
        return collect($options)
            ->except([
            ])
            ->each(static function (mixed $value, string $key) use ($object): void {
                foreach (
                    [
                        static fn (string $name): string => $name,
                        static fn (string $name): string => Str::camel($name),
                        static fn (string $name): string => 'set'.Str::pascal($name),
                    ] as $case
                ) {
                    if (method_exists($object, $method = $case($key))) {
                        $object->{$method}($value);

                        return;
                    }
                }
            })
            ->pipe(static fn (Collection $options): object => $options->has('extender')
                ? $options->get('extender')($object)
                : $object);
    }
}
