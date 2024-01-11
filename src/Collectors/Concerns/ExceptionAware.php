<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-exception-notify.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelExceptionNotify\Collectors\Concerns;

use Symfony\Component\ErrorHandler\Exception\FlattenException;

trait ExceptionAware
{
    protected \Throwable $exception;

    protected FlattenException $flattenException;

    public function setException(\Throwable $throwable): void
    {
        $this->exception = $throwable;

        $this->flattenException = FlattenException::createFromThrowable($throwable);
    }
}
