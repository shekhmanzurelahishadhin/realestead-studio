<?php

namespace Database\Seeders;

use App\Models\ProcessStep;
use Illuminate\Database\Seeder;

class ProcessStepSeeder extends Seeder
{
    public function run(): void
    {
        $steps = [
            ['key' => 'c1', 'index_label' => '01', 'title' => 'Concept', 'description' => 'Site analysis, feasibility and an architectural concept grounded in context and light.'],
            ['key' => 'c2', 'index_label' => '02', 'title' => 'Design', 'description' => 'Detailed architectural and structural design, developed alongside interior and landscape.'],
            ['key' => 'c3', 'index_label' => '03', 'title' => 'Planning', 'description' => 'Approvals, permitting and a construction programme sequenced for cost and quality.'],
            ['key' => 'c4', 'index_label' => '04', 'title' => 'Construction', 'description' => 'In-house project management on site, with weekly progress reporting to every stakeholder.'],
            ['key' => 'c5', 'index_label' => '05', 'title' => 'Quality Control', 'description' => 'Independent inspection at every milestone, from structural pour to final finishes.'],
            ['key' => 'c6', 'index_label' => '06', 'title' => 'Delivery', 'description' => "Handover documentation, aftercare and a maintenance plan for the building's first year."],
        ];

        foreach ($steps as $index => $step) {
            ProcessStep::updateOrCreate(
                ['key' => $step['key']],
                $step + ['sort_order' => $index]
            );
        }
    }
}
