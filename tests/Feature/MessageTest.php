<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\Painting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class MessageTest extends TestCase
{
    use RefreshDatabase;

    // -------------------------------------------------------------------------
    // Helpers
    // -------------------------------------------------------------------------

    private function createPainting(User $seller): Painting
    {
        $category = Category::factory()->create();
        $title    = fake()->sentence(3);

        return Painting::create([
            'user_id'      => $seller->id,
            'is_draft'     => false,
            'title'        => $title,
            'slug'         => Str::slug($title . '-' . uniqid()),
            'description'  => fake()->paragraph(),
            'price'        => 100.00,
            'material'     => 'Oil on canvas',
            'year_created' => '2020',
            'dimensions'   => '30x40 cm',
            'framed'       => false,
            'orientation'  => 'portrait',
            'category_id'  => $category->id,
            'availability' => 'for_sale',
        ]);
    }

    private function createConversation(User $buyer, User $seller, Painting $painting): Conversation
    {
        return Conversation::create([
            'painting_id' => $painting->id,
            'buyer_id'    => $buyer->id,
            'seller_id'   => $seller->id,
        ]);
    }

    // -------------------------------------------------------------------------
    // index
    // -------------------------------------------------------------------------

    public function test_index_returns_200_for_authenticated_user(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('messages.index'))
            ->assertStatus(200);
    }

    public function test_index_lists_only_own_conversations(): void
    {
        $buyer  = User::factory()->create();
        $seller = User::factory()->create();
        $other  = User::factory()->create();

        $painting      = $this->createPainting($seller);
        $otherPainting = $this->createPainting($other);

        $ownConversation   = $this->createConversation($buyer, $seller, $painting);
        $otherConversation = $this->createConversation($other, $seller, $otherPainting);

        $response = $this->actingAs($buyer)
            ->get(route('messages.index'));

        $response->assertStatus(200);

        $conversations = $response->viewData('conversations');
        $ids = $conversations->pluck('id')->all();

        $this->assertContains($ownConversation->id, $ids);
        $this->assertNotContains($otherConversation->id, $ids);
    }

    public function test_index_loads_selected_conversation_when_query_param_present(): void
    {
        $buyer  = User::factory()->create();
        $seller = User::factory()->create();

        $painting      = $this->createPainting($seller);
        $conversation  = $this->createConversation($buyer, $seller, $painting);

        $response = $this->actingAs($buyer)
            ->get(route('messages.index', ['conversation' => $conversation->id]));

        $response->assertStatus(200);

        $selected = $response->viewData('selectedConversation');
        $this->assertNotNull($selected);
        $this->assertEquals($conversation->id, $selected->id);
    }

    public function test_index_returns_null_selected_conversation_when_no_query_param(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->get(route('messages.index'));

        $response->assertStatus(200);
        $this->assertNull($response->viewData('selectedConversation'));
    }

    // -------------------------------------------------------------------------
    // show
    // -------------------------------------------------------------------------

    public function test_show_returns_200_for_buyer(): void
    {
        $buyer  = User::factory()->create();
        $seller = User::factory()->create();

        $painting     = $this->createPainting($seller);
        $conversation = $this->createConversation($buyer, $seller, $painting);

        $response = $this->actingAs($buyer)
            ->get(route('member.messages', $buyer->id));

        $response->assertStatus(200);
    }

    public function test_show_returns_403_for_non_participant(): void
    {
        $buyer      = User::factory()->create();
        $seller     = User::factory()->create();
        $outsider   = User::factory()->create();

        $painting     = $this->createPainting($seller);
        $conversation = $this->createConversation($buyer, $seller, $painting);

        $response = $this->actingAs($outsider)
            ->get(route('messages.index', ['conversation' => $conversation->id]));

        $response->assertStatus(404);
    }

    // -------------------------------------------------------------------------
    // store
    // -------------------------------------------------------------------------

    public function test_store_persists_message_and_redirects(): void
    {
        $buyer  = User::factory()->create();
        $seller = User::factory()->create();

        $painting     = $this->createPainting($seller);
        $conversation = $this->createConversation($buyer, $seller, $painting);

        $response = $this->actingAs($buyer)
            ->post(route('messages.store'), [
                'conversation_id' => $conversation->id,
                'content'         => 'Hello there!',
            ]);

        $response->assertRedirect(route('messages.index', ['conversation' => $conversation->id]));

        $this->assertDatabaseHas('messages', [
            'conversation_id' => $conversation->id,
            'sender_id'       => $buyer->id,
            'content'         => 'Hello there!',
        ]);
    }

    public function test_store_by_non_participant_returns_403(): void
    {
        $buyer    = User::factory()->create();
        $seller   = User::factory()->create();
        $outsider = User::factory()->create();

        $painting     = $this->createPainting($seller);
        $conversation = $this->createConversation($buyer, $seller, $painting);

        $response = $this->actingAs($outsider)
            ->post(route('messages.store'), [
                'conversation_id' => $conversation->id,
                'content'         => 'Trying to intrude',
            ]);

        $response->assertStatus(403);
    }

    public function test_store_validation_fails_without_content(): void
    {
        $buyer  = User::factory()->create();
        $seller = User::factory()->create();

        $painting     = $this->createPainting($seller);
        $conversation = $this->createConversation($buyer, $seller, $painting);

        $response = $this->actingAs($buyer)
            ->post(route('messages.store'), [
                'conversation_id' => $conversation->id,
                'content'         => '',
            ]);

        $response->assertSessionHasErrors(['content']);
    }

    public function test_store_validation_fails_when_content_exceeds_max_length(): void
    {
        $buyer  = User::factory()->create();
        $seller = User::factory()->create();

        $painting     = $this->createPainting($seller);
        $conversation = $this->createConversation($buyer, $seller, $painting);

        $response = $this->actingAs($buyer)
            ->post(route('messages.store'), [
                'conversation_id' => $conversation->id,
                'content'         => str_repeat('a', 2001),
            ]);

        $response->assertSessionHasErrors(['content']);
    }

    public function test_store_validation_fails_without_conversation_id(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->post(route('messages.store'), [
                'content' => 'Hello',
            ]);

        $response->assertSessionHasErrors(['conversation_id']);
    }

    // -------------------------------------------------------------------------
    // ask
    // -------------------------------------------------------------------------

    public function test_ask_creates_new_conversation_and_redirects(): void
    {
        $buyer  = User::factory()->create();
        $seller = User::factory()->create();

        $painting = $this->createPainting($seller);

        $response = $this->actingAs($buyer)
            ->post(route('messages.ask', $painting->id));

        $response->assertRedirect();

        $this->assertDatabaseHas('conversations', [
            'painting_id' => $painting->id,
            'buyer_id'    => $buyer->id,
            'seller_id'   => $seller->id,
        ]);
    }

    public function test_ask_reuses_existing_conversation(): void
    {
        $buyer  = User::factory()->create();
        $seller = User::factory()->create();

        $painting     = $this->createPainting($seller);
        $conversation = $this->createConversation($buyer, $seller, $painting);

        $this->actingAs($buyer)
            ->post(route('messages.ask', $painting->id));

        $this->assertDatabaseCount('conversations', 1);
    }

    public function test_ask_self_redirects_back_with_error(): void
    {
        $artist = User::factory()->create();

        $painting = $this->createPainting($artist);

        $response = $this->actingAs($artist)
            ->post(route('messages.ask', $painting->id));

        $response->assertRedirect();
        $response->assertSessionHas('error', 'You cannot message yourself.');
    }
}
