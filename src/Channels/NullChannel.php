<?php

/**
 * This file is part of the guanguans/laravel-exception-notify.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelExceptionNotify\Channels;

use Guanguans\LaravelExceptionNotify\Contracts\Channel;

class NullChannel implements Channel
{
    public function getName(): string
    {
        return 'null';
    }

    public function report(string $report)
    {
    }
}
