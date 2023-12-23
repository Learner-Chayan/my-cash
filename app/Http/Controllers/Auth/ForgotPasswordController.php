<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class ForgotPasswordController extends Controller
{

    use SendsPasswordResetEmails;

    public function __construct()
    {
        $this->middleware(['guest','Setting']);
    }
    public function showLinkRequestForm()
    {
        $data['page_title'] = "Reset Password";
        return view('auth.passwords.email',$data);
    }
}
