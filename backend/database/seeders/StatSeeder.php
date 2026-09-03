<?php

namespace Database\Seeders;

use App\Models\Stat;
use Illuminate\Database\Seeder;

class StatSeeder extends Seeder
{
    public function run(): void
    {
        $stats = [
            ['value' => 25, 'suffix' => '+', 'label' => 'Years experience'],
            ['value' => 120, 'suffix' => '+', 'label' => 'Projects delivered'],
            ['value' => 18, 'suffix' => '', 'label' => 'Cities'],
            ['value' => 2.4, 'suffix' => 'M+', 'label' => 'Sq ft developed'],
        ];

        foreach ($stats as $index => $stat) {
            Stat::updateOrCreate(
                ['label' => $stat['label']],
                $stat + ['sort_order' => $index]
            );
        }
    }
}
