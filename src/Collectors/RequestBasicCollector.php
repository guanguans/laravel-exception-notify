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

use Illuminate\Http\Request;

class RequestBasicCollector extends Collector
{
    protected Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @psalm-suppress InvalidScalarArgument
     * @psalm-suppress InvalidArgument
     */
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

                return floor((microtime(true) - $startTime) * 1000).'ms';
            }),
        ];
    }
}
