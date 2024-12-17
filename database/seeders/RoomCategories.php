<?php

namespace Database\Seeders;

use App\Models\RoomCategory;
use Illuminate\Database\Seeder;

class RoomCategories extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roomCategories = [
            [
                'id' => 1,
                'title' => 'Deluxe',
                'floor' => '1st Floor',
                'tenant_id' => 'pcom',
            ],
            [
                'id' => 2,
                'title' => 'Suite',
                'floor' => '1st Floor',
                'tenant_id' => 'pcom',
            ],
        ];

        RoomCategory::insert($roomCategories);
    }
}
