<?php

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
     * @var \Throwable|null
     */
    protected $exception;

    public function setException(Throwable $exception)
    {
        $this->exception = $exception;
    }
}
