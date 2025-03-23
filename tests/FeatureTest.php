<?php

/** @noinspection AnonymousFunctionStaticInspection */
/** @noinspection NullPointerExceptionInspection */
/** @noinspection PhpInternalEntityUsedInspection */
/** @noinspection PhpUnhandledExceptionInspection */
/** @noinspection PhpVoidFunctionResultUsedInspection */
/** @noinspection StaticClosureCanBeUsedInspection */

declare(strict_types=1);

/**
 * Copyright (c) 2021-2025 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-exception-notify
 */

use Illuminate\Http\UploadedFile;

it('can proactive report exception', function (): void {
    $jpgFile = UploadedFile::fake()->image('jpg.jpg');
    $pngFile = UploadedFile::fake()->image('png.png');
    $this
        ->post('proactive-report-exception?foo=bar', [
            'bar' => 'baz',
            'password' => 'password',
            'image' => new UploadedFile(
                path: $jpgFile->path(),
                originalName: $jpgFile->getBasename(),
                mimeType: $jpgFile->getMimeType(),
                error: null,
                test: true
            ),
            'images_list' => [
                new UploadedFile(
                    path: $jpgFile->path(),
                    originalName: $jpgFile->getBasename(),
                    mimeType: $jpgFile->getMimeType(),
                    error: \UPLOAD_ERR_INI_SIZE,
                    test: true
                ),
                new UploadedFile(
                    path: $pngFile->path(),
                    originalName: $pngFile->getBasename(),
                    mimeType: $pngFile->getMimeType(),
                    error: \UPLOAD_ERR_PARTIAL,
                    test: true
                ),
            ],
            'images_map' => [
                'jpg' => new UploadedFile(
                    path: $jpgFile->path(),
                    originalName: $jpgFile->getBasename(),
                    mimeType: $jpgFile->getMimeType(),
                    error: \UPLOAD_ERR_CANT_WRITE,
                    test: true
                ),
                'png' => new UploadedFile(
                    path: $pngFile->path(),
                    originalName: $pngFile->getBasename(),
                    mimeType: $pngFile->getMimeType(),
                    error: \UPLOAD_ERR_EXTENSION,
                    test: true
                ),
            ],
        ])
        ->assertOk();
})->group(__DIR__, __FILE__);

it('can automatic report exception', function (): void {
    $this
        ->post('automatic-report-exception?foo=bar', [
            'bar' => 'baz',
            'password' => 'password',
            // 'file' => new UploadedFile(__FILE__, basename(__FILE__)),
        ])
        ->assertServerError();
})->group(__DIR__, __FILE__);
