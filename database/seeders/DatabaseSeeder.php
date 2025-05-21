<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Painting;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\UserType;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UserTypeSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(UserSeeder::class);
        $this->call(PaintingSeeder::class);

//        Painting::factory(50)->make()->each(function ($painting) use ($categories, $users) {
//            $painting->category_id = $categories->random()->id;
//            $painting->user_id = $users->random()->id;
//            $painting->save();
//        });

    }
}
