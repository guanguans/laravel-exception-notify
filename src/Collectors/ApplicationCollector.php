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

class ApplicationCollector extends Collector
{
    /** @var \Illuminate\Contracts\Container\Container|\Illuminate\Foundation\Application|\Laravel\Lumen\Application */
    protected $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * @return array<string, mixed>
     */
    public function collect(): array
    {
        return [
            'name' => config('app.name'),
            'version' => $this->container->version(),
            'environment' => $this->container->environment(),
            'locale' => method_exists($this->container, 'getLocale') ? $this->container->getLocale() : null,
            'in console' => $this->container->runningInConsole(),
        ];
    }
}
