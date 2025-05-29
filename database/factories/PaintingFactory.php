<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Category;

class PaintingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = $this->faker->sentence(3);

        return [
            'user_id' => User::inRandomOrder()->value('id'),
            'is_draft' => true,
            'title' => $title,
            'slug' => Str::slug($title . '-' . uniqid()),
            'description' => $this->faker->paragraph(),
            'price' => $this->faker->randomFloat(2, 50, 2000),
            'material' => $this->faker->randomElement(['Oil on canvas', 'Acrylic', 'Watercolor', 'Mixed media']),
            'year_created' => $this->faker->year(),
            'dimensions' => $this->faker->randomElement(['30x40 cm', '50x70 cm', '60x90 cm']),
            'framed' => $this->faker->boolean(),
            'orientation' => $this->faker->randomElement(['portrait', 'landscape', 'square']),
            'category_id' => Category::inRandomOrder()->value('id'),
            'availability' => $this->faker->randomElement(['for_sale', 'sold', 'reserved']),
        ];
    }
}
