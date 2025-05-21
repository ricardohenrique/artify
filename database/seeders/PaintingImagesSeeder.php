<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Painting;
use App\Models\PaintingImage;

class PaintingImagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $defaultImages = collect(range(1, 10))->map(function ($i) {
            return 'default-img/default-' . str_pad($i, 2, '0', STR_PAD_LEFT) . '.webp';
        });

        Painting::all()->each(function ($painting) use ($defaultImages) {
            $imagesToAttach = $defaultImages->shuffle()->take(rand(3, 5));

            foreach ($imagesToAttach as $imagePath) {
                PaintingImage::create([
                    'painting_id' => $painting->id,
                    'path' => $imagePath,
                ]);
            }
        });
    }
}
