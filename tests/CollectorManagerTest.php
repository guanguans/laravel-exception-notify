<?php

/** @noinspection AnonymousFunctionStaticInspection */
/** @noinspection StaticClosureCanBeUsedInspection */

declare(strict_types=1);

/**
 * Copyright (c) 2021-2025 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-exception-notify
 */

namespace Guanguans\LaravelExceptionNotify\Tests;

use Guanguans\LaravelExceptionNotify\CollectorManager;
use Guanguans\LaravelExceptionNotify\Exceptions\RuntimeException;
use Guanguans\LaravelExceptionNotify\Pipes\LimitLengthPipe;
use Guanguans\LaravelExceptionNotify\Pipes\SprintfHtmlPipe;
use Illuminate\Support\Str;

it('can map to reports', function (): void {
    collect(config('exception-notify.channels'))->each(fn (array $config, string $name) => config()->set(
        "exception-notify.channels.$name.pipes",
        collect($config['pipes'] ?? [])
            ->reject(fn (string $pipe) => Str::contains($pipe, SprintfHtmlPipe::class))
            ->push(LimitLengthPipe::with(512))
            ->all()
    ));

    $reports = app(CollectorManager::class)->mapToReports(
        array_keys(config('exception-notify.channels')),
        new RuntimeException
    );

    expect(array_map(fn ($report): string => trim($report, " \n\r\t\v\0`"), $reports))->each->toBeJson();
})->group(__DIR__, __FILE__);
