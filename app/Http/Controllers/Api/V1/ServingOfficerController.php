<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Member;
use App\Models\TableTop;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Traits\ApiResponser;

class ServingOfficerController extends Controller
{
    use ApiResponser;

    public function saveOfficer(Request $request){

        $validator = Validator::make($request->all(), [
            'officer_name' => 'required',
            'pak_no' => 'required',
            'user_type' => 'sometimes',
            // 'cnic_no' => 'sometimes|min:13',
        ]);

        if ($validator->fails()) {
            return $this->error('', 401, $validator->errors());
        }

        // dd($request->all());
        $existing_record = Member::where('membership_no', $request->pak_no)->first();

        if($existing_record){
            $member = $existing_record;
        }
        else{

            $member = Member::create(
                [
                    'name' => $request->officer_name,
                    'membership_no' =>$request->pak_no,
                    'cell_no' => $request->contact_no ? $request->contact_no: '',
                    'cnic_no' => $request->cnic_no ? $request->cnic_no:'',
                    'is_non_member' => 1,
                    'membership_status' => 'Active',
                    'serving_officer_type' => $request->user_type,
                ]
            );

        }



        $tableTop = TableTop::all();

        return $this->success(
            ['member' => $member , 'tableTop'=> $tableTop], __('apis.nonMember.search')
        );

    }
}
