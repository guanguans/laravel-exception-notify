<?php

/** @noinspection PhpUnusedAliasInspection */

declare(strict_types=1);

/**
 * Copyright (c) 2021-2026 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-exception-notify
 */

use Guanguans\LaravelApiResponse\Middleware\SetJsonAcceptHeader;
use Guanguans\LaravelApiResponse\RenderUsings\ApiPathsRenderUsing;
use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group([
    'as' => 'api.',
    'namespace' => '\Workbench\App\Http\Controllers\Api',
    'prefix' => 'api',
    'middleware' => [
        SetJsonAcceptHeader::class,
    ],
], static function (Router $router): void {
    $router->any('exception', static function (): void {
        config('api-response.render_using', ApiPathsRenderUsing::make());

        throw new RuntimeException('This is a runtime exception.', Response::HTTP_BAD_GATEWAY);
    });
});
