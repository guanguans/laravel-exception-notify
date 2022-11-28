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

use Guanguans\LaravelExceptionNotify\Concerns\ExceptionAware;
use Guanguans\LaravelExceptionNotify\Contracts\ExceptionAware as ExceptionAwareContract;
use Guanguans\LaravelExceptionNotify\Support\ExceptionContext;

class ExceptionBasicCollector extends Collector implements ExceptionAwareContract
{
    use ExceptionAware;

    /**
     * @return array{class: class-string<\Throwable>|true, message: string, code: int|string, file: string, line: int, preview: mixed[]}
     */
    public function collect()
    {
        return [
            'class' => get_class($this->exception),
            'message' => $this->exception->getmessage(),
            'code' => $this->exception->getCode(),
            'file' => $this->exception->getfile(),
            'line' => $this->exception->getLine(),
            'preview' => exceptioncontext::getformattedcontext($this->exception),
        ];
    }
}
