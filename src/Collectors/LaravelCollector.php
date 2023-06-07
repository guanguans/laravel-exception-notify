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

use Illuminate\Contracts\Container\Container;

class LaravelCollector extends Collector
{
    /**
     * @var \Illuminate\Foundation\Application|\Illuminate\Contracts\Container\Container
     */
    protected $app;

    public function __construct(Container $container, callable $pipe = null)
    {
        parent::__construct($pipe);
        $this->app = $container;
    }

    /**
     * @return array<string, mixed>
     */
    public function collect()
    {
        return [
            'name' => $this->app['config']['app.name'],
            'version' => $this->app->version(),
            'environment' => $this->app->environment(),
            'locale' => value(function () {
                if (! method_exists($this->app, 'getLocale')) {
                    return null;
                }

                return $this->app->getLocale();
            }),
            'in console' => $this->app->runningInConsole(),
        ];
    }
}
