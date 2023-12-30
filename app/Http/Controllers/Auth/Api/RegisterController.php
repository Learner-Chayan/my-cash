<?php

namespace App\Http\Controllers\Auth\Api;

use App\Http\Controllers\BaseController as BaseController;
use App\Models\User;
use App\Services\OtpServices;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\SignupRequest;
use App\Http\Requests\AccountVerificationRequest;
use App\Services\OtpService;
use App\Enums\Status;
use App\Models\Otp;

class RegisterController
{
    private OtpService $otpService;
    public function __construct(OtpService $otpService) {
        $this->otpService = $otpService;
    }

    public function register(SignupRequest $request)
    {
        try {
            $user = User::create([
                'name'  => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'password' => $request->password,
            ]);

            $otp =  $this->otpService->otp($user->phone);
            if ($otp) {
                return response(['status' => true, 'message' => 'Otp send to your phone. Otp = '.Otp::where("phone", $user->phone)->first()->code], 201);
            }

            return response(['status' => false, 'message' => 'Something went wrong , contact with us'], 422);
        } catch (Exception $e) {
            return response(['status'=> false, 'message'=> $e->getMessage()],422);
        }
    }

    public function accountVerify(AccountVerificationRequest $request)
    {
        try {
            $verified = $this->otpService->accountVerify($request);
            if ($verified) {

                $user  = User::where('phone', $request->phone)->first();
                $user->status = Status::ACTIVE;
                $user->save();

                return response(['status'=> true, 'message'=> 'Account Verified Successfully'],200);
            } else {
                return response(['status'=> false, 'message'=> 'Invalid Otp'],422);
            }
        } catch (Exception $e) {
            return response(['status'=> false, 'message'=> $e->getMessage()],422);
        }
    }
}
