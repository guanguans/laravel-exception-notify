<?php

/** @noinspection PhpUnused */
/** @noinspection PhpUndefinedClassInspection */
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

namespace Tests;

use Guanguans\LaravelExceptionNotify\ExceptionNotifyManager;
use Guanguans\LaravelExceptionNotify\Tests\TestCase;

uses(TestCase::class)
    ->beforeAll(function (): void {})
    ->beforeEach(function (): void {
        (fn (): array => self::$skipCallbacks = [])->call(app(ExceptionNotifyManager::class));
    })
    ->afterEach(function (): void {})
    ->afterAll(function (): void {})
    ->in(__DIR__);

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
 */

expect()->extend('toBetween', fn (int $min, int $max): Expectation => expect($this->value)
    ->toBeGreaterThanOrEqual($min)
    ->toBeLessThanOrEqual($max));

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
 */

/**
 * @param object|string $class
 *
 * @throws ReflectionException
 */
function class_namespace($class): string
{
    $class = \is_object($class) ? \get_class($class) : $class;

    return (new ReflectionClass($class))->getNamespaceName();
}

function fixtures_path(string $path = ''): string
{
    return __DIR__.\DIRECTORY_SEPARATOR.'fixtures'.($path ? \DIRECTORY_SEPARATOR.$path : $path);
}
