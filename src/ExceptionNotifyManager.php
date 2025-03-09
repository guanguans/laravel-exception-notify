<?php

/** @noinspection PhpUnused */
/** @noinspection PhpUnusedPrivateMethodInspection */

declare(strict_types=1);

/**
 * Copyright (c) 2021-2025 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-exception-notify
 */

namespace Guanguans\LaravelExceptionNotify;

use Guanguans\LaravelExceptionNotify\Channels\AbstractChannel;
use Guanguans\LaravelExceptionNotify\Channels\Channel;
use Guanguans\LaravelExceptionNotify\Contracts\ChannelContract;
use Guanguans\LaravelExceptionNotify\Exceptions\InvalidArgumentException;
use Illuminate\Config\Repository;
use Illuminate\Support\Manager;
use Illuminate\Support\Str;
use Illuminate\Support\Traits\Macroable;
use Illuminate\Support\Traits\Tappable;
use function Guanguans\LaravelExceptionNotify\Support\rescue;

/**
 * @property \Illuminate\Foundation\Application $container
 *
 * @method \Guanguans\LaravelExceptionNotify\Channels\Channel driver($driver = null)
 *
 * @mixin \Guanguans\LaravelExceptionNotify\Channels\Channel
 */
class ExceptionNotifyManager extends Manager implements ChannelContract
{
    use Macroable {
        Macroable::__call as macroCall;
    }
    use Tappable;

    public function __call(mixed $method, mixed $parameters)
    {
        if (static::hasMacro($method)) {
            return $this->macroCall($method, $parameters);
        }

        return parent::__call($method, $parameters);
    }

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

    public function getDefaultDriver(): string
    {
        return config('exception-notify.default');
    }

    /**
     * @noinspection MethodShouldBeFinalInspection
     * @noinspection MissingParentCallInspection
     */
    protected function createDriver(mixed $driver): Channel
    {
        $channelContract = $this->createOriginalDriver($driver);

        return $channelContract instanceof Channel ? $channelContract : new Channel($channelContract);
    }

    protected function createOriginalDriver(mixed $driver): ChannelContract
    {
        if (isset($this->customCreators[$driver])) {
            return $this->callCustomCreator($driver);
        }

        $configRepository = tap(
            new Repository($this->config->get("exception-notify.channels.$driver", [])),
            static function (Repository $configRepository) use ($driver): void {
                $configRepository->set(AbstractChannel::CHANNEL_KEY, $driver);
            }
        );

        $studlyName = Str::studly($configRepository->get('driver', $driver));

        if (method_exists($this, $method = "create{$studlyName}Driver")) {
            return $this->{$method}($configRepository);
        }

        if (class_exists($class = "\\Guanguans\\LaravelExceptionNotify\\Channels\\{$studlyName}Channel")) {
            return new $class($configRepository);
        }

        throw new InvalidArgumentException("Driver [$driver] not supported.");
    }
}
