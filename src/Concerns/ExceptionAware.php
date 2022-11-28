<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-exception-notify.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelExceptionNotify\Concerns;

use Throwable;

trait ExceptionAware
{
    /**
     * @var \Throwable
     */
    protected $exception;

    public function setException(Throwable $throwable): void
    {
        $this->exception = $throwable;
    }
}
