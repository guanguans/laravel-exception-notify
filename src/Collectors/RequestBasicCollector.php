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

use Illuminate\Http\Request;

class RequestBasicCollector extends Collector
{
    private Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function collect(): array
    {
        return [
            'url' => $this->request->url(),
            'ip' => $this->request->ip(),
            'method' => $this->request->method(),
            'action' => optional($this->request->route())->getActionName(),
            'duration' => value(function (): string {
                $startTime = \defined('LARAVEL_START')
                    ? LARAVEL_START
                    : $this->request->server('REQUEST_TIME_FLOAT', $_SERVER['REQUEST_TIME_FLOAT']);

                return human_milliseconds((microtime(true) - $startTime) * 1000);
            }),
        ];
    }
}
