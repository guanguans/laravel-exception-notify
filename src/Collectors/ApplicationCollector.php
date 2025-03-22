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

use Guanguans\LaravelExceptionNotify\Support\Utils;
use Illuminate\Container\Container;
use Illuminate\Support\Carbon;

class ApplicationCollector extends AbstractCollector
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
            'php version' => \PHP_VERSION,
            'environment' => $this->container->environment(),
            'debug' => $this->container->hasDebugModeEnabled(),
            'locale' => $this->container->getLocale(),
            'in console' => $this->container->runningInConsole(),
            'memory' => Utils::humanBytes(memory_get_peak_usage(true)),
        ];
    }
}
