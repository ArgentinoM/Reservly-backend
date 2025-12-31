<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            RolSeeder::class,
            UsersSeeder::class,
            CategoriesSeeder::class,
            ServicesSeeder::class,
            ReviewsTableSeeder::class,
            RatingSeeder::class
        ]);
    }
}
