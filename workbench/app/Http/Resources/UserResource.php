<?php

/** @noinspection AnonymousFunctionStaticInspection */
/** @noinspection NullPointerExceptionInspection */
/** @noinspection PhpPossiblePolymorphicInvocationInspection */
/** @noinspection PhpUndefinedClassInspection */
/** @noinspection PhpUnhandledExceptionInspection */
/** @noinspection PhpVoidFunctionResultUsedInspection */
/** @noinspection StaticClosureCanBeUsedInspection */
declare(strict_types=1);

/**
 * Copyright (c) 2021-2026 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-exception-notify
 */

namespace Workbench\App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \Workbench\App\Models\User
 */
class UserResource extends JsonResource
{
    /**
     * @noinspection PhpRedundantMethodOverrideInspection
     */
    public function toArray(mixed $request): array
    {
        // return [
        //     'id' => $this->id,
        //     'name' => $this->name,
        //     'country_id' => $this->country_id,
        //     'country' => $this->country,
        //     'posts' => $this->posts,
        //     'created_at' => $this->created_at,
        //     'updated_at' => $this->updated_at,
        // ];

        return parent::toArray($request);
    }
}
