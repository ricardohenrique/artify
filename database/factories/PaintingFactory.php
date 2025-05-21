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
            'image_path' => 'paintings/' . $this->faker->uuid() . '.jpg',
            'category_id' => Category::inRandomOrder()->value('id'),
            'is_available' => $this->faker->boolean(90),
        ];
    }
}
