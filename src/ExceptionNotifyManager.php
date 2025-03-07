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

use Guanguans\LaravelExceptionNotify\Channels\Channel;
use Guanguans\LaravelExceptionNotify\Exceptions\InvalidArgumentException;
use Illuminate\Config\Repository;
use Illuminate\Support\Manager;
use Illuminate\Support\Str;
use Illuminate\Support\Traits\Macroable;
use Illuminate\Support\Traits\Tappable;

/**
 * @property \Illuminate\Foundation\Application $container
 *
 * @method \Guanguans\LaravelExceptionNotify\Channels\Channel driver($driver = null)
 *
 * @mixin \Guanguans\LaravelExceptionNotify\Channels\Channel
 */
class ExceptionNotifyManager extends Manager implements Contracts\Channel
{
    use Macroable {
        Macroable::__call as macroCall;
    }
    use Tappable;

    /**
     * @noinspection MissingReturnTypeInspection
     */
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

    public function reportIf(mixed $condition, \Throwable $throwable): void
    {
        value($condition) and $this->report($throwable);
    }

    public function report(\Throwable $throwable): void
    {
        $this->driver()->report($throwable);
    }

    public function reportRaw(string $report): mixed
    {
        return $this->driver()->reportRaw($report);
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
        $rawChannel = $this->createRawDriver($driver);

        return $rawChannel instanceof Channel ? $rawChannel : new Channel($rawChannel);
    }

    protected function createRawDriver(mixed $driver): Channel
    {
        if (isset($this->customCreators[$driver])) {
            return $this->callCustomCreator($driver);
        }

        $configRepository = new Repository($this->config->get("exception-notify.channels.$driver", []));
        $configRepository->set('__channel', $driver);

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
