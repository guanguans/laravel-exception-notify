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
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class ExceptionTraceCollector extends Collector implements ExceptionAwareContract
{
    use ExceptionAware;

    /**
     * @noinspection MagicMethodsValidityInspection
     * @noinspection PhpMissingParentConstructorInspection
     */
    public function __construct(callable $pipe = null)
    {
        $this->pipe = $pipe
            ?: static function (Collection $collection) {
                return $collection
                    ->filter(static function ($trace) {
                        return ! Str::contains($trace, 'vendor');
                    })
                    ->values();
            };
    }

    /**
     * @return string[]
     */
    public function collect()
    {
        return explode("\n", $this->exception->getTraceAsString());
    }
}
