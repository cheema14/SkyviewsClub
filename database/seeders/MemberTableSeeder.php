<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MemberTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $member = Member::find(1);
        $member->password = bcrypt('member123');
        $member->save();

        $member = Member::find(2);
        $member->password = bcrypt('member123');
        $member->save();

    }
}
