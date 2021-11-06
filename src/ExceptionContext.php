<?php

/**
 * This file is part of the guanguans/laravel-exception-notify.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelExceptionNotify;

use Illuminate\Support\Str;
use Throwable;

/**
 * This is file is modified from the laravel/telescope.
 */
class ExceptionContext
{
    /**
     * Get the exception code context for the given exception.
     *
     * @return string
     */
    public static function getContextAsString(Throwable $exception)
    {
        $context = ExceptionContext::get($exception);

        $lastLineLen = strlen(array_key_last($context));

        $contextString = PHP_EOL.array_reduces($context, function ($carry, $code, $line) use ($lastLineLen) {
            $line = str_pad($line, $lastLineLen, ' ', STR_PAD_LEFT);

            return "$carry    $line    $code".PHP_EOL;
        }, '');

        return "($contextString)";
    }

    /**
     * Get the exception code context for the given exception.
     *
     * @return array
     */
    public static function get(Throwable $exception)
    {
        return static::getEvalContext($exception) ?? static::getFileContext($exception);
    }

    /**
     * Get the exception code context when eval() failed.
     *
     * @return array|null
     */
    protected static function getEvalContext(Throwable $exception)
    {
        if (Str::contains($exception->getFile(), "eval()'d code")) {
            return [
                $exception->getLine() => "eval()'d code",
            ];
        }
    }

    /**
     * Get the exception code context from a file.
     *
     * @return array
     */
    protected static function getFileContext(Throwable $exception)
    {
        return collect(explode("\n", file_get_contents($exception->getFile())))
            ->slice($exception->getLine() - 10, 20)
            ->mapWithKeys(function ($value, $key) {
                return [$key + 1 => $value];
            })->all();
    }
}
