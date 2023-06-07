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

use Guanguans\LaravelExceptionNotify\Contracts\Collector as CollectorContract;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

abstract class Collector implements CollectorContract
{
    /**
     * @var callable|null
     */
    protected $pipe;

    public function __construct(callable $pipe = null)
    {
        $this->pipe = $pipe;
    }

    public function getName(): string
    {
        return Str::ucwords(Str::snake(Str::beforeLast(class_basename($this), 'Collector'), ' '));
    }

    protected function applyPipeCollect()
    {
        return collect($this->collect())
            ->when($this->pipe, function (Collection $collection) {
                return collect($collection->pipe($this->pipe));
            })
            ->filter(static function ($item) {
                return ! blank($item);
            })
            ->all();
    }

    public function __toString()
    {
        return (string) json_encode(
            $this->toArray(),
            JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT
        );
    }

    public function toArray()
    {
        return $this->applyPipeCollect();
    }
}
