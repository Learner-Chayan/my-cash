<?php

namespace App\Services;


use App\Enums\AdsTypeEnums;
use App\Enums\AssetStatus;
use App\Enums\AssetTypeEnums;
use App\Enums\PermissionStatusEnums;
use App\Enums\PriceTypeEnums;
use App\Enums\Role;
use App\Enums\Status;
use App\Http\Requests\AdsRequest;
use App\Models\Account;
use App\Models\Ad_Backup;
use App\Models\Asset;
use App\Models\AssetPrice;
use App\Models\User;
use App\Models\Ad;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
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
           if($user->getRole() !== Role::AGENT){
                return response(["status" => false, "message" => "Unauthorized!! Only agent can create ads."], 422);
           }

           //check  asset GOLD or Not , should be gold
           if($request->asset_type !== AssetTypeEnums::GOLD){
            return response(["status" => false, "message" => "Only gold ads can be create right now."], 422);
           }

           // price type should be BDT
           if($request->payable_with !== AssetTypeEnums::BDT){
            return response(["status" => false, "message" => "Payable with should be BDT."], 422);
           }

           if(!$asset_info){
                return response(["status" => false, "message" => "Price not set yet."], 422);
            }

            // user price should be in range : between price and highest_price
            if($request->user_price < $asset_info->unit_price || $request->user_price > $asset_info->highest_price){
                return response(["status" => false, "message" => "Price should be between .". $asset_info->pricet." to"
                .$asset_info->highest_price], 422);
            }

            // Should be order_limit_max <= user_price * total_amount
            if($request->order_limit_max > ($request->user_price * $request->total_amount)) {
                return response(["status" => false, "message" => "Order Limit Maximum should be less than .".$request->user_price * $request->total_amount], 422);
            }

            // Check balance sufficient or not
            if($request->ad_type === AdsTypeEnums::SELL) {

                // running ads 
                $running_ads_amount = Ad::where('user_id', $user->id)->where('asset_type',$request->asset_type)
                                     ->where('ad_type', $request->ad_type)
                                     ->sum('total_amount');

                $acc = Account::where('asset_type', $request->asset_type)->where('user_id', $user->id)->first();
                if($acc->balance < ( $request->total_amount + $running_ads_amount)){
                    return response(["status" => false, "message" => "Insufficient Balance"], 422);
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
                    "payable_with" => AssetTypeEnums::BDT,
                    "total_amount" => $request->total_amount,
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

}