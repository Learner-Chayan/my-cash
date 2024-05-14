<?php

namespace App\Http\Controllers\Api;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Gift;
use App\Http\Resources\GiftResource;
use App\Http\Controllers\Controller;

class GiftController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $gifts=  Gift::latest()->get();
            return GiftResource::collection($gifts);
        }catch(Exception $e) {
            return response([ "status" => false, "message" => $e->getMessage()], 422);
        }
    }

}
