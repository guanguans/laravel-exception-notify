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
     *
     * @return array
     */
    public static function getFormattedContext(\Throwable $e)
    {
        return collect(static::get($e))
            ->tap(function (Collection $context) use ($e, &$exceptionLine, &$markedExceptionLine, &$maxLineLen): void {
                $exceptionLine = $e->getLine();
                $markedExceptionLine = sprintf('➤ %s', $exceptionLine);
                $maxLineLen = max(mb_strlen((string) array_key_last($context->toArray())), mb_strlen($markedExceptionLine));
            })
            ->mapWithKeys(function ($code, $line) use (&$exceptionLine, &$markedExceptionLine, &$maxLineLen) {
                $line === $exceptionLine and $line = $markedExceptionLine;
                $line = sprintf("%{$maxLineLen}s", $line);

                return [$line => $code];
            })
            ->all();
    }

    /**
     * Get the exception code context for the given exception.
     *
     * @return array
     */
    public static function get(\Throwable $e)
    {
        return static::getEvalContext($e) ?? static::getFileContext($e);
    }

    /**
     * Get the exception code context when eval() failed.
     *
     * @return array|null
     */
    protected static function getEvalContext(\Throwable $e)
    {
        if (Str::contains($e->getFile(), "eval()'d code")) {
            return [$e->getLine() => "eval()'d code"];
        }
    }

    /**
     * Get the exception code context from a file.
     *
     * @return array
     */
    protected static function getFileContext(\Throwable $e)
    {
        return collect(explode("\n", file_get_contents($e->getFile())))
            ->slice($e->getLine() - 10, 20)
            ->mapWithKeys(fn ($value, $key) => [$key + 1 => $value])
            ->all();
    }
}
