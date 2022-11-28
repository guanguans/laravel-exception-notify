<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-exception-notify.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelExceptionNotify\Contracts;

use Illuminate\Contracts\Support\Arrayable;

interface Collector extends \Stringable, Arrayable
{
    public function getName(): string;

    public function collect();
}
