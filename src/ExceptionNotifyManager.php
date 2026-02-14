<?php

/** @noinspection PhpUnused */

declare(strict_types=1);

/**
 * Copyright (c) 2021-2026 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-exception-notify
 */

namespace Guanguans\LaravelExceptionNotify;

use Guanguans\LaravelExceptionNotify\Channels\Channel;
use Guanguans\LaravelExceptionNotify\Contracts\ChannelContract;
use Guanguans\LaravelExceptionNotify\Exceptions\InvalidArgumentException;
use Guanguans\LaravelExceptionNotify\Support\Traits\AggregationTrait;
use Illuminate\Config\Repository;
use Illuminate\Support\Manager;
use function Guanguans\LaravelExceptionNotify\Support\rescue;

/**
 * @property \Illuminate\Foundation\Application $container
 *
 * @method \Guanguans\LaravelExceptionNotify\Channels\Channel driver(?string $driver = null)
 *
 * @mixin \Guanguans\LaravelExceptionNotify\Channels\Channel
 */
class ExceptionNotifyManager extends Manager implements ChannelContract
{
    use AggregationTrait {
        AggregationTrait::__call as macroCall;
    }

    /**
     * @param string $method
     * @param list<mixed> $parameters
     */
    public function __call(mixed $method, mixed $parameters): mixed
    {
        return self::hasMacro($method)
            ? $this->macroCall($method, $parameters)
            : parent::__call($method, $parameters);
    }

    public function getDefaultDriver(): string
    {
        return config('exception-notify.default');
    }

    /**
     * @api
     */
    public function channel(?string $channel = null): Channel
    {
        return $this->driver($channel);
    }

    public function report(\Throwable $throwable): void
    {
        rescue(function () use ($throwable): void {
            $this->driver()->report($throwable);
        });
    }

    public function reportContent(string $content): mixed
    {
        return rescue(fn (): mixed => $this->driver()->reportContent($content));
    }

    /**
     * @noinspection MethodShouldBeFinalInspection
     * @noinspection MissingParentCallInspection
     * @noinspection PhpMissingParentCallCommonInspection
     */
    protected function createDriver(mixed $driver): Channel
    {
        $channelContract = $this->createOriginalDriver($driver);

        return $channelContract instanceof Channel ? $channelContract : new Channel($channelContract);
    }

    private function createOriginalDriver(string $driver): ChannelContract
    {
        if (isset($this->customCreators[$driver])) {
            return $this->callCustomCreator($driver);
        }

        $configRepository = tap(
            new Repository($this->config->get("exception-notify.channels.$driver", [])),
            static fn (Repository $configRepository): mixed => $configRepository->set('__channel', $driver)
        );

        $studlyName = (string) str($configRepository->get('driver', $driver))->studly();

        if (class_exists($class = "\\Guanguans\\LaravelExceptionNotify\\Channels\\{$studlyName}Channel")) {
            return new $class($configRepository);
        }

        throw new InvalidArgumentException("Driver [$driver] not supported.");
    }
}
