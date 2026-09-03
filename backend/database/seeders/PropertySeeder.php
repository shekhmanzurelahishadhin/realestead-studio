<?php

namespace Database\Seeders;

use App\Models\Property;
use Illuminate\Database\Seeder;

class PropertySeeder extends Seeder
{
    public function run(): void
    {
        $properties = [
            [
                'slug' => 'the-skyline-residence',
                'title' => 'The Skyline Residence',
                'location' => 'Gulshan 2, Dhaka',
                'price' => 28500000,
                'price_label' => '৳ 2.85 Cr',
                'area' => 2450,
                'bedrooms' => 3,
                'bathrooms' => 3,
                'status' => 'available',
                'image' => 'images/skyline-residence.jpg',
                'gallery' => [
                    'images/skyline-residence.jpg',
                    'images/interior-warm-light.jpg',
                ],
                'amenities' => ['Lake view', 'Private lift lobby', 'Rooftop pool', '24/7 concierge'],
            ],
            [
                'slug' => 'arcadia-garden-duplex',
                'title' => 'Arcadia Garden Duplex',
                'location' => 'Gulshan Avenue, Dhaka',
                'price' => 41200000,
                'price_label' => '৳ 4.12 Cr',
                'area' => 3600,
                'bedrooms' => 4,
                'bathrooms' => 4,
                'status' => 'available',
                'image' => 'images/duplex-facade.jpg',
                'gallery' => [
                    'images/duplex-facade.jpg',
                    'images/retail-facade.jpg',
                ],
                'amenities' => ['Private garden', 'Double-height living', 'Home office', 'EV charging'],
            ],
            [
                'slug' => 'riverside-loft-12b',
                'title' => 'Riverside Loft 12B',
                'location' => 'Agrabad, Chittagong',
                'price' => 16800000,
                'price_label' => '৳ 1.68 Cr',
                'area' => 1780,
                'bedrooms' => 2,
                'bathrooms' => 2,
                'status' => 'upcoming',
                'image' => 'images/riverside-loft.jpg',
                'gallery' => [
                    'images/riverside-loft.jpg',
                ],
                'amenities' => ['River view', 'Exposed concrete finish', 'Co-working lounge'],
            ],
            [
                'slug' => 'grand-terrace-penthouse',
                'title' => 'Grand Terrace Penthouse',
                'location' => 'Banani, Dhaka',
                'price' => 65000000,
                'price_label' => '৳ 6.50 Cr',
                'area' => 4800,
                'bedrooms' => 5,
                'bathrooms' => 5,
                'status' => 'sold',
                'image' => 'images/penthouse-view.jpg',
                'gallery' => [
                    'images/penthouse-view.jpg',
                ],
                'amenities' => ['360° city view', 'Private terrace pool', 'Wine cellar', 'Smart home system'],
            ],
        ];

        foreach ($properties as $index => $property) {
            Property::updateOrCreate(
                ['slug' => $property['slug']],
                $property + ['sort_order' => $index]
            );
        }
    }
}
