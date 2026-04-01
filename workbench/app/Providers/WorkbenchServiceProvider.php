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

namespace Workbench\App\Providers;

use Guanguans\LaravelExceptionNotify\Channels\AbstractChannel;
use Guanguans\LaravelExceptionNotify\Facades\ExceptionNotify;
use Illuminate\Config\Repository;
use Illuminate\Support\ServiceProvider;

class WorkbenchServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @noinspection PhpMissingParentCallCommonInspection
     */
    public function register(): void
    {
        // ...
    }

    /**
     * Bootstrap services.
     *
     * @noinspection StaticClosureCanBeUsedInspection
     */
    public function boot(): void
    {
        ExceptionNotify::extend(
            'dump',
            fn (): AbstractChannel => new class(tap(
                new Repository(config('exception-notify.channels.dump', ['driver' => 'dump'])),
                static fn (Repository $configRepository): null => $configRepository->set('__channel', 'dump')
            )) extends AbstractChannel {
                /**
                 * @noinspection ForgottenDebugOutputInspection
                 * @noinspection DebugFunctionUsageInspection
                 */
                public function reportContent(string $content): string
                {
                    return dump($content);
                }

                /**
                 * @return array<string, mixed>
                 */
                protected function rules(): array
                {
                    return [];
                }
            }
        );
    }
}
