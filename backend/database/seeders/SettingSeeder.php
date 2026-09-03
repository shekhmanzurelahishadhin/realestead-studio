<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        Setting::updateOrCreate(
            ['id' => 1],
            [
                'site_name' => 'Meridian',
                'tagline' => 'Real Estate & Construction Studio · Est. 2000',
                'logo_image' => null, // falls back to the "Meridian" text wordmark
                'favicon' => null, // falls back to the bundled favicon.ico
                'hero_image' => 'images/architecture-sky.jpg',
                'hero_video' => 'videos/hero.mp4',
                'phone' => '+880 1711 000 000',
                'email' => 'hello@meridian.studio',
                'address' => 'House 14, Road 7, Gulshan 1, Dhaka',
                'instagram_url' => null,
                'linkedin_url' => null,
                'facebook_url' => null,
            ]
        );
    }
}
