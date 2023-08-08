<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-exception-notify.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

use Guanguans\LaravelExceptionNotify\CollectorManager;
use Guanguans\LaravelExceptionNotify\Contracts\CollectorContract;
use Guanguans\LaravelExceptionNotify\Contracts\ExceptionAwareContract;

it('can collect', function (): void {
    $collection = collect(app(CollectorManager::class))
        ->transform(static function (CollectorContract $collector): CollectorContract {
            if ($collector instanceof ExceptionAwareContract) {
                $collector->setException(new Exception());
            }

            return $collector;
        });

    expect($collection)->each(static function (Pest\Expectation $collector): void {
        $collector->collect()->toBeArray();
    });
})->group(__DIR__, __FILE__);
