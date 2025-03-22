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

namespace Guanguans\LaravelExceptionNotify;

use Guanguans\LaravelExceptionNotify\Contracts\RateLimiterContract;
use Guanguans\LaravelExceptionNotify\Exceptions\InvalidConfigurationException;
use Guanguans\LaravelExceptionNotify\Support\Utils;
use Illuminate\Cache\RateLimiter as IlluminateRateLimiter;
use Illuminate\Config\Repository;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use function Guanguans\LaravelExceptionNotify\Support\make;

class RateLimiter implements RateLimiterContract
{
    private Repository $configRepository;
    private IlluminateRateLimiter $illuminateRateLimiter;

    /**
     * @throws \Throwable
     */
    public function __construct(Repository $configRepository)
    {
        $this->setConfigRepository($configRepository);
        $this->setIlluminateRateLimiter($this->makeIlluminateRateLimiter($configRepository));
    }

    /**
     * @throws \Throwable
     */
    public function setConfigRepository(Repository $configRepository): self
    {
        $validator = Validator::make($configRepository->all(), $this->rules());

        throw_if($validator->fails(), InvalidConfigurationException::fromValidator($validator));

        $this->configRepository = $configRepository;

        return $this;
    }

    public function setIlluminateRateLimiter(IlluminateRateLimiter $illuminateRateLimiter): self
    {
        $this->illuminateRateLimiter = Utils::applyConfigurationToObject($illuminateRateLimiter, $this->configRepository->all());

        return $this;
    }

    public function attempt(\Throwable $throwable): bool
    {
        return $this->illuminateRateLimiter->attempt(
            $this->fingerprintFor($throwable),
            $this->configRepository->get('max_attempts'),
            static fn (): bool => true,
            $this->configRepository->get('decay_seconds'),
        );
    }

    private function rules(): array
    {
        return [
            'class' => 'string',
            'cache_store' => 'nullable|string',
            'key_prefix' => 'required|string',
            'max_attempts' => 'integer|min:1',
            'decay_seconds' => 'integer|min:1',
        ];
    }

    private function makeIlluminateRateLimiter(Repository $configRepository): IlluminateRateLimiter
    {
        return make($configRepository->all() + [
            'class' => IlluminateRateLimiter::class,
            'cache' => Cache::store($configRepository->get('cache_store')),
        ]);
    }

    /**
     * @see \Illuminate\Foundation\Exceptions\Handler::shouldntReport()
     * @see \Illuminate\Foundation\Exceptions\Handler::throttle()
     * @see \Illuminate\Foundation\Exceptions\Handler::throttleUsing()
     */
    private function fingerprintFor(\Throwable $throwable): string
    {
        return $this->configRepository->get('key_prefix').sha1(
            implode(':', [$throwable->getFile(), $throwable->getLine(), $throwable->getCode()])
        );
    }
}
