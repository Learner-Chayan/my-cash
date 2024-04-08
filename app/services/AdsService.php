<?php

namespace App\Services;


use App\Enums\AdsTypeEnums;
use App\Enums\AssetStatus;
use App\Enums\AssetTypeEnums;
use App\Enums\DeleteStatusEnums;
use App\Enums\PermissionStatusEnums;
use App\Enums\PriceTypeEnums;
use App\Enums\Role;
use App\Enums\Status;
use App\Enums\VisibilityStatusEnums;
use App\Http\Requests\AdsRequest;
use App\Models\Account;
use App\Models\Ad_Backup;
use App\Models\AdTransaction;
use App\Models\Asset;
use App\Models\AssetPrice;
use App\Models\User;
use App\Models\Ad;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Exception;

class AdsService
{

    public function list(Request $request)
    {
        try {
            $user = auth()->user();
            $requests = $request->all();

            $ads =  Ad::where('permission_status', PermissionStatusEnums::APPROVED)
                ->where('user_id','!=', $user->id)
                ->where(function($query) use ($requests) {
                    if(isset($requests['start_date']) && isset($requests['end_date'])){
                        $start_date =  date('Y-m-d', strtotime($requests['start_date']));
                        $end_date   = date('Y-m-d', strtotime($requests['end_date']));
                        $query->whereDate('date' , '>=' , $start_date)->whereDate('date', '<=' , $end_date);
                    }else {
                        $today = Carbon::now();
                        $start_date = date('Y-m-d', strtotime($today->subDays(7)->toDateString()));
                        $end_date   = date('Y-m-d');
                        $query->whereDate('date' , '>=' , $start_date)->whereDate('date', '<=' , $end_date);
                    }
                })
                ->orderBy('id', 'DESC')
                ->get();

           return $ads;

        } catch (Exception $e) {
            return response(["status" => false, "message" => $e->getMessage()], 422);
        }
    }

    public function userAdslist(Request $request)
    {
        try {
            $user = auth()->user();
            $requests = $request->all();

            $ads =  Ad::where('user_id', $user->id)
                //->where('permission_status', PermissionStatusEnums::APPROVED)
                ->where(function($query) use ($requests) {
                    if(isset($requests['start_date']) && isset($requests['end_date'])){
                        $start_date =  date('Y-m-d', strtotime($requests['start_date']));
                        $end_date   = date('Y-m-d', strtotime($requests['end_date']));
                        $query->whereDate('date' , '>=' , $start_date)->whereDate('date', '<=' , $end_date);
                    }else {
                        $today = Carbon::now();
                        $start_date = date('Y-m-d', strtotime($today->subDays(7)->toDateString()));
                        $end_date   = date('Y-m-d');
                        $query->whereDate('date' , '>=' , $start_date)->whereDate('date', '<=' , $end_date);
                    }
                })
                ->orderBy('id', 'DESC')
                ->get();

           return $ads;

        } catch (Exception $e) {
            return response(["status" => false, "message" => $e->getMessage()], 422);
        }
    }

    public function store(AdsRequest $request) {
        try {
           $user = auth()->user();
           $asset_info = AssetPrice::where('asset_type', $request->asset_type)->latest()->first();
           $unique_num = substr(md5(time()), 0, 10);
           $date = Date("Y-m-d H:i:s");

           // user Should be agent type 
           if($user->getUserRoleAttribute() !== Role::AGENT){
                return response(["status" => false, "message" => "Unauthorized!! Only agent can create ads."], 422);
           }


           //check  asset GOLD or Not , should be gold
           if($request->asset_type !== AssetTypeEnums::GOLD->value){
            return response(["status" => false, "message" => "Only gold ads can be create right now."], 422);
           }

           // price type should be BDT
           if($request->payable_with !== AssetTypeEnums::BDT->value){
            return response(["status" => false, "message" => "Payable with should be BDT."], 422);
           }

           if(!$asset_info){
                return response(["status" => false, "message" => "Price not set yet."], 422);
            }

            // user price should be in range : between price and highest_price
            if($request->user_price < $asset_info->unit_price || $request->user_price > $asset_info->highest_price){
                return response(["status" => false, "message" => "Price should be between .". $asset_info->price." to"
                .$asset_info->highest_price], 422);
            }

            // Should be order_limit_max <= user_price * advertise_total_amount
            if($request->order_limit_max > ($request->user_price * $request->advertise_total_amount)) {
                return response(["status" => false, "message" => "Order Limit Maximum should be less than .".$request->user_price * $request->advertise_total_amount], 422);
            }

            // Check balance sufficient or not
            if($request->ad_type === AdsTypeEnums::SELL) {

                // running ads 
                $running_ads_amount = Ad::where('user_id', $user->id)->where('asset_type',$request->asset_type)
                                     ->where('ad_type', $request->ad_type)
                                     ->sum('advertise_total_amount');

                $acc = Account::where('asset_type', $request->asset_type)->where('user_id', $user->id)->first();
                if($acc->balance < ( $request->advertise_total_amount + $running_ads_amount)){
                    return response(["status" => false, "message" => "Insufficient Balance . Check previous ads and current balance"], 422);
                }
            }

            if($request->ad_type === AdsTypeEnums::BUY) {

                // running ads 
                $running_ads_amount = Ad::where('user_id', $user->id)->where('asset_type',$request->asset_type)
                                     ->where('ad_type', $request->ad_type)
                                     ->sum('payable_with');

                $acc = Account::where('asset_type', $request->asset_type)->where('user_id', $user->id)->first();
                if($acc->balance < ( $request->advertise_total_amount + $running_ads_amount)){
                    return response(["status" => false, "message" => "Insufficient Balance . Check previous ads and current balance"], 422);
                }
            }


           $data = [
                    "user_id" => $user->id,
                    "ads_unique_num" => $unique_num,
                    "ad_type" => $request->ad_type,
                    "asset_type" => $request->asset_type,
                    "unit_price_floor" => $asset_info->price,
                    "unit_price_ceil" => $asset_info->highest_price,
                    "price_updated_at" => $asset_info->date,
                    "user_price" => $request->user_price,
                    "price_type" => $request->price_type,
                    "payable_with" => AssetTypeEnums::BDT->value,
                    "advertise_total_amount" => $request->advertise_total_amount,
                    "order_limit_min" => $request->order_limit_min,
                    "order_limit_max" => $request->order_limit_max,
                    "date" => $date,
           ];

           $ad = Ad::create($data);
           Ad_Backup::create($data);

           return response(["status" => true, "message" => "Ads Created Successfully"]);


        } catch (Exception $e) {
            return response(["status" => false, "message" => $e->getMessage()], 422);
        }
    }

