<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-exception-notify.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelExceptionNotify\Collectors;

use Guanguans\LaravelExceptionNotify\Support\ExceptionContext;

class ExceptionContextCollector extends ExceptionCollector
{
    public function collect(): array
    {
        return ExceptionContext::getMarked($this->exception);
    }
}
