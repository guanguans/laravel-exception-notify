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

class RequestCollector extends Collector
{
    /**
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * @var array
     */
    protected $options = [
        'with_middleware' => false,
        'with_header' => true,
        'with_query' => false,
        'with_post' => true,
        'with_file' => false,
        'with_server' => false,
        'with_cookie' => false,
        'with_session' => false,
    ];

    public function __construct(Request $request, $options = [])
    {
        $this->request = $request;
        $this->set($options);
    }

    public function collect(): array
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
            'Middleware' => $this['with_middleware'] ? array_values(optional($this->request->route())->gatherMiddleware() ?? []) : null,
            'Header' => $this['with_header'] ? $this->request->headers() : null,
            'Query' => $this['with_query'] ? $this->request->query() : null,
            'Post' => $this['with_post'] ? $this->request->post() : null,
            'File' => $this['with_file'] ? $this->request->allFiles() : null,
            'Server' => $this['with_server'] ? $this->request->server() : null,
            'Cookie' => $this['with_cookie'] ? $this->request->cookie() : null,
            'Session' => $this['with_session'] ? optional($this->request->getSession())->all() : null,
        ];
    }
}
