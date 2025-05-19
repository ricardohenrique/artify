<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Painting;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users      = User::factory(10)->create();
        $categories = Category::factory(10)->create();

        Painting::factory(50)->make()->each(function ($painting) use ($categories, $users) {
            $painting->category_id = $categories->random()->id;
            $painting->user_id = $users->random()->id;
            $painting->save();
        });
    }
}
