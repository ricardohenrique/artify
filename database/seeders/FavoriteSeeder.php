<?php

namespace Database\Seeders;

use App\Models\Painting;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FavoriteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $paintings = Painting::all();

        // For each user, randomly favorite 1–5 paintings
        foreach ($users as $user) {
            $favorites = $paintings->random(rand(1, 5));

            foreach ($favorites as $painting) {
                DB::table('favorites')->updateOrInsert(
                    ['user_id' => $user->id, 'painting_id' => $painting->id],
                    ['created_at' => now(), 'updated_at' => now()]
                );
            }
        }
    }
}
