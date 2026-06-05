<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MemberUpdateTest extends TestCase
{
    use RefreshDatabase;

    public function test_valid_gender_and_date_of_birth_are_persisted(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->put("/member/{$user->id}", [
                'name'          => $user->name,
                'gender'        => 'female',
                'date_of_birth' => '1990-05-15',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('member.settings', $user->id));

        $user->refresh();

        $this->assertSame('female', $user->gender);
        $this->assertSame('1990-05-15', $user->date_of_birth->format('Y-m-d'));
    }

    public function test_null_gender_and_null_date_of_birth_are_accepted(): void
    {
        $user = User::factory()->create([
            'gender'        => 'male',
            'date_of_birth' => '1985-03-20',
        ]);

        $response = $this
            ->actingAs($user)
            ->put("/member/{$user->id}", [
                'name'          => $user->name,
                'gender'        => null,
                'date_of_birth' => null,
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('member.settings', $user->id));

        $user->refresh();

        $this->assertNull($user->gender);
        $this->assertNull($user->date_of_birth);
    }

    public function test_invalid_gender_value_returns_validation_error(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->from(route('member.settings', $user->id))
            ->put("/member/{$user->id}", [
                'name'   => $user->name,
                'gender' => 'invalid_value',
            ]);

        $response->assertSessionHasErrors('gender');
    }

    public function test_future_date_of_birth_returns_validation_error(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->from(route('member.settings', $user->id))
            ->put("/member/{$user->id}", [
                'name'          => $user->name,
                'date_of_birth' => now()->addYear()->format('Y-m-d'),
            ]);

        $response->assertSessionHasErrors('date_of_birth');
    }
}
