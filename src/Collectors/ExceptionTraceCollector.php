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
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class ExceptionTraceCollector extends Collector implements ExceptionPropertyContract
{
    use ExceptionProperty;

    public function __construct(callable $pipe = null)
    {
        parent::__construct();
        $this->pipe = $pipe
            ?: function (Collection $traces) {
                return $traces->filter(function ($trace) {
                    return ! Str::contains($trace, 'vendor');
                });
            };
    }

    public function collect()
    {
        return collect($this->exception->getTrace())
            ->filter(function ($trace) {
                return isset($trace['file']) and isset($trace['line']);
            })
            ->map(function ($trace) {
                return $trace['file']."({$trace['line']})";
            })
            ->all();
    }
}
