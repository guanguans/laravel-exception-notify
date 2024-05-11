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

use Illuminate\Container\Container;

class ApplicationCollector extends Collector
{
    /** @var \Illuminate\Foundation\Application */
    protected Container $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function collect(): array
    {
        return [
            'time' => date('Y-m-d H:i:s'),
            'name' => config('app.name'),
            'version' => $this->container->version(),
            'environment' => $this->container->environment(),
            'debug' => config('app.debug'),
            'locale' => $this->container->getLocale(),
            'in console' => $this->container->runningInConsole(),
        ];
    }
}
