<?php

namespace Database\Seeders;

use App\Models\Department;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $aArrayRecord = array(
            // array('id'=>3,'uuid'=>\Ramsey\Uuid\Uuid::uuid4()->toString(),'hospitalOrder'=>1,'hospital_name'=>'Punjab Institute of Cardiology, Lahore','short_name'=>'pic','district_name'=>'Lahore'),
            array("id"=>1,"name"=>"Army"),
            array("id"=>2,"name"=>"Navy"),
            array("id"=>3,"name"=>"Air Force"),
            array("id"=>4,"name"=>"Business"),
            array("id"=>5,"name"=>"Govt Service"),
            array("id"=>6,"name"=>"Foreigner"),
            array("id"=>7,"name"=>"CSP"),
        );

        foreach ($aArrayRecord as $aRecord) {
            Department::firstOrCreate($aRecord);
        }
    }
}
