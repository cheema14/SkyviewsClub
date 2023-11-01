<?php

namespace Database\Seeders;

use App\Models\SportItemName;
use Illuminate\Database\Seeder;

class SportItemNameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $csvFile = fopen(base_path('database/seeders/csv_files/sport_item_names.csv'), 'r');

        $firstline = true;
        while (($data = fgetcsv($csvFile, 2000, ',')) !== false) {
            if (! $firstline) {
                SportItemName::create([
                    'item_class_id' => $data['0'],
                    'item_name' => $data['1'],
                    'item_rate' => $data['2'],
                    'unit' => $data['3'],
                ]);
            }
            $firstline = false;
        }

        fclose($csvFile);
    }
}
