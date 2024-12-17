<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\ApiResponser;
use App\Http\Resources\ItemResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use Arr;
use Auth;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Sanctum\PersonalAccessToken;

class UserApiController extends Controller
{
    use ApiResponser;


    public function login(Request $request){

      
        $validator = Validator::make($request->all(), [
            // 'email' => 'required_if:userType,1|string|email',
            'username' => 'required_if:userType,1|string',
            'password' => 'required',
            'userType' => [
                'required',Rule::in([1])
            ],
            'membership_no' => 'required_if:userType,2'
        ]);

        if ($validator->fails()) {
            return $this->error('',200,$validator->errors());
        }

        $token = '';
        
        $userId = $request->username;
        $userId = User::where('username',$request->username)->pluck('id')->first();
        
        $issuedTokens = PersonalAccessToken::where('tokenable_type', User::class)
                                   ->where('tokenable_id', $userId)
                                   ->where('is_active', 1)
                                   ->get();


        if($request->userType == 1){
            
        }

        if (!Auth::attempt(Arr::except($validator->validated(),['userType','membership_no']))) {
            return $this->error('Credentials not match', 200);
        }

        if($issuedTokens->count() >= 1){
            // $issuedTokens->each->delete();
            $issuedTokens->each(function ($token) {
                $token->is_active = 0;
                $token->save();
            });          
        }

        return $this->success(
            [
                'token' => auth()->user()->createToken('Access Token',['place-orders','member-search'])->plainTextToken,
                'user' => auth()->user(),
                'roles' => auth()->user()->roles
            ],
            'Login successful'
        );

        // if (!Auth::guard('member')->attempt(Arr::except($validator->validated(),['userType','email']))) {
        //     return $this->error('Credentials not matched', 401);
        // }

        // return $this->success(
        //     [
        //         'token' => Auth::guard('member')
        //             ->user()
        //             ->createToken('member-token', ['list-menus', 'change-password', 'update-profile'])
        //             ->plainTextToken,
        //         'member' => Auth::guard('member')->user(),
        //     ],
        //     'Login successful'
        // );


    }

    public function userOrders(){

        return $this->success(
            [
                 new UserResource(auth()->user()->load('orders.items'))
            ],
            'Updated Orders History.'
        );

    }

    public function logout()
    {

        $user = Auth::guard('user')->user();

        if ($user) {
            // $user->tokens()->delete();
            $user->tokens()->update(['is_active' => 0]);
            return [
                'message' => __('apis.user.loggedOut'),
            ];
        }

        return [
            'message' => __('apis.user.noLoggedOut'),
        ];
    }

}
