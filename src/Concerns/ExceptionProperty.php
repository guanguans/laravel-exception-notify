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

trait ExceptionProperty
{
    /**
     * @var \Throwable
     */
    protected $exception;

    public function getException(): Throwable
    {
        return $this->exception;
    }

    public function setException(Throwable $exception)
    {
        $this->exception = $exception;
    }
}
