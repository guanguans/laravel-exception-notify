<?php

declare(strict_types=1);

/**
 * Copyright (c) 2021-2025 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-exception-notify
 */

namespace Guanguans\LaravelExceptionNotify\Support;

use Illuminate\Support\Collection;

/**
 * @see https://github.com/laravel/telescope/blob/4.x/src/ExceptionContext.php
 */
class ExceptionContext
{
    public static function getMarked(\Throwable $throwable, string $mark = '➤', int $number = 5): array
    {
        return collect(self::get($throwable, $number))
            ->tap(static function (Collection $collection) use (
                &$exceptionLine,
                $throwable,
                &$markedExceptionLine,
                $mark,
                &$maxLineLen
            ): void {
                $exceptionLine = $throwable->getLine();
                $markedExceptionLine = "$mark $exceptionLine";
                $maxLineLen = max(
                    mb_strlen((string) array_key_last($collection->toArray())),
                    mb_strlen($markedExceptionLine)
                );
            })
            ->mapWithKeys(static function (string $code, int $line) use (
                $exceptionLine,
                $markedExceptionLine,
                $maxLineLen
            ): array {
                if ($line === $exceptionLine) {
                    $line = $markedExceptionLine;
                }

                return [\sprintf("%{$maxLineLen}s", $line) => $code];
            })
            ->all();
    }

    public static function get(\Throwable $throwable, int $number = 5): array
    {
        return self::getEval($throwable) ?? self::getFile($throwable, $number);
    }

    /**
     * @return null|array<int, string>
     */
    private static function getEval(\Throwable $throwable): ?array
    {
        return str($throwable->getFile())->contains($row = "eval()'d code") ? [$throwable->getLine() => $row] : null;
    }

    private static function getFile(\Throwable $throwable, int $number = 5): array
    {
        return collect(file($throwable->getFile()))
            ->slice($throwable->getLine() - $number, 2 * $number - 1)
            ->mapWithKeys(static fn (string $code, int $line): array => [$line + 1 => $code])
            ->all();
    }
}
