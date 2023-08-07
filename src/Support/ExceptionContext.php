<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-exception-notify.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelExceptionNotify\Support;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;

/**
 * @see https://github.com/laravel/telescope/blob/4.x/src/ExceptionContext.php
 */
class ExceptionContext
{
    public static function get(\Throwable $throwable): array
    {
        return collect(static::getOriginal($throwable))
            ->tap(static function (Collection $collection) use (&$exceptionLine, $throwable, &$markedExceptionLine, &$maxLineLen): void {
                $exceptionLine = $throwable->getLine();
                $markedExceptionLine = sprintf('➤ %s', $exceptionLine);
                $maxLineLen = max(mb_strlen((string) array_key_last($collection->toArray())), mb_strlen($markedExceptionLine));
            })
            ->mapWithKeys(static function ($code, $line) use ($exceptionLine, $markedExceptionLine, $maxLineLen): array {
                $line === $exceptionLine and $line = $markedExceptionLine;
                $line = sprintf("%{$maxLineLen}s", $line);

                return [$line => $code];
            })
            ->all();
    }

    public static function getOriginal(\Throwable $throwable): array
    {
        return static::getEval($throwable) ?: static::getFile($throwable);
    }

    /**
     * @return null|array<int, string>|void
     */
    protected static function getEval(\Throwable $throwable)
    {
        if (Str::contains($throwable->getFile(), "eval()'d code")) {
            return [$throwable->getLine() => "eval()'d code"];
        }
    }

    protected static function getFile(\Throwable $throwable): array
    {
        return collect(explode(PHP_EOL, file_get_contents($throwable->getFile())))
            ->slice($throwable->getLine() - 10, 20)
            ->mapWithKeys(static fn ($value, $key): array => [$key + 1 => $value])
            ->all();
    }
}
