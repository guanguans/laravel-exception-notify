<?php

/**
 * This file is part of the guanguans/laravel-exception-notify.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelExceptionNotify\Collectors;

class AnnexCollector extends Collector
{
    public function collect()
    {
        return [
            'Time' => date('Y-m-d H:i:s'),
            'Memory' => round(memory_get_peak_usage(true) / 1024 / 1024, 1).'M',
        ];
    }
}