<?php 

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Resources\TransactionHistoryResource;
use App\Services\TransactionHistoryService;
use Illuminate\Http\Request;


class TransactionHistoryController extends Controller
{
    private  TransactionHistoryService $transactionHistoryService;

    public  function __construct(TransactionHistoryService $transactionHistoryService) {
       $this->transactionHistoryService = $transactionHistoryService;
    }

    public function list(Request $request)
    {
        try{
            return TransactionHistoryResource::collection($this->transactionHistoryService->list($request));
        }catch(\Exception $e) {
            return response([ "status" => false, "message" => $e->getMessage()], 422);
        }
    }

    public function receives(Request $request)
    {
        try{
            return TransactionHistoryResource::collection($this->transactionHistoryService->receives($request));
        }catch(\Exception $e) {
            return response([ "status" => false, "message" => $e->getMessage()], 422);
        }
    }

    public function sends(Request $request)
    {
        try{
            return TransactionHistoryResource::collection($this->transactionHistoryService->sends($request));
        }catch(\Exception $e) {
            return response([ "status" => false, "message" => $e->getMessage()], 422);
        }
    }
}