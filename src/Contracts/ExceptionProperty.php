<?php

/**
 * This file is part of the guanguans/laravel-exception-notify.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelExceptionNotify\Contracts;

use Throwable;

interface ExceptionProperty
{
    public function getException(): Throwable;

    public function setException(Throwable $exception);
}
