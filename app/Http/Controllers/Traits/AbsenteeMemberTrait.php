<?php

namespace App\Http\Controllers\Traits;

use App\Events\DiscountedMembershipFeeEvent;
use App\Models\DiscountedMembershipFee;
use Carbon\Carbon;
use Illuminate\Http\Request;

trait AbsenteeMemberTrait
{
    public function update_absentee_monthly_type($absentee_data,$id){
        
        
        $discounted_membership_fee = DiscountedMembershipFee::where('member_id',$id)->where('is_active',1)->get()->first();
        
        if(!$discounted_membership_fee){

            $discounted_membership_fee = new DiscountedMembershipFee();    
            $discounted_membership_fee->monthly_subscription_revised = $absentee_data['monthly_subscription_revised'];
            $discounted_membership_fee->implemented_from = Carbon::parse($absentee_data['absentee_from_date'])->format('Y-m-d');
            $discounted_membership_fee->implemented_to = Carbon::parse($absentee_data['absentee_to_date'])->format('Y-m-d');
            
            $fromDate = Carbon::parse($absentee_data['absentee_from_date']);
            $toDate = Carbon::parse($absentee_data['absentee_to_date']);

            $no_of_months = $fromDate->diffInMonths($toDate);
            
            $discounted_membership_fee->no_of_months = $no_of_months;
            $discounted_membership_fee->member_id = $id;
            $discounted_membership_fee->is_active = 1;
            $discounted_membership_fee->save();
        }
        else{
            $discounted_membership_fee->monthly_subscription_revised = $absentee_data['monthly_subscription_revised'];
            $discounted_membership_fee->implemented_from = Carbon::parse($absentee_data['absentee_from_date'])->format('Y-m-d');
            $discounted_membership_fee->implemented_to = Carbon::parse($absentee_data['absentee_to_date'])->format('Y-m-d');
            
            $fromDate = Carbon::parse($absentee_data['absentee_from_date']);
            $toDate = Carbon::parse($absentee_data['absentee_to_date']);
    
            $no_of_months = $fromDate->diffInMonths($toDate);
            
            $discounted_membership_fee->no_of_months = $no_of_months;
            $discounted_membership_fee->member_id = $id;
            $discounted_membership_fee->save();
            
        }

        $data['monthly_subscription'] = $absentee_data['monthly_subscription_revised'];
        $data['member_id'] = $id;
        $data['update_call'] = false;
        $data['absentees_monthly_subscription'] = true;
        DiscountedMembershipFeeEvent::dispatch($data);

        // if ($request->input('absentees_application', false)) {
        //     if (! $discounted_membership_fee->absentees_application || $request->input('absentees_application') !== $discounted_membership_fee->absentees_application->file_name) {
        //         if ($discounted_membership_fee->absentees_application) {
        //             $discounted_membership_fee->absentees_application->delete();
        //         }
        //         $discounted_membership_fee->addMedia(storage_path('tmp/uploads/'.basename($request->input('absentees_application'))))->toMediaCollection('absentees_application');
        //     }
        // } elseif ($discounted_membership_fee?->absentees_application) {
        //     $discounted_membership_fee->absentees_application->delete();
        // }

        // dd($absentee_data,$discounted_membership_fee,$id);
    }

    public function create_absentee_monthly_type($absentee_data,$id){
        
        // $discounted_membership_fee = new DiscountedMembershipFee();
        
        // $discounted_membership_fee->monthly_subscription_revised = $request->monthly_subscription_revised;
        // $discounted_membership_fee->no_of_months = $request->no_of_months;
        // $discounted_membership_fee->member_id = $member->id;
        // $discounted_membership_fee->implemented_from = date('Y-m-d');
        // $discounted_membership_fee->remaining_months = $request->no_of_months;
        // $discounted_membership_fee->is_active = 1;
        // $discounted_membership_fee->save(); 
    }
}