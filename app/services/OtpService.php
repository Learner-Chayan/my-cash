<?php 

namespace App\Services;
use App\Http\Requests\AccountVerificationRequest;
use App\Models\Otp;

class OtpService {
    public function __construct() { }

    public function otp($phone):bool
    {
        $otp = Otp::where("phone", $phone)->first();
        if($otp){
            $otp->delete();
         }

         $otpCode = rand(100000,999999);
         Otp::create([
            "phone"=> $phone,
            "code"=> $otpCode,
         ]);

         return true;

    }

    public function accountVerify(AccountVerificationRequest $request):bool
    {
        $otp = Otp::where("phone", $request->phone)
                ->where("code", $request->code)
                ->first();
        if($otp){
             $otp->delete();
             return true;
        }
        return false;
    }
}