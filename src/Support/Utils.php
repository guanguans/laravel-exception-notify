<?php

declare(strict_types=1);

/**
 * Copyright (c) 2021-2026 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-exception-notify
 */

namespace Guanguans\LaravelExceptionNotify\Support;

use Carbon\CarbonInterval;
use Guanguans\LaravelExceptionNotify\Template;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class Utils
{
    /**
     * @param array<string, mixed> $configuration
     * @param null|list<string> $except
     *
     * @throws \ReflectionException
     */
    public static function applyConfigurationToObject(object $object, array $configuration, ?array $except = null): object
    {
        return collect($configuration)
            ->except(
                $except ?? collect((new \ReflectionObject($object))->getConstructor()?->getParameters())
                    ->map(static fn (\ReflectionParameter $reflectionParameter): string => $reflectionParameter->getName())
                    ->push(
                        '__channel',
                        '__abstract',
                        '__class',
                        '__name',
                        '_abstract',
                        '_class',
                        '_name',
                    )
                    ->all()
            )
            ->each(static function (mixed $value, string $key) use ($object): void {
                $hasApplied = false;

                // Apply configuration to object by method
                foreach (
                    [
                        static fn (string $key): string => $key,
                        static fn (string $key): string => Str::camel($key),
                        static fn (string $key): string => 'set'.Str::studly($key),
                        static fn (string $key): string => 'on'.Str::studly($key),
                    ] as $caster
                ) {
                    if (method_exists($object, $method = $caster($key)) && \is_callable([$object, $method])) {
                        $numberOfParameters = (new \ReflectionMethod($object, $method))->getNumberOfParameters();

                        if (0 === $numberOfParameters) {
                            continue;
                        }

                        1 === $numberOfParameters ? $object->{$method}($value) : app()->call([$object, $method], $value);
                        $hasApplied = true;

                        break;
                    }
                }

                if ($hasApplied) {
                    return;
                }

                // Apply configuration to object by property
                foreach (
                    [
                        static fn (string $key): string => $key,
                        static fn (string $key): string => Str::camel($key),
                    ] as $caster
                ) {
                    if (
                        property_exists($object, $property = $caster($key))
                        && with(new \ReflectionProperty($object, $property))->isPublic()
                    ) {
                        $object->{$key} = $value;

                        return;
                    }
                }
            })
            ->pipe(static function (Collection $configuration) use ($object): object {
                $extender = $configuration->get('extender');

                if (!$extender) {
                    return $object;
                }

                if (!\is_callable($extender)) {
                    $extender = make($extender);
                    \assert(\is_callable($extender));
                }

                return $extender($object);
            });
    }

    /**
     * @param array<string, mixed> $configuration
     *
     * @return array<string, mixed>
     */
    public static function applyContentToConfiguration(array $configuration, string $content): array
    {
        array_walk_recursive($configuration, static function (mixed &$value) use ($content): void {
            \is_string($value) and $value = str_replace(
                [Template::TITLE, Template::CONTENT],
                [config('exception-notify.title'), $content],
                $value
            );
        });

        return $configuration;
    }

    /**
     * @see https://stackoverflow.com/a/23888858/1580028
     */
    public static function humanBytes(int $bytes, int $decimals = 2): string
    {
        $size = ['B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
        $factor = (int) floor((\strlen((string) $bytes) - 1) / 3);

        if (0 === $factor) {
            $decimals = 0;
        }

        return \sprintf("%.{$decimals}f %s", $bytes / (1024 ** $factor), $size[$factor]);
    }

    /**
     * @param array<string, mixed> $syntax
     *
     * @throws \Exception
     */
    public static function humanMilliseconds(float|int $milliseconds, array $syntax = []): string
    {
        \assert(0 < $milliseconds, 'The milliseconds must be greater than 0.');

        return CarbonInterval::microseconds($milliseconds * 1000)
            ->cascade()
            ->forHumans($syntax + [
                'join' => ', ',
                'locale' => 'en',
                // 'locale' => 'zh_CN',
                'minimumUnit' => 'us',
                'short' => true,
            ]);
    }

    public static function isSyncJobConnection(): bool
    {
        return 'sync' === self::jobConnection();
    }

    public static function jobConnection(): string
    {
        return config('exception-notify.job.connection') ?? config('queue.default');
    }

    public static function jobQueue(): ?string
    {
        return config('exception-notify.job.queue') ?? config(\sprintf('queue.connections.%s.queue', self::jobConnection()));
    }
}
