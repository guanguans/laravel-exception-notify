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

namespace Workbench\Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Workbench\App\Models\Country;
use Workbench\App\Models\Post;
use Workbench\App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // UserFactory::new()->times(10)->create();
        // UserFactory::new()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        Model::unguard();

        Country::query()->create([
            'name' => 'China',
            'created_at' => new Carbon('2024-01-01 00:00:01'),
            'updated_at' => new Carbon('2024-01-01 00:00:01'),
        ]);
        Country::query()->create([
            'name' => 'USA',
            'created_at' => new Carbon('2024-01-01 00:00:02'),
            'updated_at' => new Carbon('2024-01-01 00:00:02'),
        ]);
        Country::query()->create([
            'name' => 'Japan',
            'created_at' => new Carbon('2024-01-01 00:00:03'),
            'updated_at' => new Carbon('2024-01-01 00:00:03'),
        ]);
        Country::query()->create([
            'name' => 'Korea',
            'created_at' => new Carbon('2024-01-01 00:00:04'),
            'updated_at' => new Carbon('2024-01-01 00:00:04'),
        ]);
        Country::query()->create([
            'name' => 'UK',
            'created_at' => new Carbon('2024-01-01 00:00:05'),
            'updated_at' => new Carbon('2024-01-01 00:00:05'),
        ]);
        Country::query()->create([
            'name' => 'France',
            'created_at' => new Carbon('2024-01-01 00:00:06'),
            'updated_at' => new Carbon('2024-01-01 00:00:06'),
        ]);
        Country::query()->create([
            'name' => 'Germany',
            'created_at' => new Carbon('2024-01-01 00:00:07'),
            'updated_at' => new Carbon('2024-01-01 00:00:07'),
        ]);

        User::query()->create([
            'name' => 'John',
            'country_id' => 1,
            'created_at' => new Carbon('2024-01-01 00:00:01'),
            'updated_at' => new Carbon('2024-01-01 00:00:01'),
        ]);
        User::query()->create([
            'name' => 'Tom',
            'country_id' => 2,
            'created_at' => new Carbon('2024-01-01 00:00:02'),
            'updated_at' => new Carbon('2024-01-01 00:00:02'),
        ]);
        User::query()->create([
            'name' => 'Jerry',
            'country_id' => 3,
            'created_at' => new Carbon('2024-01-01 00:00:03'),
            'updated_at' => new Carbon('2024-01-01 00:00:03'),
        ]);
        User::query()->create([
            'name' => 'Jack',
            'country_id' => 4,
            'created_at' => new Carbon('2024-01-01 00:00:04'),
            'updated_at' => new Carbon('2024-01-01 00:00:04'),
        ]);
        User::query()->create([
            'name' => 'Rose',
            'country_id' => 5,
            'created_at' => new Carbon('2024-01-01 00:00:05'),
            'updated_at' => new Carbon('2024-01-01 00:00:05'),
        ]);
        User::query()->create([
            'name' => 'Lucy',
            'country_id' => 6,
            'created_at' => new Carbon('2024-01-01 00:00:06'),
            'updated_at' => new Carbon('2024-01-01 00:00:06'),
        ]);
        User::query()->create([
            'name' => 'Lily',
            'country_id' => 7,
            'created_at' => new Carbon('2024-01-01 00:00:07'),
            'updated_at' => new Carbon('2024-01-01 00:00:07'),
        ]);

        Post::query()->create([
            'title' => 'PHP is the best language!',
            'user_id' => 1,
            'created_at' => new Carbon('2024-01-01 00:00:01'),
            'updated_at' => new Carbon('2024-01-01 00:00:01'),
        ]);
        Post::query()->create([
            'title' => 'JAVA is the best language!',
            'user_id' => 1,
            'created_at' => new Carbon('2024-01-01 00:00:02'),
            'updated_at' => new Carbon('2024-01-01 00:00:02'),
        ]);
        Post::query()->create([
            'title' => 'Python is the best language!',
            'user_id' => 1,
            'created_at' => new Carbon('2024-01-01 00:00:03'),
            'updated_at' => new Carbon('2024-01-01 00:00:03'),
        ]);
        Post::query()->create([
            'title' => 'Go is the best language!',
            'user_id' => 2,
            'created_at' => new Carbon('2024-01-01 00:00:04'),
            'updated_at' => new Carbon('2024-01-01 00:00:04'),
        ]);
        Post::query()->create([
            'title' => 'JavaScript is the best language!',
            'user_id' => 2,
            'created_at' => new Carbon('2024-01-01 00:00:05'),
            'updated_at' => new Carbon('2024-01-01 00:00:05'),
        ]);
        Post::query()->create([
            'title' => 'Ruby is the best language!',
            'user_id' => 2,
            'created_at' => new Carbon('2024-01-01 00:00:06'),
            'updated_at' => new Carbon('2024-01-01 00:00:06'),
        ]);
        Post::query()->create([
            'title' => 'C is the best language!',
            'user_id' => 3,
            'created_at' => new Carbon('2024-01-01 00:00:07'),
            'updated_at' => new Carbon('2024-01-01 00:00:07'),
        ]);

        Model::reguard();
    }
}
