<?php

namespace Database\Seeders;

use App\Models\Painting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaintingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Painting::factory(50)->create();
    }
}
