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

class ChoreCollector extends Collector
{
    public function collect(): array
    {
        return [
            'time' => date('Y-m-d H:i:s'),
            'memory' => human_bytes(memory_get_peak_usage(true)),
        ];
    }
}