    public function details(Ad $ad) {
        try {
            return $ad;
        } catch (Exception $e) {
            return response(["status" => false, "message" => $e->getMessage()], 422);
        }
    }


    public function buy(Ad $ad, Request $request) {
        try {
           // validate request 
           $request->validate([
            'payable_amount' => 'required|numeric' //  BDT 
           ]);

           // Checking Part
           $user = auth()->user(); //buyer
           $buyers_account = Account::where('user_id', $user->id)->where('asset_type', $ad->payable_with)->first();
           $sellers_account = Account::where('user_id', $ad->user_id)->where('asset_type', $ad->asset_type)->first();

           // how many asset will get the buyer 
           // if user_price (unit_price) = 10 BDT (with_payable)
           // then if payable_amount 200 , then 200 / 10 = 20 

           $receivable_amount  =  $request->payable_amount / $ad->user_price;

           if($ad->user_id == $user->id){
            return response(["status" => false, "message" => "Failed !! Self ads can not be buy."], 422);
           }else if($ad->permission_status != PermissionStatusEnums::APPROVED || $ad->visibility_status != VisibilityStatusEnums::ENABLE
           || $ad->delete_status != DeleteStatusEnums::NOT_DELETED){
                return response(["status" => false, "message" => "Failed !! The ad is not approved or invisible or deleted."], 422);
           }else if ($ad->ad_type != AdsTypeEnums::SELL){
                return response(["status" => false, "message" => "Failed !! Only sell type ads can be buy."], 422);
           }else if($request->payable_amount < $ad->order_limit_min){
                return response(["status" => false, "message" => "Failed !! Minimum Order Limit is .". $ad->order_limit_min], 422);
           }else if($request->payable_amount > $ad->order_limit_max){
            return response(["status" => false, "message" => "Failed !! Maximum Order Limit is .". $ad->order_limit_max], 422);
           }else if($sellers_account->balance <  $receivable_amount) {
            return response(["status" => false, "message" => "Failed !! Seller has insufficient balance "], 422);
           }else if( $buyers_account->balance < $request->payable_amount) {
            return response(["status" => false, "message" => "Failed !! Insufficient balance to buy "], 422);
           }

           // if all's are okay then update the informations 
           DB::transaction(function () use ($user,$request, $ad, $buyers_account, $sellers_account,  $receivable_amount) { 
            // reduce buyer's payable_with balance
            $buyers_account->balance =  $buyers_account->balance - $request->payable_amount;
            $buyers_account->save();

            // increase buyer's account ad's asset type
            $buyers_account = Account::where('user_id', $user->id)->where('asset_type', $ad->asset_type)->first();
            $buyers_account->balance = $buyers_account->balance +  $receivable_amount;
            $buyers_account->save();

            // reduce seller's ad asset type balance
            $sellers_account->balance = $sellers_account->balance - $receivable_amount;
            $sellers_account->save();

            // increase seller's payable_with balance
            $sellers_account = Account::where('user_id', $ad->user_id)->where('asset_type', $ad->payable_with)->first();
            $sellers_account->balance = $sellers_account->balance +  $request->payable_amount;
            $sellers_account->save();

            // now update ads information 
            $ad->advertise_total_amount = $ad->advertise_total_amount -  $receivable_amount;
            $ad->save(); 

            // now insert information's to ads_transaction table
            AdTransaction::create([
                'ad_id' => $ad->id,
                'sell_by' => $sellers_account->user_id,
                'purchase_by' => $buyers_account->user_id,
                'payable_asset_type' => $ad->payable_with,
                'payable_amount' => $request->payable_amount,
                'receivable_asset_type' =>$ad->asset_type,
                'receivable_amount' => $receivable_amount,
                'add_trans_id' => substr(md5(time()), 0, 10),
                'date' => Date("Y-m-d H:i:s"),
            ]);
           });

           return response(["status" => true, "message" => 'Success !! Balance transfered to your account. '], 422);

        } catch (Exception $e) {
            DB::rollBack();
            return response(["status" => false, "message" => $e->getMessage()], 422);
        }
    }


    
    public function sell(Ad $ad, Request $request) {
        try {
           // validate request 
           $request->validate([
            'payable_amount' => 'required|numeric' //  BDT  
           ]);

           // Checking Part
           $user = auth()->user(); //buyer
           $buyers_account = Account::where('user_id', $user->id)->where('asset_type', $ad->asset_type)->first();
           $sellers_account = Account::where('user_id', $ad->user_id)->where('asset_type', $ad->payable_with)->first();

           // how many asset will get the buyer 
           // if user_price (unit_price) = 10 BDT (with_payable)
           // then if payable_amount 200 , then 200 / 10 = 20 

           $receivable_amount  =  $request->payable_amount / $ad->user_price;

           if($ad->permission_status != PermissionStatusEnums::APPROVED || $ad->visibility_status != VisibilityStatusEnums::ENABLE
           || $ad->delete_status != DeleteStatusEnums::NOT_DELETED){
                return response(["status" => false, "message" => "Failed !! The ad is not approved or invisible or deleted."], 422);
           }else if ($ad->ad_type != AdsTypeEnums::BUY){
                return response(["status" => false, "message" => "Failed !! Only sell type ads can be buy."], 422);
           }else if($request->payable_amount < $ad->order_limit_min){
                return response(["status" => false, "message" => "Failed !! Minimum Order Limit is .". $ad->order_limit_min], 422);
           }else if($request->payable_amount > $ad->order_limit_max){
            return response(["status" => false, "message" => "Failed !! Maximum Order Limit is .". $ad->order_limit_max], 422);
           }else if($sellers_account->balance < $request->payable_amount) {
            return response(["status" => false, "message" => "Failed !! Seller has insufficient balance "], 422);
           }else if( $buyers_account->balance < $receivable_amount) {
            return response(["status" => false, "message" => "Failed !! Insufficient balance to buy "], 422);
           }

           // if all's are okay then update the informations 
           DB::transaction(function () use ($user,$request, $ad, $buyers_account, $sellers_account,  $receivable_amount) { 
            // reduce buyer's payable_with balance
            $buyers_account->balance =  $buyers_account->balance -  $receivable_amount;
            $buyers_account->save();

            // increase buyer's account ad's asset type
            $buyers_account = Account::where('user_id', $user->id)->where('asset_type', $ad->payable_with)->first();
            $buyers_account->balance = $buyers_account->balance + $request->payable_amount;
            $buyers_account->save();

            // reduce seller's ad asset type balance
            $sellers_account->balance = $sellers_account->balance - $request->payable_amount;
            $sellers_account->save();

            // increase seller's payable_with balance
            $sellers_account = Account::where('user_id', $ad->user_id)->where('asset_type', $ad->asset_type)->first();
            $sellers_account->balance = $sellers_account->balance +  $receivable_amount;
            $sellers_account->save();

            // now update ads information 
            $ad->advertise_total_amount = $ad->advertise_total_amount -  $receivable_amount;
            $ad->save(); 

            // now insert information's to ads_transaction table
            AdTransaction::create([
                'ad_id' => $ad->id,
                'sell_by' => $sellers_account->user_id,
                'purchase_by' => $buyers_account->user_id,
                'payable_asset_type' => $ad->payable_with,
                'payable_amount' => $request->payable_amount,
                'receivable_asset_type' =>$ad->asset_type,
                'receivable_amount' => $receivable_amount,
                'add_trans_id' => substr(md5(time()), 0, 10),
                'date' => Date("Y-m-d H:i:s"),
            ]);
           });

           return response(["status" => true, "message" => 'Success !! Balance transfered to your account. '], 422);

        } catch (Exception $e) {
            DB::rollBack();
            return response(["status" => false, "message" => $e->getMessage()], 422);
        }
    }


}

// for BUY the ads 
//..................
// Checking points
//......................
// Check the add is permitted,not_deleted,visible 
// if ad type is sell, request type should be buy . Same as buy to sell
// amount should be ==> greater than or equal order_limit_min and smaller than or equal order_limit_max
// Check both users balance , [seller balance : GOLD  , buyer balance :  payable with [default BDT]]


// update data for buy
//......................
// Buyer's Account :  Increase GOLD (ad asset_type) balance , decrease payable with balance [BDT]
//Decrease Seller's GOLD (ad asset type) balance , increase payable with [BDT]
//update ads information 
// insert ads_transaction information 


// for SELL by the ads process is totally opposite of BUY ads