<?php

/**
 * This file is part of the guanguans/laravel-exception-notify.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelExceptionNotify\Collectors;

use Guanguans\LaravelExceptionNotify\Concerns\ExceptionProperty;
use Guanguans\LaravelExceptionNotify\Contracts\ExceptionProperty as ExceptionPropertyContract;
use Guanguans\LaravelExceptionNotify\Support\ExceptionContext;

class ExceptionBasicCollector extends Collector implements ExceptionPropertyContract
{
    use ExceptionProperty;

    public function collect()
    {
        return [
            'Class' => get_class($this->exception),
            'Message' => $this->exception->getMessage(),
            'Code' => $this->exception->getCode(),
            'File' => $this->exception->getFile(),
            'Line' => $this->exception->getLine(),
            'Preview' => ExceptionContext::getFormattedContext($this->exception),
        ];
    }
}