<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdsRequest;
use App\Http\Resources\AdsResource;
use App\Services\AdsService;
use Illuminate\Http\Request;

class AdsController extends Controller
{
    private  AdsService $adsService;

    public  function __construct(AdsService $adsService) {
       $this->adsService = $adsService;
    }

    public function list(Request $request)
    {
        try{
            return AdsResource::collection($this->adsService->list($request));
        }catch(\Exception $e) {
            return response([ "status" => false, "message" => $e->getMessage()], 422);
        }
    }

    public function store(AdsRequest $request)
    {
        try{
            return $this->adsService->store($request);
        }catch(\Exception $e) {
            return response([ "status" => false, "message" => $e->getMessage()], 422);
        }
    }
}
