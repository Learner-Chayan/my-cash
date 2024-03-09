<?php

namespace App\Http\Controllers\Api;

use App\Enums\AssetTypeEnums;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\Account;
use App\Models\Asset;
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

        $accounts = Account::where('user_id', $user->id)
            ->whereIn('asset_type', [
                AssetTypeEnums::BDT->value,
                AssetTypeEnums::GOLD->value,
                AssetTypeEnums::PLATINUM->value,
                AssetTypeEnums::PALLADIUM->value,
                AssetTypeEnums::SILVER->value
            ])
            ->get()
            ->keyBy('asset_type');

        $wallet = [
            'bdt' => $accounts->get(AssetTypeEnums::BDT->value) ? $accounts->get(AssetTypeEnums::BDT->value)->balance : 0,
            'gold' => $accounts->get(AssetTypeEnums::GOLD->value) ? $accounts->get(AssetTypeEnums::GOLD->value)->balance : 0,
            'platinum' => $accounts->get(AssetTypeEnums::PLATINUM->value) ? $accounts->get(AssetTypeEnums::PLATINUM->value)->balance : 0,
            'palladium' => $accounts->get(AssetTypeEnums::PALLADIUM->value) ? $accounts->get(AssetTypeEnums::PALLADIUM->value)->balance : 0,
            'silver' => $accounts->get( AssetTypeEnums::SILVER->value) ? $accounts->get( AssetTypeEnums::SILVER->value)->balance : 0,
        ];

        return response()->json([
            'status' => true,
            'wallet' => $wallet,
        ], 200);

    }

    //name update user
    public function name(Request $request)
    {
        $valid = $this->validate($request,[
            'name' => 'required|string',
        ]);
        if (!$valid) {
            return response()->json(['errors' => $valid->errors()->all()]); //422 unprocessable content
        }
        $user = auth()->user();
        $user->name = $request->name;
        $user->save();
        return $user;
    }
}
