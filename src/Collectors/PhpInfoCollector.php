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

namespace Guanguans\LaravelExceptionNotify\Collectors;

use function Guanguans\LaravelExceptionNotify\Support\human_bytes;

class PhpInfoCollector extends AbstractCollector
{
    public function collect(): array
    {
        return [
            'version' => \PHP_VERSION,
            'interface' => \PHP_SAPI,
            'memory' => human_bytes(memory_get_peak_usage(true)),
        ];
    }
}
