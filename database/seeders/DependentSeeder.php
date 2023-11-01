<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Dependent;

class DependentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Dependent::truncate();
  
        $csvFile = fopen(base_path("database/data/dependents.csv"), "r");
  
        $firstline = true;
        while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE) {
            if (!$firstline) {
                Dependent::create([
                    "name" => $data['0'],
                    "dob" => $data['1'],
                    "relation" => $data['2'],
                    "member_id" => $data['3'],
                    "allow_credit" => $data['4']
                ]);    
            }
            $firstline = false;
        }
   
        fclose($csvFile);
    }
}
