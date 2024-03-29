<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\AssetService;
use Exception;
use Illuminate\Http\Request;

class AssetsController extends Controller
{
    public AssetService $assetService;

    public function __construct(AssetService $assetService) {
        $this->assetService = $assetService;
    }

    public function goldPrice(){
        try {
            return $this->assetService->goldPrice();
        } catch (Exception $ex) {
            return response(['status'=> false, 'message' => $ex->getMessage()]);
        }
        
    }
}
