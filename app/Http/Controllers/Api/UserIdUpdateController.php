<?php

namespace App\Http\Controllers\Api;

use App\Enums\UserIdTypeEnums;
use App\Http\Requests\AccountVerificationRequest;
use App\Http\Requests\UserIdResetRequest;
use App\Models\User;
use App\Models\Otp;
use App\Services\OtpService;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserIdUpdateController extends Controller
{
    public OtpService $otpService;
    public function __construct(OtpService $otpService){
        $this->otpService = $otpService;
    }
    public function resetUserId(Request $request){
        $request->validate([
            'user_id_type' => 'required|in:email,phone',
            "user_id" => $request->input('user_id_type') == UserIdTypeEnums::EMAIL ?  ['required','email','max:255'] : 
            ['required','string','min:10','max:14','regex:/^[0-9]+$/']
        ]);

        // Check account exist or not
        try {
            $user = User::where("".$request->user_id_type, $request->user_id)->first();
            if(!$user){
                return response(['status' => false, 'message' => 'Invalid '.$request->user_id_type]);
            }

           $otp =  $this->otpService->otp($request->user_id,$request->user_id_type);

           if($otp){
                return response(['status' => true, 'message' => "Otp send to your ".$request->user_id_type." . Otp = ".$otp]);
           }

           return response(['status' => false, 'message' => "Failed !! Try Again"]);

        } catch (Exception $e) {
            return response(['status' => false, 'message' => $e->getMessage()]);
        }
    }


    public function verifyOtp(AccountVerificationRequest $request){
        try {
            $otp = Otp::where("".$request->user_id_type, $request->user_id)
            ->where("code", $request->code)
            ->first();
        if($otp){
            //check if token expired
            $isExpired = $this->otpService->isOTPExpired($request);
            if($isExpired){
                return response(['status'=> false, 'message'=> 'OTP Expired !!'],422);
            }
            $otp->is_verified = true;
            $otp->save();
            return response(['status'=> true, 'message'=> 'OTP Verified Successfully'],200);
        } else {
            return response(['status'=> false, 'message'=> 'Invalid Otp'],422);
        }

        } catch (Exception $e) {
            return response(['status' => false, 'message' => $e->getMessage()]);
        }
    }

    public function updateId(UserIdResetRequest $request){

        try {
            $otp = Otp::where("".$request->user_id_type, $request->user_id)
            ->where("is_verified", true)
            ->first();
            if(!$otp){
                return response(['status' => false, 'message' => "Please Complete your verification first"]);
            }else{
                $otp->delete();
            }

            // now set user id
            $user = User::where("".$request->user_id_type, $request->user_id)->first();
            if($user){
                if($request->user_id_type == UserIdTypeEnums::EMAIL){
                $user->email = $request->new_user_id;
                }else {
                    $user->phone = $request->new_user_id;
                }
                $user->save();
                return response(['status' => true, 'message' => ucfirst($request->user_id_type)." updated successfully"]);
            }
            return response(['status' => false, 'message' => "Unable to find user account"]);

        } catch (Exception $e) {
            return response(['status' => false, 'message' => $e->getMessage()]);
        }
    }
}
