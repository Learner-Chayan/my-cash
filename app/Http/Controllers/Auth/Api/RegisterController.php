<?php

namespace App\Http\Controllers\Auth\Api;

use App\Enums\AssetTypeEnums;
use App\Enums\Role;
use App\Enums\UserIdTypeEnums;
use App\Http\SmsGateways\Twillio;
use App\Models\Account;
use App\Models\User;
use App\Services\OtpServices;
use Exception;
use App\Http\Requests\SignupRequest;
use App\Http\Requests\AccountVerificationRequest;
use App\Services\OtpService;
use App\Enums\Status;
use App\Models\Otp;

class RegisterController
{
    private OtpService $otpService;
    private Twillio $twillio;
    public function __construct(OtpService $otpService,Twillio $twillio ) {
        $this->otpService = $otpService;
        $this->twillio = $twillio;
    }

    public function register(SignupRequest $request)
    {
        try {

            $user = null;
            if($request->user_id_type == UserIdTypeEnums::EMAIL){
                $user = User::where('email', $request->user_id)->first();
            }else{
                $user = User::where('phone', $request->user_id)->first();
            }

            if(!$user){
                $user = User::create([
                    'name'  => $request->name?? "Anonymous",
                    'phone' => $request->user_id_type == UserIdTypeEnums::PHONE ? $request->user_id : null,
                    'email' => $request->user_id_type == UserIdTypeEnums::EMAIL ? $request->user_id : null,
                    'pay_id' => $this->generatePayId(),
                    'password' => $request->password,
                ]);

                $user->assignRole(Role::REGULAR);
            }

            $otp =  $this->otpService->otp($request->user_id,$request->user_id_type);
            if ($otp) {

                $msg = "Your OTP is : ".$otp;
                if($request->user_id_type == UserIdTypeEnums::PHONE)
                {
                    $this->twillio->send($user->phone, $msg);
                }

                return response(['status' => true,
                'message' => 'Otp send to your '.$request->user_id_type.'. Otp = '.$otp,
                'errors' => []
            ], 201);
            }

            return response(['status' => false, 'message' => 'Something went wrong , contact with us', 'errors'=>[]], 422);
        } catch (Exception $e) {
            return response(['status'=> false, 'message'=> $e->getMessage()],422);
        }
    }

    public function accountVerify(AccountVerificationRequest $request)
    {
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

                // check verified or not
                // $verified = $this->otpService->accountVerify($request);
                // if ($verified) {
                    $user  = User::where($request->user_id_type, $request->user_id)->first();
                    $user->status = Status::ACTIVE;
                    $user->save();

                    $this->createdAccount($user->id);

                    return response(['status'=> true, 'message'=> 'Account Verified Successfully'],200);
            } else {
                return response(['status'=> false, 'message'=> 'Invalid Otp'],422);
            }
        } catch (Exception $e) {
            return response(['status'=> false, 'message'=> $e->getMessage()],422);
        }
    }

    public function createdAccount($user_id){

       foreach(AssetTypeEnums::cases() as $statusCase){
           Account::create([
               'user_id' => $user_id,
               'asset_type' => $statusCase->value,
               'balance' => 0.00,

           ]);
       }

    }

    public function generatePayId() {
        // Get current timestamp
        $timestamp = microtime(true);

        // Convert timestamp to a string
        $timestampStr = strval($timestamp);

        // Extract the decimal part of the timestamp and remove the dot
        $decimalPart = substr(str_replace('.', '', $timestampStr - floor($timestampStr)), 0, 6);

        // Generate a random number
        $random = mt_rand(1000, 9999);

        // Concatenate timestamp and random number
        $uniqueId = $decimalPart . $random;

        return $uniqueId;
    }

}
