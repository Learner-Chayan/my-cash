<?php

namespace App\Services;


use App\Enums\AdsTypeEnums;
use App\Enums\AssetStatus;
use App\Enums\PermissionStatusEnums;
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

           if(!$asset_info){
                return response(["status" => false, "message" => "Price not set yet."], 422);
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
                    "unit_price" => $asset_info->price,
                    "highest_price" => $asset_info->highest_price,
                    "sell_price" => $request->sell_price,
                    "price_type" => $request->price_type,
                    "total_amount" => $request->total_amount,
                    "order_limit_min" => $request->order_limit_min,
                    "order_limit_max" => $request->order_limit_max,
                    "date" => $date,
           ];

           $ad = Ad::create($data);
           Ad_Backup::create($data);

           if ($request->image) {
                $ad->clearMediaCollection('ads');
                $ad->addMediaFromRequest('image')->toMediaCollection('ads');
            }

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