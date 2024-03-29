<?php

namespace App\Services;
use App\Http\Requests\AccountVerificationRequest;
use App\Models\Otp;
use Carbon\Carbon;

class OtpService {

    public function __construct() { }

    public function otp($user_id,$user_id_type):int
    {
        //user_id means email or phone
        $otp = Otp::where("".$user_id_type, $user_id)->first();
        if($otp){
            $otp->delete();
         }

         $otpCode = rand(10000,99999);
         Otp::create([
            "".$user_id_type => $user_id,
            "code"=> $otpCode,
         ]);

         return $otpCode;

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

    public function isOTPExpired(AccountVerificationRequest $request):bool
    {
        $otp = Otp::where("".$request->user_id_type, $request->user_id)
        ->where("code", $request->code)
        ->first();
        if($otp){
            $createdAt = Carbon::parse($otp->created_at);
                if ($createdAt->diffInMinutes(Carbon::now()) <= 5) {
                    return false;
                }
        }
        return true;
    }
}
