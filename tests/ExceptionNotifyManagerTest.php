<?php

/** @noinspection AnonymousFunctionStaticInspection */
/** @noinspection NullPointerExceptionInspection */
/** @noinspection PhpInternalEntityUsedInspection */
/** @noinspection PhpUnhandledExceptionInspection */
/** @noinspection PhpVoidFunctionResultUsedInspection */
/** @noinspection StaticClosureCanBeUsedInspection */

declare(strict_types=1);

/**
 * Copyright (c) 2021-2026 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-exception-notify
 */

use Guanguans\LaravelExceptionNotify\Channels\Channel;
use Guanguans\LaravelExceptionNotify\Contracts\ChannelContract;
use Guanguans\LaravelExceptionNotify\ExceptionNotifyManager;
use Guanguans\LaravelExceptionNotify\Exceptions\InvalidArgumentException;
use Guanguans\LaravelExceptionNotify\Exceptions\RuntimeException;

it('can call', function (): void {
    ExceptionNotifyManager::macro('foo', fn ($param) => $param);
    expect(resolve(ExceptionNotifyManager::class))
        ->foo('foo')->toBe('foo');
})->group(__DIR__, __FILE__);

it('can return Channel', function (): void {
    expect(resolve(ExceptionNotifyManager::class)->channel('log'))
        ->toBeInstanceOf(Channel::class);
})->group(__DIR__, __FILE__);

it('can report', function (): void {
    expect(resolve(ExceptionNotifyManager::class))
        ->report(new RuntimeException('testing'))
        ->toBeNull();
})->group(__DIR__, __FILE__);

it('can report content', function (): void {
    expect(resolve(ExceptionNotifyManager::class))
        ->reportContent('testing')
        ->toBeArray();
})->group(__DIR__, __FILE__);

it('will throw `InvalidArgumentException`', function (): void {
    resolve(ExceptionNotifyManager::class)->driver('foo');
})->group(__DIR__, __FILE__)->throws(InvalidArgumentException::class);

it('can create custom driver', function (): void {
    resolve(ExceptionNotifyManager::class)->extend(
        'foo',
        static fn (): ChannelContract => new class implements ChannelContract {
            public function report(Throwable $throwable): void {}

            public function reportContent(string $content): mixed
            {
                return null;
            }
        }
    );

    expect(resolve(ExceptionNotifyManager::class))->driver('foo')->toBeInstanceOf(ChannelContract::class);
})->group(__DIR__, __FILE__);
