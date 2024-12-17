<?php

namespace Database\Seeders;

use App\Models\Section;
use App\Models\Tenant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sections = [
            [
                // 'id' => 1,
                'name' => 'Lipsum',
                'tenant_id' => Tenant::inRandomOrder()->first()->id,
            ],
            [
                // 'id' => 2,
                'name' => 'Section UPP',
                'tenant_id' => Tenant::inRandomOrder()->first()->id,
            ],
            [
                // 'id' => 3,
                'name' => 'Gym Bar',
                'tenant_id' => Tenant::inRandomOrder()->first()->id,
            ],
            [
                // 'id' => 4,
                'name' => 'Sports',
                'tenant_id' => Tenant::inRandomOrder()->first()->id,
            ],
            [
                // 'id' => 5,
                'name' => 'Bonsai',
                'tenant_id' => Tenant::inRandomOrder()->first()->id,
            ],
            [
                // 'id' => 6,
                'name' => 'Chukululu',
                'tenant_id' => Tenant::inRandomOrder()->first()->id,
            ],
            [
                // 'id' => 7,
                'name' => 'Lahore',
                'tenant_id' => Tenant::inRandomOrder()->first()->id,
            ],
            
        ];

        Section::insert($sections);
    }
}
