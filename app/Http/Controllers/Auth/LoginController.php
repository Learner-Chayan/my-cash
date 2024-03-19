<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{

    use AuthenticatesUsers;


    protected $redirectTo = '/dashboard';


    public function __construct()
    {
         $this->middleware('Setting');
         $this->middleware('guest')->except('logout');
    }
    public function showLoginForm()
    {
        $data['page_title'] = "Login";
        return view('auth.login',$data);
    }

    protected function authenticated(Request $request, $user)
    {
        session()->flash('success', 'You are successfully logged in.');
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        // Flash a logout message to the session
        $request->session()->flash('message', 'You are logged out.');

        return $this->loggedOut($request) ?: redirect('/');
    }




}
