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
use Guanguans\LaravelExceptionNotify\Pipes\AddKeywordPipe;
use Guanguans\LaravelExceptionNotify\Pipes\ExceptKeysPipe;
use Guanguans\LaravelExceptionNotify\Pipes\FixPrettyJsonPipe;
use Guanguans\LaravelExceptionNotify\Pipes\LimitLengthPipe;
use Guanguans\LaravelExceptionNotify\Pipes\OnlyKeysPipe;
use Guanguans\LaravelExceptionNotify\Pipes\ReplaceStrPipe;
use Guanguans\LaravelExceptionNotify\Pipes\ToHtmlPipe;
use Guanguans\LaravelExceptionNotify\Pipes\ToMarkdownPipe;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Collection;
use Illuminate\Support\Stringable;

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

    $then = (new Pipeline($this->app))
        ->send($collection->mapWithKeys(static fn (CollectorContract $collector): array => [
            $collector::name() => $collector->collect(),
        ]))
        ->through([
            hydrate_pipe(OnlyKeysPipe::class, 'time|foo', ChoreCollector::name()),
            hydrate_pipe(ExceptKeysPipe::class, 'memory|foo', ChoreCollector::name()),
            hydrate_pipe(AddKeywordPipe::class, 'keyword'),
            ToHtmlPipe::class,
            ToMarkdownPipe::class,
            FixPrettyJsonPipe::class,
            hydrate_pipe(LimitLengthPipe::class, 512),
            hydrate_pipe(ReplaceStrPipe::class, '.php', '.PHP'),
        ])
        ->then(static fn (Collection $collectors): Stringable => str(to_pretty_json($collectors->jsonSerialize())));

    expect($then)->toBeInstanceOf(Stringable::class);
})->group(__DIR__, __FILE__);
