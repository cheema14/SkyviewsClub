<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Designation;

class DesignationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $designations = array(
            array("id"=>1,"title"=>"ACR"),
            array("id"=>2,"title"=>"AIR CDRE"),
            array("id"=>3,"title"=>"AVM"),
            array("id"=>4,"title"=>"BRIG" ),
            array("id"=>5,"title"=>"CAPTAIN" ),
            array("id"=>6,"title"=>"CIVILIAN" ),
            array("id"=>7,"title"=>"COL"),
            array("id"=>8,"title"=>"FLG OFF" ),
            array("id"=>9,"title"=>"FLT LT" ),
            array("id"=>10,"title"=>"FLY OFF" ),
            array("id"=>11,"title"=>"GP CAPT" ),
            array("id"=>12,"title"=>"LT COL" ),
            array("id"=>13,"title"=>"MAJ" ),
            array("id"=>14,"title"=>"PLT OFF" ),
            array("id"=>15,"title"=>"SG CDR" ),
            array("id"=>16,"title"=>"SNQ LDR" ),
            array("id"=>17,"title"=>"SQN LDR" ),
            array("id"=>18,"title"=>"WC CDR" ),
            array("id"=>19,"title"=>"WG CDR" ),
            array("id"=>20,"title"=>"WING CDR" ),
            array("id"=>21,"title"=>"Other" ),


        );

        foreach ($designations as $designation) {
            Designation::firstOrCreate($designation);
        }
    }
}
