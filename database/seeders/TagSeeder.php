<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tag;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = [
            'Modern', 'Classic', 'Bold', 'Soft', 'Dark',
            'Bright', 'Minimalist', 'Abstract', 'Detailed', 'Nature',
            'Urban', 'Portrait', 'Fantasy', 'Geometric', 'Calm',
            'Colorful', 'Texture', 'Monochrome', 'Symbolic', 'Emotional',
        ];

        foreach ($tags as $tag) {
            Tag::create(['name' => $tag]);
        }
    }
}
