<?php

declare(strict_types=1);

/**
 * Copyright (c) 2021-2025 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-exception-notify
 */

namespace Guanguans\LaravelExceptionNotify\Collectors;

use Carbon\Carbon;
use Illuminate\Container\Container;

class ApplicationCollector extends Collector
{
    public function __construct(
        /** @var \Illuminate\Foundation\Application */
        private Container $container
    ) {}

    public function collect(): array
    {
        return [
            'time' => Carbon::now()->format('Y-m-d H:i:s'),
            'name' => config('app.name'),
            'version' => $this->container->version(),
            'environment' => $this->container->environment(),
            'debug' => config('app.debug'),
            'locale' => $this->container->getLocale(),
            'in console' => $this->container->runningInConsole(),
        ];
    }
}
