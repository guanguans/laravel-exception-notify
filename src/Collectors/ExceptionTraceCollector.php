<?php

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
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class ExceptionTraceCollector extends Collector implements ExceptionAwareContract
{
    use ExceptionAware;

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
        return collect(explode("\n", $this->exception->getTraceAsString()))
            ->transform(function ($trace, $index) {
                return ltrim($trace, "#$index ");
            })
            ->all();
    }
}
