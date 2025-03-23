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

use Guanguans\LaravelExceptionNotify\Support\Utils;
use Illuminate\Http\Request;

class RequestBasicCollector extends AbstractCollector
{
    public function __construct(private Request $request) {}

    public function collect(): array
    {
        return [
            'url' => $this->request->url(),
            'ip' => $this->request->ip(),
            'method' => $this->request->method(),
            'controller action' => $this->request->route()?->getActionName(),
            'memory' => Utils::humanBytes(memory_get_peak_usage(true)),
            'duration' => blank($startTime = \defined('LARAVEL_START') ? LARAVEL_START : $this->request->server('REQUEST_TIME_FLOAT'))
                ? 'Unknown'
                : Utils::humanMilliseconds((microtime(true) - $startTime) * 1000),
        ];
    }
}
