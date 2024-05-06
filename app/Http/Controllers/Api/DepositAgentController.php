<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\DepositAgentResource;
use Exception;
use Illuminate\Http\Request;
use App\Models\DepositAgent;


class DepositAgentController extends Controller
{


    public function list(Request $request)
    {
        try{
            $agents = DepositAgent::all();
            return DepositAgentResource::collection($agents);
        }catch(Exception $e) {
            return response([ "status" => false, "message" => $e->getMessage()], 422);
        }
    }

}
