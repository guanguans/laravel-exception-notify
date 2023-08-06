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

use Guanguans\LaravelExceptionNotify\Collectors\Concerns\ExceptionAware;
use Guanguans\LaravelExceptionNotify\Contracts\ExceptionAwareContract;
use Guanguans\LaravelExceptionNotify\Support\ExceptionContext;

class ExceptionPreviewCollector extends Collector implements ExceptionAwareContract
{
    use ExceptionAware;

    public function collect(): array
    {
        return ExceptionContext::getFormattedContext($this->exception);
    }
}
