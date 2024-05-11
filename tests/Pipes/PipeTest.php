<?php

/** @noinspection AnonymousFunctionStaticInspection */
/** @noinspection StaticClosureCanBeUsedInspection */

declare(strict_types=1);

/**
 * Copyright (c) 2021-2024 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-exception-notify
 */

use Guanguans\LaravelExceptionNotify\CollectorManager;
use Guanguans\LaravelExceptionNotify\Contracts\Collector;
use Guanguans\LaravelExceptionNotify\Contracts\ExceptionAware;
use Guanguans\LaravelExceptionNotify\Exceptions\RuntimeException;
use Guanguans\LaravelExceptionNotify\Pipes\FixPrettyJsonPipe;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Collection;
use Illuminate\Support\Stringable;

it('can collect', function (): void {
    $report = (new Pipeline($this->app))
        ->send(
            collect(app(CollectorManager::class))
                ->transform(static function (Collector $collector): Collector {
                    if ($collector instanceof ExceptionAware) {
                        $collector->setException(new RuntimeException);
                    }

                    return $collector;
                })
                ->mapWithKeys(static fn (Collector $collector): array => [
                    $collector::name() => $collector->collect(),
                ])
        )
        ->through(FixPrettyJsonPipe::class)
        ->then(
            /**
             * @throws JsonException
             */
            static fn (
                Collection $collectors
            ): Stringable => str(json_pretty_encode($collectors->jsonSerialize()))->substr(-256)
        );

    expect($report)->toBeInstanceOf(Stringable::class);
})->group(__DIR__, __FILE__);
