<?php

namespace Database\Seeders;

use App\Models\MembershipCategory;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MembershipCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {


            $membershipCategories = array(
                array("id"=>1,"name"=>"Temporary"),
                array("id"=>2,"name"=>"Permanent"),
                array("id"=>3,"name"=>"Gratis"),
                array("id"=>4,"name"=>"Club House Only" ),
                array("id"=>5,"name"=>"PAF Wards" ),
                array("id"=>6,"name"=>"Senior Citizen" ),
                array("id"=>7,"name"=>"Veteran"),
                array("id"=>8,"name"=>"Shuhada Family" ),
                array("id"=>9,"name"=>"Nobal Civilian" ),
            );

            foreach ($membershipCategories as $category) {
                MembershipCategory::firstOrCreate($category);
            }

    }
}
