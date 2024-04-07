<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdsRequest;
use App\Http\Resources\AdsResource;
use App\Services\AdsService;
use Exception;
use Illuminate\Http\Request;
use App\Models\Ad;

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
        }catch(Exception $e) {
            return response([ "status" => false, "message" => $e->getMessage()], 422);
        }
    }

    public function userAdslist(Request $request)
    {
        try{
            return AdsResource::collection($this->adsService->userAdslist($request));
        }catch(Exception $e) {
            return response([ "status" => false, "message" => $e->getMessage()], 422);
        }
    }

    public function store(AdsRequest $request)
    {
        try{
            return $this->adsService->store($request);
        }catch(Exception $e) {
            return response([ "status" => false, "message" => $e->getMessage()], 422);
        }
    }

    public function details(Ad $ad) {
        try {
            return new AdsResource($this->adsService->details($ad));
        } catch (Exception $e) {
            return response([ "status" => false, "message" => $e->getMessage()], 422);
        }
    }

    public function buy(Ad $ad, Request $request) {
        try {
            return $this->adsService->buy($ad, $request);
        } catch (Exception $e) {
            return response([ "status" => false, "message" => $e->getMessage()], 422);
        }
    }

    public function sell(Ad $ad, Request $request) {
        try {
            return $this->adsService->buy($ad, $request);
        } catch (Exception $e) {
            return response([ "status" => false, "message" => $e->getMessage()], 422);
        }
    }
}
