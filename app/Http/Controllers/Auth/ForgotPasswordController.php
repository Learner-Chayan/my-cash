<?php

namespace App\Http\Controllers\Auth;

use App\Enums\UserIdTypeEnums;
use App\Http\Controllers\Controller;
use App\Http\Requests\ForgotPassRequest;
use App\Models\Otp;
use App\Models\User;
use App\Services\OtpService;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{

    use SendsPasswordResetEmails;

    protected $otpService;
    public function __construct(OtpService $otpService)
    {
        $this->middleware(['guest','Setting']);
        $this->otpService = $otpService;
    }
    public function email()
    {
        $data['page_title'] = "Send OTP in Email";
        return view('auth.passwords.email',$data);
    }
    public function phone()
    {
        $data['page_title'] = "Send OTP in Phone";
        return view('auth.passwords.phone',$data);
    }
    public function sendOtp(ForgotPassRequest $request)
    {
        $userId = $request->user_id_type == UserIdTypeEnums::EMAIL ? $request->email : $request->phone;
        $otp = $this->otpService->otp($userId,$request->user_id_type);

        if ($request->user_id_type == UserIdTypeEnums::PHONE){
            //send otp via phone
            $msg = "Your OTP is : ".$otp;
//            dd($msg);
        }else{
            // send otp via email
            $msg = "Your OTP is : ".$otp;
        }
        session()->put('otp_checked', true);
        session()->put('user_id', $userId);

        return redirect()->route('otp-check');

    }
    public function checkOtp()
    {
        $otpChecked = session()->get('otp_checked', false); // Returns false if 'otp_checked' doesn't exist
        $userId = session()->get('user_id'); // Returns null if 'user_id' doesn't exist

        // Check if 'otp_checked' is set in the session and is true
        if ($otpChecked)
        {
            $data['page_title'] = "OTP send to " .$userId;
            return view('auth.passwords.confirm',$data);
        }else{

            return redirect()->route('/');
        }

    }
    public function matchOtp(Request $request)
    {
        $valid = $this->validate($request,[
           'otp' => 'required|exists:otps,code',
        ]);
        if (!$valid) {

            return redirect()->withErrors($valid->errors());
        }
        $otp = Otp::where('code',$request->otp)->first();
        if ($otp){
            session()->put('code', $otp->code);

            $data['page_title'] = "Reset Your Password";
            return view('auth.passwords.reset',$data);
        }

    }
    public function submitPassword(Request $request)
    {
        $valid = $this->validate($request,[
           'password' => 'required|min:6',
           'confirm-password' => 'required|same:password',
        ]);
        if (!$valid) {

            return redirect()->withErrors($valid->errors());
        }
        $code = session()->get('code'); // Returns null if 'user_id' doesn't exist

        $otp = Otp::where("code",$code)->first();
        $userId = session()->get('user_id'); // Returns null if 'user_id' doesn't exist

        if ($otp){

            $user = User::where("phone",$userId)->OrWhere('email',$userId)->first();
            $user->password = $request->password;
            $user->save();// save user password

            $otp->delete(); // delete the otp
            //forget all session
            session()->forget('otp_checked');
            session()->forget('user_id');
            session()->forget('code');

            session()->flash('message','Successfully Changed Password!');
            return redirect()->route('/');
        }

    }

}
