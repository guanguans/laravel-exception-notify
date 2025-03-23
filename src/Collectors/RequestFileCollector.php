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

namespace Guanguans\LaravelExceptionNotify\Collectors;

use Guanguans\LaravelExceptionNotify\Support\Utils;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

class RequestFileCollector extends AbstractCollector
{
    public function __construct(private Request $request) {}

    /**
     * @noinspection CallableParameterUseCaseInTypeContextInspection
     *
     * ```json
     * {
     *     "name": "images.jpeg",
     *     "full_path": "images.jpeg",
     *     "type": "image/jpeg",
     *     "tmp_name": "/private/var/tmp/phpz7mx94",
     *     "error": 0,
     *     "size": 2075
     * }
     * ```
     */
    public function collect(): array
    {
        $files = $this->request->allFiles();

        array_walk_recursive($files, static function (UploadedFile &$uploadedFile): void {
            $uploadedFile = [
                'Name' => $uploadedFile->getClientOriginalName(),
                'Type' => $uploadedFile->getMimeType(),
                'Error' => $uploadedFile->getError(),
                'Size' => Utils::humanBytes($uploadedFile->getSize()),
            ];
        });

        return $files;
    }
}
