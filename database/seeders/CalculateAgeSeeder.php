<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Member;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CalculateAgeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $members = Member::all();

        foreach($members as $member){

            $dob = Carbon::parse($member->date_of_birth);

            $dob = $dob->diff(Carbon::now())->format('%y years, %m months and %d days');
            $member->member_age = $dob;
            $member->update();
        }
    }
}
