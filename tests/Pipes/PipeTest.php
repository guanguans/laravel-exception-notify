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

use Guanguans\LaravelExceptionNotify\CollectorManager;
use Guanguans\LaravelExceptionNotify\Contracts\CollectorContract;
use Guanguans\LaravelExceptionNotify\Contracts\ExceptionAware;
use Guanguans\LaravelExceptionNotify\Exceptions\RuntimeException;
use Guanguans\LaravelExceptionNotify\Pipes\FixPrettyJsonPipe;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Collection;
use Illuminate\Support\Stringable;
use function Guanguans\LaravelExceptionNotify\Support\json_pretty_encode;

it('can collect', function (): void {
    $report = (new Pipeline($this->app))
        ->send(
            collect(app(CollectorManager::class))
                ->transform(static function (CollectorContract $collectorContract): CollectorContract {
                    if ($collectorContract instanceof ExceptionAware) {
                        $collectorContract->setException(new RuntimeException);
                    }

                    return $collectorContract;
                })
                ->mapWithKeys(static fn (CollectorContract $collectorContract): array => [
                    $collectorContract::name() => $collectorContract->collect(),
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
})->group(__DIR__, __FILE__)->skip();
