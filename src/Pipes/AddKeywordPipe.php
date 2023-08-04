<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-exception-notify.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelExceptionNotify\Pipes;

use Illuminate\Support\Collection;

class AddKeywordPipe extends AddValuePipe
{
    public function handle(Collection $collectors, \Closure $next, $value, $key = 'keyword', ?string $collectorName = null): string
    {
        return parent::handle($collectors, $next, $value, $key, $collectorName);
    }
}