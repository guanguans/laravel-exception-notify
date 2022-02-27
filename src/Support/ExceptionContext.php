<?php

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
use Throwable;

/**
 * This is file is modified from the laravel/telescope.
 */
class ExceptionContext
{
    /**
     * Get the formatted exception code context for the given exception.
     *
     * @return string
     */
    public static function getFormattedContext(Throwable $e, $wrapSkeleton = "[\n%s  ]")
    {
        $contextStr = collect(static::get($e))
            ->tap(function (Collection $context) use ($e, &$exceptionLine, &$markedExceptionLine, &$maxLineLen) {
                $exceptionLine = $e->getLine();
                $markedExceptionLine = sprintf('➤ %s', $exceptionLine);
                $maxLineLen = max(mb_strlen(array_key_last($context->toArray())), mb_strlen($markedExceptionLine));
            })
            ->reduces(function ($carry, $code, $line) use ($maxLineLen, $markedExceptionLine, $exceptionLine) {
                $line === $exceptionLine and $line = $markedExceptionLine;
                $line = sprintf("%{$maxLineLen}s", $line);

                return "$carry    $line    $code".PHP_EOL;
            }, '');

        return sprintf($wrapSkeleton, $contextStr);
    }

    /**
     * Get the exception code context for the given exception.
     *
     * @return array
     */
    public static function get(Throwable $e)
    {
        return static::getEvalContext($e) ?? static::getFileContext($e);
    }

    /**
     * Get the exception code context when eval() failed.
     *
     * @return array|null
     */
    protected static function getEvalContext(Throwable $e)
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
    protected static function getFileContext(Throwable $e)
    {
        return collect(explode("\n", file_get_contents($e->getFile())))
            ->slice($e->getLine() - 10, 20)
            ->mapWithKeys(function ($value, $key) {
                return [$key + 1 => $value];
            })
            ->all();
    }
}
