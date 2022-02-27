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
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class ExceptionCollector extends Collector implements ExceptionPropertyContract
{
    use ExceptionProperty;

    protected $options = [
        'with_preview' => true,
        'with_trace' => [self::class, 'filterTrace'],
    ];

    public function __construct($options = [])
    {
        $this->set($options);
    }

    public function collect(): array
    {
        return [
            'Class' => get_class($this->exception),
            'Message' => $this->exception->getMessage(),
            'Code' => $this->exception->getCode(),
            'File' => $this->exception->getFile(),
            'Line' => $this->exception->getLine(),
            'Preview' => ExceptionContext::getFormattedContext($this->exception),
            'Trace' => transform($this->exception->getTrace(), function ($trace) {
                if (! $this['with_trace']) {
                    return;
                }

                return collect($trace)
                    ->filter(function ($trace) {
                        return isset($trace['file']) and isset($trace['line']);
                    })
                    ->when(is_callable($this['with_trace']), function (Collection $traces) {
                        return $traces->filter($this['with_trace']);
                    })
                    ->map(function ($trace) {
                        return $trace['file']."({$trace['line']})";
                    })
                    ->values()
                    ->all();
            }),
        ];
    }

    public static function filterTrace(array $trace): bool
    {
        return ! Str::contains($trace['file'], 'vendor');
    }
}
