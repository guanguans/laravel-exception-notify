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

use Illuminate\Http\Request;

class RequestBasicCollector extends Collector
{
    public function __construct(private Request $request) {}

    public function collect(): array
    {
        return [
            'url' => $this->request->url(),
            'ip' => $this->request->ip(),
            'method' => $this->request->method(),
            'action' => $this->request->route()?->getActionName(),
            'duration' => (function (): string {
                $startTime = \defined('LARAVEL_START')
                    ? LARAVEL_START
                    : $this->request->server('REQUEST_TIME_FLOAT', $_SERVER['REQUEST_TIME_FLOAT']);

                return \Guanguans\LaravelExceptionNotify\Support\human_milliseconds((microtime(true) - $startTime) * 1000);
            })(),
        ];
    }
}
