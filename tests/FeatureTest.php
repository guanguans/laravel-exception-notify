<?php

/** @noinspection AnonymousFunctionStaticInspection */
/** @noinspection NullPointerExceptionInspection */
/** @noinspection PhpFieldAssignmentTypeMismatchInspection */
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

use Illuminate\Http\UploadedFile;

it('can proactive report exception', function (): void {
    $this
        ->post('proactive-report-exception?foo=bar', [
            'bar' => 'baz',
            'password' => 'password',
        ])
        ->assertOk();
})->group(__DIR__, __FILE__);

it('can automatic report exception', function (): void {
    $jpgFile = UploadedFile::fake()->image($jpgName = 'image.jpg');
    $pngFile = UploadedFile::fake()->image($pngName = 'image.png');

    $this
        ->post('auto-report-exception?foo=bar', [
            'bar' => 'baz',
            'password' => 'password',
            'image' => new UploadedFile($jpgFile->path(), $jpgName, $jpgFile->getMimeType(), null, true),
            'images_list' => [
                new UploadedFile($jpgFile->path(), $jpgName, $jpgFile->getMimeType(), \UPLOAD_ERR_INI_SIZE, true),
                new UploadedFile($pngFile->path(), $pngName, $pngFile->getMimeType(), \UPLOAD_ERR_PARTIAL, true),
            ],
            'images_map' => [
                'jpg' => new UploadedFile($jpgFile->path(), $jpgName, $jpgFile->getMimeType(), \UPLOAD_ERR_CANT_WRITE, true),
                'png' => new UploadedFile($pngFile->path(), $pngName, $pngFile->getMimeType(), \UPLOAD_ERR_EXTENSION, true),
            ],
        ])
        ->assertServerError();
})->group(__DIR__, __FILE__);
