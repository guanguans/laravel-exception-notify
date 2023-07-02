<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-exception-notify.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelExceptionNotify\Collectors;

use Guanguans\LaravelExceptionNotify\Contracts\CollectorContract;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

abstract class Collector implements CollectorContract
{
    /** @var null|callable */
    protected $pipe;

    public function __construct(?callable $pipe = null)
    {
        $this->pipe = $pipe;
    }

    public function __toString()
    {
        return (string) json_encode(
            $this->toArray(),
            JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT
        );
    }

    public function name(): string
    {
        return Str::ucwords(Str::snake(Str::beforeLast(class_basename($this), 'Collector'), ' '));
    }

    public function toArray()
    {
        return $this->applyPipeCollect();
    }

    protected function applyPipeCollect()
    {
        return collect($this->collect())
            ->when($this->pipe, fn (Collection $collection) => collect($collection->pipe($this->pipe)))
            ->filter(static fn ($item) => ! blank($item))
            ->all();
    }
}
