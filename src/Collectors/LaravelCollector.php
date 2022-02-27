<?php

/**
 * This file is part of the guanguans/laravel-exception-notify.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelExceptionNotify\Collectors;

use Illuminate\Contracts\Container\Container;

class LaravelCollector extends Collector
{
    /**
     * @var \Illuminate\Contracts\Container\Container
     */
    protected $app;

    public function __construct(Container $app)
    {
        $this->app = $app;
    }

    public function collect(): array
    {
        return [
            'Name' => $this->app['config']['app.name'],
            'Version' => $this->app->version(),
            'Environment' => $this->app->environment(),
            'Locale' => $this->app->getLocale(),
        ];
    }
}
