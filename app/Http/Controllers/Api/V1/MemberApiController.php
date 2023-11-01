<?php

namespace App\Http\Controllers\Api\V1;

use Auth;
use App\Models\Menu;
use App\Models\Member;
use App\Models\TableTop;
use Illuminate\Http\Request;
use App\Models\MenuItemCategory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Traits\ApiResponser;

class MemberApiController extends Controller
{
    use ApiResponser;

    protected $message = '';

    protected $data = array();

    public function login(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'cnic_no' => 'required|string',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->error('', 401, $validator->errors());
        }

        if (!Auth::guard('member')->attempt($validator->validated())) {
            return $this->error('Credentials not matched', 401);
        }

        return $this->success(
            [
                'token' => Auth::guard('member')
                    ->user()
                    ->createToken('member-token', ['list-menus', 'change-password', 'update-profile'])
                    ->plainTextToken,
                'member' => Auth::guard('member')->user(),
            ],
            'Login successful'
        );

    }

    public function logout()
    {

        Auth::guard('member')
            ->user()
            ->tokens()
            ->delete();

        return [
            'message' => 'Logged out successfully',
        ];
    }

    public function search(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'membership_no' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->error('', 401, $validator->errors());
        }

        $member = Member::query()->with('dependents')
            ->where('membership_no', $request->membership_no)
            ->first();

        if (!$member) {
            return $this->error(__('apis.member.failedSearch'), 200, );
        }

        $tableTop = TableTop::all();

        return $this->success(
            ['member' => $member , 'tableTop'=> $tableTop], __('apis.member.search')
        );
    }

    public function menus()
    {

        return $this->success([
            'menu' => Menu::with('menuItems')->get(),
            'menuItemCategories' => MenuItemCategory::all(),
        ],
            __('apis.member.menus')
        );
    }

    public function change_password(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'cnic_no' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->error('', 401, $validator->errors());
        }

        $member = Member::query()
            ->where('cnic_no', $request->cnic_no)
            ->first();

        if (!$member) {
            return $this->error('Member not found', 403, $validator->errors());
        }

        $member->password = bcrypt($request->password);
        $member->save();

        return $this->success(['member' => $member], __('apis.member.changePassword'));

    }

    public function update_profile(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'photo' => 'image|mimes:jpeg,png,jpg',
            'cell_no' => 'string|max:11',
            'permanent_address' => 'string|max:150',
            'cnic_no' => 'required|string|max:15',
        ]);

        if ($validator->fails()) {
            return $this->error('', 401, $validator->errors());
        }

        $member = Member::query()
            ->where('cnic_no', $request->cnic_no)
            ->first();

        $file = $request->file('photo');

        if ($request->hasFile('photo')) {
            $member->media()->delete();
            $member->addMedia($file)->toMediaCollection('photo');
        }

        return $this->success(['member' => $member], __('apis.member.updateProfile'));
    }
}
