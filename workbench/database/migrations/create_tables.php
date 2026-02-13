<?php

declare(strict_types=1);

/**
 * Copyright (c) 2021-2026 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-exception-notify
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('countries', static function (Blueprint $blueprint): void {
            $blueprint->increments('id');
            $blueprint->string('name');
            $blueprint->timestamps();
        });

        Schema::create('users', static function (Blueprint $blueprint): void {
            $blueprint->increments('id');
            $blueprint->string('name');
            $blueprint->unsignedInteger('country_id');
            $blueprint->timestamps();
        });

        Schema::create('posts', static function (Blueprint $blueprint): void {
            $blueprint->increments('id');
            $blueprint->string('title');
            $blueprint->unsignedInteger('user_id');
            $blueprint->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::dropAllTables();
        Schema::dropIfExists('countries');
        Schema::dropIfExists('users');
        Schema::dropIfExists('posts');
    }
};
