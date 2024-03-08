<?php 

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Resources\TransactionHistoryResource;
use App\Services\TransactionHistoryService;


class TransactionHistoryController extends Controller
{
    private  TransactionHistoryService $transactionHistoryService;

    public  function __construct(TransactionHistoryService $transactionHistoryService) {
       $this->transactionHistoryService = $transactionHistoryService;
    }

    public function list()
    {
        try{
            return TransactionHistoryResource::collection($this->transactionHistoryService->list());
        }catch(\Exception $e) {
            return response([ "status" => false, "message" => $e->getMessage()], 422);
        }
    }

    public function receives()
    {
        try{
            return TransactionHistoryResource::collection($this->transactionHistoryService->receives());
        }catch(\Exception $e) {
            return response([ "status" => false, "message" => $e->getMessage()], 422);
        }
    }

    public function sends()
    {
        try{
            return TransactionHistoryResource::collection($this->transactionHistoryService->sends());
        }catch(\Exception $e) {
            return response([ "status" => false, "message" => $e->getMessage()], 422);
        }
    }
}