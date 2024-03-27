<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\AdsTransactionService;
use Illuminate\Http\Request;

class AdsTransactionController extends Controller
{
    private  AdsTransactionService $adsTransactionService;

    public  function __construct(AdsTransactionService $adsTransactionService) {
       $this->$adsTransactionService = $adsTransactionService;
    }

    public function list(Request $request)
    {
        try{
            //return AdsTransactionResource::collection($this-$adsTransactionService->list($request));
        }catch(\Exception $e) {
            return response([ "status" => false, "message" => $e->getMessage()], 422);
        }
    }
}
