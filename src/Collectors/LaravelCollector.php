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
            'Locale' => value(function () {
                if (! method_exists($this->app, 'getLocale')) {
                    return null;
                }

                return $this->app->getLocale();
            }),
            'In Console' => $this->app->runningInConsole(),
        ];
    }
}
