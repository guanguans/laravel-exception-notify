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
     * @template TObject of object
     *
     * @param TObject $object
     * @param array<string, mixed> $configuration
     *
     * @throws \ReflectionException
     *
     * @return TObject
     */
    public static function applyConfigurationToObject(object $object, array $configuration): object
    {
        return collect($configuration)
            ->each(static function (mixed $value, string $key) use ($object): void {
                // Apply configuration to object by method
                foreach ([$key, Str::camel($key), 'set'.Str::studly($key), 'on'.Str::studly($key)] as $method) {
                    if (
                        method_exists($object, $method)
                        && ($reflectionMethod = new \ReflectionMethod($object, $method))->isPublic()
                        && 0 < ($numberOfParameters = $reflectionMethod->getNumberOfParameters())
                    ) {
                        1 === $numberOfParameters ? $object->{$method}($value) : app()->call([$object, $method], $value);

                        return;
                    }
                }

                // Apply configuration to object by property
                foreach ([$key, Str::camel($key)] as $property) {
                    if (
                        property_exists($object, $property)
                        && (new \ReflectionProperty($object, $property))->isPublic()
                    ) {
                        $object->{$property} = $value;

                        return;
                    }
                }
            })
            ->pipe(static function (Collection $configuration) use ($object): object {
                /** @var null|array<string, mixed>|(callable(object): object)|string $extender */
                $extender = $configuration->get('extender');

                if (empty($extender)) {
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
     * @param array<string, mixed> $syntax
     *
     * @throws \Exception
     */
    public static function humanMilliseconds(float|int $milliseconds, array $syntax = []): string
    {
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

    public static function jobQueue(): ?string
    {
        return config('exception-notify.job.queue', config(\sprintf('queue.connections.%s.queue', self::jobConnection())));
    }

    public static function jobConnection(): string
    {
        return config('exception-notify.job.connection', config('queue.default'));
    }
}
