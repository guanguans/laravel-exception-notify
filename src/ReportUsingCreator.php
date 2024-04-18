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

namespace Guanguans\LaravelExceptionNotify;

use Guanguans\LaravelExceptionNotify\Facades\ExceptionNotify;
use Illuminate\Contracts\Debug\ExceptionHandler;

/**
 * @property \Illuminate\Contracts\Container\Container $container
 *
 * @mixin \Illuminate\Foundation\Exceptions\Handler
 */
class ReportUsingCreator
{
    /**
     * @noinspection StaticClosureCanBeUsedInspection
     * @noinspection AnonymousFunctionStaticInspection
     *
     * @psalm-suppress UndefinedThisPropertyFetch
     * @psalm-suppress InaccessibleProperty
     */
    public function __invoke(ExceptionHandler $exceptionHandler): \Closure
    {
        return function (\Throwable $throwable) use ($exceptionHandler): void {
            ExceptionNotify::reportIf($exceptionHandler->shouldReport($throwable), $throwable);
        };
    }
}
