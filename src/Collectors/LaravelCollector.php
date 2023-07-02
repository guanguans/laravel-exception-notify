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
    /** @var \Illuminate\Contracts\Container\Container|\Illuminate\Foundation\Application */
    protected $app;

    public function __construct(Container $container)
    {
        $this->app = $container;
    }

    /**
     * @return array<string, mixed>
     */
    public function collect(): array
    {
        return [
            'name' => $this->app['config']['app.name'],
            'version' => $this->app->version(),
            'environment' => $this->app->environment(),
            'locale' => value(function () {
                if (! method_exists($this->app, 'getLocale')) {
                    return;
                }

                return $this->app->getLocale();
            }),
            'in console' => $this->app->runningInConsole(),
        ];
    }
}
