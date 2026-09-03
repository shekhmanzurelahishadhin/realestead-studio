<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        $projects = [
            [
                'slug' => 'the-arcadia',
                'name' => 'The Arcadia',
                'location' => 'Gulshan, Dhaka',
                'category' => 'Luxury Residential',
                'year' => '2024',
                'description' => 'A 32-storey residential tower organised around a central light well, pairing exposed concrete with warm timber interiors. Each residence is oriented to frame the lake beyond Gulshan Avenue.',
                'image' => 'images/arcadia-tower.jpg',
                'gallery' => [
                    'images/arcadia-tower.jpg',
                    'images/interior-warm-light.jpg',
                    'images/duplex-facade.jpg',
                ],
                'stats' => [
                    ['label' => 'Units', 'value' => '184'],
                    ['label' => 'Floors', 'value' => '32'],
                    ['label' => 'Completed', 'value' => '2024'],
                ],
            ],
            [
                'slug' => 'riverside-heights',
                'name' => 'Riverside Heights',
                'location' => 'Agrabad, Chittagong',
                'category' => 'Mixed-Use Development',
                'year' => '2023',
                'description' => "A terraced mixed-use block stepping down toward the Karnaphuli waterfront, combining retail podiums with residences shaded by perforated brise-soleil screens.",
                'image' => 'images/riverside-block.jpg',
                'gallery' => [
                    'images/riverside-block.jpg',
                    'images/architecture-sky.jpg',
                    'images/retail-facade.jpg',
                ],
                'stats' => [
                    ['label' => 'Retail units', 'value' => '46'],
                    ['label' => 'Residences', 'value' => '220'],
                    ['label' => 'Completed', 'value' => '2023'],
                ],
            ],
            [
                'slug' => 'the-grand-terrace',
                'name' => 'The Grand Terrace',
                'location' => 'Banani, Dhaka',
                'category' => 'Commercial & Residential',
                'year' => '2022',
                'description' => "A commercial ground plane topped with garden residences, using deep terraces and planting to break the tower's mass into a stack of private courtyards.",
                'image' => 'images/grand-terrace.jpg',
                'gallery' => [
                    'images/grand-terrace.jpg',
                    'images/architectural-detail.jpg',
                    'images/terrace-courtyard.jpg',
                ],
                'stats' => [
                    ['label' => 'Office floors', 'value' => '12'],
                    ['label' => 'Sky residences', 'value' => '58'],
                    ['label' => 'Completed', 'value' => '2022'],
                ],
            ],
            [
                'slug' => 'meridian-quarter',
                'name' => 'Meridian Quarter',
                'location' => 'Bashundhara, Dhaka',
                'category' => 'Township Development',
                'year' => '2025',
                'description' => 'A low-rise township of courtyard villas and shared gardens, planned around a car-free spine that connects a school, clinic and market square.',
                'image' => 'images/meridian-quarter.jpg',
                'gallery' => [
                    'images/meridian-quarter.jpg',
                    'images/villa-exterior.jpg',
                    'images/township-street.jpg',
                ],
                'stats' => [
                    ['label' => 'Villas', 'value' => '96'],
                    ['label' => 'Green area', 'value' => '40%'],
                    ['label' => 'Completing', 'value' => '2025'],
                ],
            ],
        ];

        foreach ($projects as $index => $project) {
            Project::updateOrCreate(
                ['slug' => $project['slug']],
                $project + ['sort_order' => $index]
            );
        }
    }
}
