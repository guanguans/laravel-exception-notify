<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-exception-notify.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelExceptionNotify;

/**
 * @property \Illuminate\Contracts\Container\Container $container
 *
 * @mixin \Illuminate\Foundation\Exceptions\Handler
 */
class ReportUsingCreator
{
    /**
     * @psalm-suppress UndefinedThisPropertyFetch
     * @psalm-suppress InaccessibleProperty
     */
    public function __invoke(): \Closure
    {
        return function (\Throwable $e): void {
            $this->container->make(ExceptionNotifyManager::class)->reportIf($this->shouldReport($e), $e);
        };
    }
}
