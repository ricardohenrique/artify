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
        $userTypes = ['admin', 'user', 'artist', 'collector'];
        collect($userTypes)->each(function ($type) {
            UserType::firstOrCreate(['name' => $type]);
        });
    }
}
