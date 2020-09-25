<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Role\UserRole;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

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

    use AuthenticatesUsers {
        login as traitLogin;
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    // Override trait function and call it from the overriden function
    public function login(Request $request)
    {
        //Set session as 'login'
        Session::put('last_auth_attempt', 'login');

        $validator = Validator::make($request->all(), [
            recaptchaFieldName() => recaptchaRuleName()
        ]);

        if($validator->fails()) {
            return back()->withInput()
                ->withErrors($validator->errors());
        }

        //The trait is not a class. You can't access its members directly.
        return $this->traitLogin($request);
    }


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function authenticated(Request $request, User $user)
    {
        if ( $user->hasRole(UserRole::ROLE_ADMIN) ) {// do your magic here
            return redirect()->route('admin.home');
        } else {
            return redirect('/home');
        }

    }
}
