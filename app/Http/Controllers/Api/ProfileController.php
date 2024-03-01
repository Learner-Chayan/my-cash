<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use App\Models\Wallet;

class ProfileController extends Controller
{
    public function payPin()
    {
        $user = Auth::user();
        if ($user->pay_pin == null){
            return new JsonResponse([
                'status'=> false,
                'message'=> "Please Insert Pay Pin!",
            ], 400);
        }else{
            return new JsonResponse([
                'status'=> true,
                'message'=> "Already have pay pin!",
            ], 200);
        }

    }
    public function payPinStore(Request $request)
    {
        $valid = $this->validate($request,[
            'pay_pin' => [
                'required',
                'numeric',
                'regex:/^\d{5,}$/',
            ],
        ]);

        if (!$valid) {
            return response(['status' => false, 'message' => 'Validation error'], 400);
        }
        $in   = $request->input('pay_pin');
        $user = auth()->user();
        $user->pay_pin = bcrypt($in);
        $user->save();
        return response(['status' => true,'message'=> 'Successfully Saved!'],200);

    }

    public function index ()
    {
        $user = Auth::user();
        //return new UserResource($user);

        return new JsonResponse([
            'status'=> true,
            'user'=> new UserResource($user),
        ], 200);
    }

    public function changePassword (Request $request) {
        $user = Auth::user();
    }

    public function wallet(){

        $user = Auth::user();
        $wallet = Wallet::where('user_id', $user->id)->first();
        if($wallet) {
            return new JsonResponse([
                'status'=> true,
                'wallet' => [
                    'bdt' => $wallet->bdt,
                    'gold' =>  $wallet->gold,
                    'platinium' =>  $wallet->platinium,
                    'palladium' =>  $wallet->palladium,
                    'silver' =>  $wallet->silver,
                ]
            ], 200);
        }

        return new JsonResponse([
            'status'=> true,
            'wallet' => [
                'bdt' => 0.00,
                'gold' =>  0.00,
                'platinium' =>  0.00,
                'palladium' =>  0.00,
                'silver' =>  0.00,
            ]
        ], 200);
    }
}
