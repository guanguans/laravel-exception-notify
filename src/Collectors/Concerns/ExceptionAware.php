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
