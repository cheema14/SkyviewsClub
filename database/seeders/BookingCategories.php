<?php

namespace Database\Seeders;

use App\Models\BookingCategory;
use Illuminate\Database\Seeder;

class BookingCategories extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bookingCategories = [
            [
                'id' => 1,
                'title' => 'Platinum Category',
            ],
            [
                'id' => 2,
                'title' => 'Gold Category',
            ],
            [
                'id' => 3,
                'title' => 'Silver Category',
            ],
            [
                'id' => 4,
                'title' => 'Child Category',
            ],
        ];

        BookingCategory::insert($bookingCategories);
    }
}
