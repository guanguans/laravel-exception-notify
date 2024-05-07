<?php

declare(strict_types=1);

/**
 * Copyright (c) 2021-2024 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-exception-notify
 */

namespace Guanguans\LaravelExceptionNotify\Collectors;

class ChoreCollector extends Collector
{
    public function collect(): array
    {
        return [
            // 'time' => date('Y-m-d H:i:s'),
            // 'memory' => human_bytes(memory_get_peak_usage(true)),
        ];
    }
}
