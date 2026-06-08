<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Category;
use App\Models\Painting;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Conversation>
 */
class ConversationFactory extends Factory
{
    public function definition(): array
    {
        $seller  = User::factory()->create();
        $buyer   = User::factory()->create();
        $category = Category::factory()->create();

        $title   = $this->faker->sentence(3);
        $painting = Painting::create([
            'user_id'      => $seller->id,
            'is_draft'     => false,
            'title'        => $title,
            'slug'         => Str::slug($title . '-' . uniqid()),
            'description'  => $this->faker->paragraph(),
            'price'        => $this->faker->randomFloat(2, 50, 2000),
            'material'     => 'Oil on canvas',
            'year_created' => $this->faker->year(),
            'dimensions'   => '30x40 cm',
            'framed'       => false,
            'orientation'  => 'portrait',
            'category_id'  => $category->id,
            'availability' => 'for_sale',
        ]);

        return [
            'painting_id' => $painting->id,
            'buyer_id'    => $buyer->id,
            'seller_id'   => $seller->id,
        ];
    }
}
