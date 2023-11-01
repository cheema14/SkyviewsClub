<?php

namespace Database\Seeders;
use App\Models\MembershipType;

use Illuminate\Database\Seeder;
use App\Models\MembershipCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MembershipTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $membershipTypes = array(
            array("id"=>1,"name"=>"Civilian Member"),
            array("id"=>2,"name"=>"Civilian Members Ward"),
            array("id"=>3,"name"=>"Clubhouse Membership"),
            array("id"=>4,"name"=>"Clubhouse Temporary" ),
            array("id"=>5,"name"=>"Corporate Member" ),
            array("id"=>6,"name"=>"CSP RETD (Navy Army Officer" ),
            array("id"=>7,"name"=>"CSP Serving Officer"),
            array("id"=>8,"name"=>"Defence RETD PAF Officer" ),
            array("id"=>9,"name"=>"Gratis" ),
            array("id"=>10,"name"=>"Military Officer Permanent Army" ),
            array("id"=>11,"name"=>"Military Officer Permanent PAF" ),
            array("id"=>12,"name"=>"PAF Officer 60 to 70 Years" ),
            array("id"=>13,"name"=>"PAF Officer Above 70 Years" ),
            array("id"=>14,"name"=>"PAF Serving Lahore Only" ),
            array("id"=>15,"name"=>"PAF Shuhada" ),
            array("id"=>16,"name"=>"PAF Wards" ),


        );

        foreach ($membershipTypes as $type) {
            MembershipType::firstOrCreate($type);
        }
    }
}
