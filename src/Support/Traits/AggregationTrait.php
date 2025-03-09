<?php

declare(strict_types=1);

/**
 * Copyright (c) 2021-2025 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-exception-notify
 */

namespace Guanguans\LaravelExceptionNotify\Support\Traits;

use Guanguans\Notify\Foundation\Concerns\Dumpable;
use Illuminate\Support\Traits\Conditionable;
use Illuminate\Support\Traits\ForwardsCalls;
use Illuminate\Support\Traits\Localizable;
use Illuminate\Support\Traits\Macroable;
use Illuminate\Support\Traits\Tappable;

trait AggregationTrait
{
    use Conditionable;
    use Dumpable;
    use ForwardsCalls;
    use Localizable;
    use Macroable;
    use Tappable;
}
