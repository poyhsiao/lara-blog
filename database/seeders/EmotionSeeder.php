<?php

namespace Database\Seeders;

use App\Models\Emotion;
use Illuminate\Database\Seeder;

class EmotionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Emotion::factory()
            ->count(50)
            ->create();
    }
}
