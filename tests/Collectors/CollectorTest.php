<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-exception-notify.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

use Guanguans\LaravelExceptionNotify\Collectors\ApplicationCollector;
use Guanguans\LaravelExceptionNotify\Collectors\ChoreCollector;
use Guanguans\LaravelExceptionNotify\Collectors\ExceptionBasicCollector;
use Guanguans\LaravelExceptionNotify\Collectors\ExceptionContextCollector;
use Guanguans\LaravelExceptionNotify\Collectors\ExceptionTraceCollector;
use Guanguans\LaravelExceptionNotify\Collectors\PhpInfoCollector;
use Guanguans\LaravelExceptionNotify\Collectors\RequestBasicCollector;
use Guanguans\LaravelExceptionNotify\Collectors\RequestCookieCollector;
use Guanguans\LaravelExceptionNotify\Collectors\RequestFileCollector;
use Guanguans\LaravelExceptionNotify\Collectors\RequestHeaderCollector;
use Guanguans\LaravelExceptionNotify\Collectors\RequestMiddlewareCollector;
use Guanguans\LaravelExceptionNotify\Collectors\RequestPostCollector;
use Guanguans\LaravelExceptionNotify\Collectors\RequestQueryCollector;
use Guanguans\LaravelExceptionNotify\Collectors\RequestRawFileCollector;
use Guanguans\LaravelExceptionNotify\Collectors\RequestServerCollector;
use Guanguans\LaravelExceptionNotify\Collectors\RequestSessionCollector;
use Guanguans\LaravelExceptionNotify\Contracts\CollectorContract;
use Guanguans\LaravelExceptionNotify\Contracts\ExceptionAwareContract;

it('can collect', function (): void {
    $collection = collect([
        ApplicationCollector::class,
        ChoreCollector::class,
        ExceptionBasicCollector::class,
        ExceptionContextCollector::class,
        ExceptionTraceCollector::class,
        PhpInfoCollector::class,
        RequestBasicCollector::class,
        RequestCookieCollector::class,
        RequestFileCollector::class,
        RequestHeaderCollector::class,
        RequestMiddlewareCollector::class,
        RequestPostCollector::class,
        RequestQueryCollector::class,
        RequestRawFileCollector::class,
        RequestServerCollector::class,
        RequestSessionCollector::class,
    ])->transform(function (string $class): CollectorContract {
        /** @var CollectorContract $collector */
        $collector = $this->app->make($class);
        if ($collector instanceof ExceptionAwareContract) {
            $collector->setException(new Exception());
        }

        return $collector;
    });

    expect($collection)->each(function (Pest\Expectation $collector): void {
        $collector->collect()->toBeArray();
    });
})->group(__DIR__, __FILE__);
