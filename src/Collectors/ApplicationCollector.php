<?php

declare(strict_types=1);

/**
 * Copyright (c) 2021-2026 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-exception-notify
 */

namespace Guanguans\LaravelExceptionNotify\Collectors;

use Illuminate\Container\Container;
use Illuminate\Support\Facades\Date;

class ApplicationCollector extends AbstractCollector
{
    public function __construct(
        /** @var \Illuminate\Foundation\Application */
        private readonly Container $container
    ) {}

    /**
     * @see \Illuminate\Foundation\Console\AboutCommand::gatherApplicationInformation()
     *
     * @return array<string, mixed>
     */
    public function collect(): array
    {
        return [
            'Time' => Date::now()->format('Y-m-d H:i:s'),
            'Name' => config('app.name'),
            'Version' => $this->container->version(),
            'PHP Version' => \PHP_VERSION,
            'Environment' => $this->container->environment(),
            'In Console' => $this->container->runningInConsole(),
            'Debug Mode' => $this->container->hasDebugModeEnabled(),
            'Maintenance Mode' => $this->container->isDownForMaintenance(),
            'Timezone' => config('app.timezone'),
            'Locale' => config('app.locale'),
        ];
    }
}
