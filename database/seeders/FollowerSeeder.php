<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FollowerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        foreach ($users as $user) {
            // Choose 1–5 random users to follow (excluding self)
            $followers = User::where('id', '!=', $user->id)
                ->inRandomOrder()
                ->take(rand(1, 5))
                ->get();

            foreach ($followers as $follower) {
                DB::table('followers')->updateOrInsert(
                    ['user_id' => $user->id, 'follower_id' => $follower->id],
                    ['created_at' => now(), 'updated_at' => now()]
                );
            }
        }
    }
}
