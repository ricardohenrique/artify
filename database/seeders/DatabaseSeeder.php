<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UserTypeSeeder::class);
        $this->call(ColorSeeder::class);
        $this->call(TagSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(UserSeeder::class);
        $this->call(PaintingSeeder::class);
        $this->call(FavoriteSeeder::class);
        $this->call(FollowerSeeder::class);
        $this->call(PaintingImagesSeeder::class);
        $this->call(PaintingRelationsSeeder::class);
    }
}
