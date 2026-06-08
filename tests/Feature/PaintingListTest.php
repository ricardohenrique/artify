<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Painting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PaintingListTest extends TestCase
{
    use RefreshDatabase;

    private User $artist;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artist = User::factory()->create();
    }

    public function test_explore_returns_200(): void
    {
        $category = Category::factory()->create();
        Painting::factory()->create([
            'user_id' => $this->artist->id,
            'category_id' => $category->id,
            'is_draft' => false,
        ]);

        $response = $this->get(route('paintings.explore'));

        $response->assertStatus(200);
    }

    public function test_explore_with_valid_category_slug_returns_only_that_categorys_paintings(): void
    {
        $targetCategory = Category::factory()->create(['name' => 'Oil', 'slug' => 'oil']);
        $otherCategory = Category::factory()->create(['name' => 'Watercolor', 'slug' => 'watercolor']);

        $targetPainting = Painting::factory()->create([
            'user_id' => $this->artist->id,
            'category_id' => $targetCategory->id,
            'is_draft' => false,
            'title' => 'Target Painting',
        ]);

        Painting::factory()->create([
            'user_id' => $this->artist->id,
            'category_id' => $otherCategory->id,
            'is_draft' => false,
            'title' => 'Other Painting',
        ]);

        $response = $this->get(route('paintings.list', $targetCategory->slug));

        $response->assertStatus(200);

        $paintings = $response->viewData('paintings');
        $this->assertCount(1, $paintings);
        $this->assertEquals($targetPainting->id, $paintings->first()->id);
    }

    public function test_explore_with_unknown_slug_returns_404(): void
    {
        $response = $this->get(route('paintings.list', 'non-existent-category'));

        $response->assertStatus(404);
    }

    public function test_explore_with_price_filter_returns_paintings_within_range(): void
    {
        $category = Category::factory()->create();

        $cheapPainting = Painting::factory()->create([
            'user_id' => $this->artist->id,
            'category_id' => $category->id,
            'is_draft' => false,
            'price' => 50.00,
        ]);

        Painting::factory()->create([
            'user_id' => $this->artist->id,
            'category_id' => $category->id,
            'is_draft' => false,
            'price' => 500.00,
        ]);

        $response = $this->get(route('paintings.explore', ['price' => 'between-10-100']));

        $response->assertStatus(200);

        $paintings = $response->viewData('paintings');
        $this->assertCount(1, $paintings);
        $this->assertEquals($cheapPainting->id, $paintings->first()->id);
    }

    public function test_explore_with_sort_liked_returns_200(): void
    {
        $category = Category::factory()->create();
        Painting::factory()->create([
            'user_id' => $this->artist->id,
            'category_id' => $category->id,
            'is_draft' => false,
        ]);

        $response = $this->get(route('paintings.explore', ['sort' => 'liked']));

        $response->assertStatus(200);
    }

    public function test_search_with_matching_term_returns_200_with_matching_paintings(): void
    {
        $category = Category::factory()->create();

        Painting::factory()->create([
            'user_id' => $this->artist->id,
            'category_id' => $category->id,
            'is_draft' => false,
            'title' => 'Beautiful Sunset',
            'description' => 'A lovely painting',
        ]);

        Painting::factory()->create([
            'user_id' => $this->artist->id,
            'category_id' => $category->id,
            'is_draft' => false,
            'title' => 'Abstract Blue',
            'description' => 'A blue abstract piece',
        ]);

        $response = $this->get(route('paintings.search', ['q' => 'Sunset']));

        $response->assertStatus(200);

        $paintings = $response->viewData('paintings');
        $this->assertCount(1, $paintings);
        $this->assertStringContainsString('Sunset', $paintings->first()->title);
    }

    public function test_search_with_non_matching_term_returns_200_with_no_paintings(): void
    {
        $category = Category::factory()->create();
        Painting::factory()->create([
            'user_id' => $this->artist->id,
            'category_id' => $category->id,
            'is_draft' => false,
            'title' => 'Beautiful Sunset',
            'description' => 'A lovely painting',
        ]);

        $response = $this->get(route('paintings.search', ['q' => 'xyznonexistentterm']));

        $response->assertStatus(200);

        $paintings = $response->viewData('paintings');
        $this->assertCount(0, $paintings);
    }
}
