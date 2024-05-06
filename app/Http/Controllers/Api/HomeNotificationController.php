<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\HomeNotificationResource;
use Exception;
use Illuminate\Http\Request;
use App\Models\HomeNotification;


class HomeNotificationController extends Controller
{


    public function list(Request $request)
    {
        try{
            $notifications = HomeNotification::with('media')->get();
            return HomeNotificationResource::collection($notifications);
        }catch(Exception $e) {
            return response([ "status" => false, "message" => $e->getMessage()], 422);
        }
    }

}
