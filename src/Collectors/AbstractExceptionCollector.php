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

namespace Guanguans\LaravelExceptionNotify\Collectors;

use Guanguans\LaravelExceptionNotify\Contracts\ExceptionAwareContract;
use Symfony\Component\ErrorHandler\Exception\FlattenException;

abstract class AbstractExceptionCollector extends AbstractCollector implements ExceptionAwareContract
{
    protected \Throwable $exception;
    protected FlattenException $flattenException;

    public function setException(\Throwable $throwable): void
    {
        $this->exception = $throwable;
        $this->flattenException = FlattenException::createFromThrowable($throwable);
    }
}
