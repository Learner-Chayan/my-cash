<?php

namespace App\Services;


use App\Enums\AssetStatus;
use App\Models\Asset;
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

            $ads =  Ad::where('user_id', $user->id)
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
                ->get();

           return $ads;

        } catch (Exception $e) {
            return response(["status" => false, "message" => $e->getMessage()], 422);
        }
    }

}