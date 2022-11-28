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

class AdditionCollector extends Collector
{
    /**
     * @return array{time: string, memory: string}
     */
    public function collect()
    {
        return [
            'time' => date('Y-m-d H:i:s'),
            'memory' => round(memory_get_peak_usage(true) / 1024 / 1024, 1).'M',
        ];
    }
}
