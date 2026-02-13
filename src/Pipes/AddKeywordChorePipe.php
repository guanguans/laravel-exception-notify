<?php

declare(strict_types=1);

/**
 * Copyright (c) 2021-2026 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-exception-notify
 */

namespace Guanguans\LaravelExceptionNotify\Pipes;

use Guanguans\LaravelExceptionNotify\Support\Traits\WithPipeArgs;
use Illuminate\Support\Collection;
use Illuminate\Support\Stringable;

class AddKeywordChorePipe extends AddChorePipe
{
    use WithPipeArgs;

    public function handle(Collection $collectors, \Closure $next, mixed $value, mixed $key = 'Keyword'): Stringable
    {
        return parent::handle($collectors, $next, $value, $key);
    }
}
