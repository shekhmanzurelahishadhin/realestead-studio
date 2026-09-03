<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    public function run(): void
    {
        $testimonials = [
            [
                'quote' => 'Their attention to detail and commitment to quality transformed our vision into something far beyond what we imagined.',
                'name' => 'Farhana Rahman',
                'role' => 'Homeowner',
                'project' => 'The Arcadia',
            ],
            [
                'quote' => 'We handed them a difficult site and a tight programme. What came back was a building that solved both, elegantly.',
                'name' => 'Imtiaz Hossain',
                'role' => 'Managing Director, Orion Retail Group',
                'project' => 'Riverside Heights',
            ],
            [
                'quote' => 'From the first sketch to the final walkthrough, communication was constant and the craftsmanship never wavered.',
                'name' => 'Nusrat Jahan',
                'role' => 'Homeowner',
                'project' => 'The Grand Terrace',
            ],
        ];

        foreach ($testimonials as $index => $testimonial) {
            Testimonial::updateOrCreate(
                ['name' => $testimonial['name'], 'project' => $testimonial['project']],
                $testimonial + ['sort_order' => $index]
            );
        }
    }
}
