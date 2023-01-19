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
 * This is file is modified from the laravel/telescope.
 */
class ExceptionContext
{
    /**
     * Get the formatted exception code context for the given exception.
     */
    public static function getFormattedContext(\Throwable $throwable): array
    {
        return collect(static::get($throwable))
            ->tap(static function (Collection $collection) use ($throwable, &$exceptionLine, &$markedExceptionLine, &$maxLineLen): void {
                $exceptionLine = $throwable->getLine();
                $markedExceptionLine = sprintf('➤ %s', $exceptionLine);
                $maxLineLen = max(mb_strlen((string) array_key_last($collection->toArray())), mb_strlen($markedExceptionLine));
            })
            ->mapWithKeys(static function ($code, $line) use (&$exceptionLine, &$markedExceptionLine, &$maxLineLen): array {
                $line === $exceptionLine and $line = $markedExceptionLine;
                $line = sprintf("%{$maxLineLen}s", $line);

                return [$line => $code];
            })
            ->all();
    }

    /**
     * Get the exception code context for the given exception.
     */
    public static function get(\Throwable $throwable): array
    {
        return static::getEvalContext($throwable) ?: static::getFileContext($throwable);
    }

    /**
     * Get the exception code context when eval() failed.
     *
     * @return array<int, string>|void|null
     */
    protected static function getEvalContext(\Throwable $throwable)
    {
        if (Str::contains($throwable->getFile(), "eval()'d code")) {
            return [$throwable->getLine() => "eval()'d code"];
        }
    }

    /**
     * Get the exception code context from a file.
     */
    protected static function getFileContext(\Throwable $throwable): array
    {
        return collect(explode("\n", file_get_contents($throwable->getFile())))
            ->slice($throwable->getLine() - 10, 20)
            ->mapWithKeys(static function ($value, $key): array {
                return [$key + 1 => $value];
            })
            ->all();
    }
}
