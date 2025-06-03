<?php

namespace Database\Seeders;

use App\Models\UserType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userTypes = [
            ['name' => 'admin',     'is_public' => false],
            ['name' => 'user',      'is_public' => true],
            ['name' => 'artist',    'is_public' => true],
            ['name' => 'collector', 'is_public' => true],
            ['name' => 'other',     'is_public' => true],
        ];
        foreach ($userTypes as $type) {
            UserType::updateOrCreate(
                ['name' => $type['name']],
                ['is_public' => $type['is_public']]
            );
        }
    }
}
