<?php 

namespace App\Services;
use App\Http\Requests\AccountVerificationRequest;
use App\Models\Otp;

class OtpService {
    public function __construct() { }

    public function otp($user_id,$user_id_type):bool
    {
        $otp = Otp::where("".$user_id_type, $user_id)->first();
        if($otp){
            $otp->delete();
         }

         $otpCode = rand(100000,999999);
         Otp::create([
            "".$user_id_type => $user_id,
            "code"=> $otpCode,
         ]);

         return true;

    }

    public function accountVerify(AccountVerificationRequest $request):bool
    {
        $otp = Otp::where("".$request->user_id_type, $request->user_id)
                ->where("code", $request->code)
                ->first();
        if($otp){
             $otp->delete();
             return true;
        }
        return false;
    }
}