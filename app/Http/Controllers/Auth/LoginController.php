<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
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
    protected $redirectTo = '/home';  


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }




    /**
     *  switch from 'email' to 'name' for Auth credentials 
     *  this function overwrite itself into AuthenticatesUsers class
     *
     */
    public function username()
    {
        return 'name';
    }


    /**
    *  IF Admin: redirect to --> admin/home 
    */
    protected function authenticated($request, $user)
    {
        if($user->is_admin === 1) {
            return redirect()->intended('/admin/home');
        }

        // return redirect()->intended('/path_for_normal_user');
    }



}
