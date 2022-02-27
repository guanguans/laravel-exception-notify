<?php

/**
 * This file is part of the guanguans/laravel-exception-notify.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelExceptionNotify\Channels;

use Guanguans\LaravelExceptionNotify\Contracts\Channel as ChannelContract;
use Guanguans\LaravelExceptionNotify\Support\Traits\CreateStatic;
use Guanguans\Notify\Clients\Client;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Str;

abstract class Channel implements ChannelContract
{
    use CreateStatic;

    /**
     * @var \Guanguans\Notify\Clients\Client
     */
    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function report(string $report)
    {
        $report = $this->handleReport($report);

        return $this
            ->client
            ->setMessage($this->createMessage($report))
            ->send();
    }

    abstract protected function createMessage(string $report);

    protected function handleReport(string $report): string
    {
        return (new Pipeline(app()))
            ->send($report)
            ->through($this->getPipeline())
            ->then(function ($passable) {
                return $passable;
            });
    }

    public function getName(): string
    {
        return Str::lcfirst(Str::beforeLast(class_basename($this), 'Channel'));
    }

    public function getPipeline(): array
    {
        return array_merge(
            config('exception-notify.pipeline', []),
            config(sprintf('exception-notify.channels.%s.pipeline', $this->getName()), [])
        );
    }
}
