<?php

namespace App\Http\Controllers\Admin;

use App\Models\Member;
use Illuminate\Http\Request;
use App\Models\MembershipType;
use App\Http\Controllers\Controller;

class AssignMembership extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $membership_types = MembershipType::all()->pluck('id')->toArray();
        $members = Member::all();

        foreach($members as $member){
            $member->membership_type_id = array_rand($membership_types);
            $member->save();
            // dd($member->membership_type);
        }


    }
}
