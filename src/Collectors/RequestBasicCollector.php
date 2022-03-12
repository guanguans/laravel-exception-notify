<?php

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
    /**
     * @var \Illuminate\Http\Request
     */
    protected $request;

    public function __construct(Request $request, callable $pipe = null)
    {
        parent::__construct($pipe);
        $this->request = $request;
    }

    public function collect()
    {
        return [
            'Url' => $this->request->url(),
            'Ip' => $this->request->ip(),
            'Method' => $this->request->method(),
            'Action' => optional($this->request->route())->getActionName(),
            'Duration' => value(function () {
                $startTime = defined('LARAVEL_START') ? LARAVEL_START : $this->request->server('REQUEST_TIME_FLOAT');

                return floor((microtime(true) - $startTime) * 1000).'ms';
            }),
        ];
    }
}
