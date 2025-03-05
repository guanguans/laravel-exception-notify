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

namespace Guanguans\LaravelExceptionNotify\Channels;

use Guanguans\LaravelExceptionNotify\Exceptions\InvalidArgumentException;
use Illuminate\Config\Repository;
use Illuminate\Support\Facades\Validator;

abstract class Channel implements \Guanguans\LaravelExceptionNotify\Contracts\Channel
{
    public function __construct(protected Repository $configRepository)
    {
        $validator = Validator::make(
            $this->configRepository->all(),
            $this->rules(),
            $this->messages(),
            $this->attributes()
        );

        if ($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first());
        }
    }

    protected function rules(): array
    {
        return [
            'driver' => 'required|string',
            'pipes' => 'array',
        ];
    }

    protected function messages(): array
    {
        return [];
    }

    protected function attributes(): array
    {
        return [];
    }
}
