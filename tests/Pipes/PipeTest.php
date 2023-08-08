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
use Guanguans\LaravelExceptionNotify\Collectors\ChoreCollector;
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
    $collection = collect(app(CollectorManager::class))
        ->transform(static function (CollectorContract $collector): CollectorContract {
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
