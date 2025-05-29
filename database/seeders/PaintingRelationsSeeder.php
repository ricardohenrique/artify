<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Painting;
use App\Models\Color;
use App\Models\Tag;

class PaintingRelationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $colorIds = Color::pluck('id')->toArray();
        $tagIds = Tag::pluck('id')->toArray();

        Painting::all()->each(function ($painting) use ($colorIds, $tagIds) {
            $painting->colors()->sync(fake()->randomElements($colorIds, rand(2, 3)));
            $painting->tags()->sync(fake()->randomElements($tagIds, rand(3, 5)));
        });
    }
}
