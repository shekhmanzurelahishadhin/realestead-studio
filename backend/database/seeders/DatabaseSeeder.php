<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            SettingSeeder::class,
            ProjectSeeder::class,
            PropertySeeder::class,
            ServiceSeeder::class,
            TestimonialSeeder::class,
            ProcessStepSeeder::class,
            StatSeeder::class,
        ]);
    }
}
