<?php

namespace App\Http\Controllers\Admin;

use App\Models\Bill;
use App\Models\Member;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BillController extends Controller
{
    public function index(){

        $members = Member::all();

        $data = $members->map(function($member){

            return  [
                'member_id' => $member->id,
                'monthly_subscription' => $member->membership_type->monthly_fee,
                'cafe_charges' => $member->creditOnlyTransactions,
                'bill_month' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ];

        })->toArray();

        // dd($data);
        // Find charges of restaurant or cafe
        // $where = [
        //     'type' => 'Credit',
        //     'status' => 'Success'
        //     ];
        // $transaction = Transaction::where(['type','=', 'Credit']);

        Bill::insert($data);


    }


}
