<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

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
        $this->middleware('auth')->only('logout');
    }

     /**
     * The user has been authenticated.
     * This is called automatically after successful login.
     */
    protected function authenticated(Request $request, $user)
    {
        // 🔐 Generate Sanctum token
        $token = $user->createToken('auth_token')->plainTextToken;

        session(['auth_token' => $token]);

        // 🎯 Role-based redirection
        if ($user->hasRole('Super Admin') || $user->hasRole('Admin')) {
            return redirect()->route('admin.dashboard');  // <<<<< FIXED
        }

        return redirect()->route('home');  // <<<<< you said you want 'home' for customer
    }

}
