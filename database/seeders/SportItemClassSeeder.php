<?php

namespace Database\Seeders;

use App\Models\SportItemClass;
use Illuminate\Database\Seeder;

class SportItemClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $csvFile = fopen(base_path('database/seeders/csv_files/item_classes_table.csv'), 'r');

        $firstline = true;
        while (($data = fgetcsv($csvFile, 2000, ',')) !== false) {
            if (! $firstline) {
                SportItemClass::create([
                    'item_type_id' => $data['0'],
                    'item_class' => $data['1'],
                ]);
            }
            $firstline = false;
        }

        fclose($csvFile);

    }
}
