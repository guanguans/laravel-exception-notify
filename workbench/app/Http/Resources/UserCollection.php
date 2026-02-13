<?php

/** @noinspection AnonymousFunctionStaticInspection */
/** @noinspection NullPointerExceptionInspection */
/** @noinspection PhpPossiblePolymorphicInvocationInspection */
/** @noinspection PhpUndefinedClassInspection */
/** @noinspection PhpUnhandledExceptionInspection */
/** @noinspection PhpVoidFunctionResultUsedInspection */
/** @noinspection SenselessProxyMethodInspection */
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

use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 * @see \Workbench\App\Models\User
 */
class UserCollection extends ResourceCollection
{
    /**
     * @noinspection PhpMissingReturnTypeInspection
     * @noinspection MissingReturnTypeInspection
     */
    public function toArray(mixed $request)
    {
        // return [
        //     'data' => $this->collection,
        // ];

        return parent::toArray($request);
    }
}
