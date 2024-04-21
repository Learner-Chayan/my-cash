<?php

namespace App\Http\Controllers\Api;

use App\Enums\AssetTypeEnums;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuthenticationRequest;
use App\Http\Requests\updateImageRequest;
use App\Http\Resources\UserResource;
use App\Models\Account;
use App\Models\Asset;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use App\Models\Wallet;
use App\Models\User;

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
        $user->pay_pin = $in;
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
    public function updateName(Request $request)
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
       
        return response(
            ["status" => true , "data"=> new UserResource($user) , "message" => "Name Updated Successfully"]
        );
    }

    public function updateImage(updateImageRequest $request)
    {
        try {
            $user = User::find(auth()->user()->id);
            if ($request->image) {
                $user->clearMediaCollection('profile');
                $user->addMediaFromRequest('image')->toMediaCollection('profile');
            }
            $user->save();
            return response([
                "status" => true,
                "image"   => $user->image
            ]);
        } catch (\Exception $exception) {
            return response(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }

    public function storeContacts(Request $request){

        try {
  
            $request->validate([
                'contacts' => 'required'
            ]);

            $rows = [];
            $user = auth()->user();

            foreach ($request->contacts as $contact) {
                array_push($rows, [
                    "pay_id" => $user->pay_id,
                    "name" => $contact["name"],
                    "phone" => $contact["phone"],
                ]);
            }

            Contact::insert($rows);

            return response([
                "status" => true,
                "message" => "Success",
            ]);
        } catch (\Throwable $th) {
            return response([
                "status" => false,
                "message" => $th->getMessage()
            ]);
        }
    }

    public function authenticate(AuthenticationRequest $request){
        try {
            $user = User::find(auth()->user()->id);
            if ($request->front_side) {
                $user->clearMediaCollection('frontSide');
                $user->addMediaFromRequest('front_side')->toMediaCollection('frontSide');
            }

            if ($request->back_side) {
                $user->clearMediaCollection('backSide');
                $user->addMediaFromRequest('back_side')->toMediaCollection('backSide');
            }

            if ($request->selfie) {
                $user->clearMediaCollection('selfie');
                $user->addMediaFromRequest('selfie')->toMediaCollection('selfie');
            }


            $user->save();
            return response([
                "status" => true,
                "front_side" => $user->frontSide,
                "back_side" => $user->backSide,
                "selfie" => $user->selfie,
                "message"   => "Authentication request submitted successfully"
            ]);
        } catch (\Exception $exception) {
            return response(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }
}
