<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'key' => 's1',
                'title' => 'Real Estate Development',
                'description' => 'End-to-end development from land acquisition and feasibility to sales — we carry projects from concept to keys handed over.',
                'image' => 'images/development-site.jpg',
            ],
            [
                'key' => 's2',
                'title' => 'Construction',
                'description' => 'In-house construction management with certified engineers on every site, holding tolerances to the millimetre from foundation to façade.',
                'image' => 'images/construction-site.jpg',
            ],
            [
                'key' => 's3',
                'title' => 'Architectural Design',
                'description' => 'A design studio that treats climate, light and material as the brief — every building begins with the site, not a template.',
                'image' => 'images/architectural-detail.jpg',
            ],
            [
                'key' => 's4',
                'title' => 'Interior Design',
                'description' => "Interiors conceived alongside the architecture, so joinery, light and material continue the building's logic into every room.",
                'image' => 'images/interior-warm-light.jpg',
            ],
            [
                'key' => 's5',
                'title' => 'Property Management',
                'description' => 'Long-term stewardship of every building we deliver — facilities, tenancy and maintenance handled by one accountable team.',
                'image' => 'images/retail-facade.jpg',
            ],
            [
                'key' => 's6',
                'title' => 'Commercial Development',
                'description' => 'Offices and retail built for the way people work and shop now — flexible floorplates, daylight and easy servicing.',
                'image' => 'images/riverside-block.jpg',
            ],
        ];

        foreach ($services as $index => $service) {
            Service::updateOrCreate(
                ['key' => $service['key']],
                $service + ['sort_order' => $index]
            );
        }
    }
}
