<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    // Override the default login method
    public function login(Request $request)
    {
        
        // Validate the login request
        // $validator = Validator::make($request->all(), [
        //     'username' => 'required|string',
        //     'password' => 'required',
        //     'captcha' => 'required|captcha',
        // ]);

        $rules = [
            'username' => 'required|string',
            'password' => 'required',
        ];

        // Conditionally add CAPTCHA validation rule
        if (!app()->environment('local')) {
            $rules['captcha'] = 'required|captcha';
        }

        $validator = Validator::make($request->all(), $rules);
        
        // Attempt to log the user in
        
        // the first if attempts everything that has been
        // validated successfully including the captcha
        // if (Auth::attempt($validator->validated())) {

        // the working if tells us that only attempt
        // the username and password fields which is required at the moment
        
        if (auth()->attempt(['username' => $request->username, 'password' => $request->password])) {
            // Authentication was successful
            return redirect()->intended('/admin');
        }

        // Authentication failed
        throw ValidationException::withMessages([
            $this->username() => [trans('auth.failed')],
        ]);
    }

    public function loginScreen(){
        
        if(tenant()->id == 'paf'){
            return view('admin.logins.loginPaf');
        }
        elseif(tenant()->id == 'pcom'){
            return view('admin.logins.loginPcom');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        // Redirect based on the tenant context if necessary
        return redirect()->route('loginScreen'); // Change to your desired route
    }

    public function username()
    {
        return 'username';
    }
}
