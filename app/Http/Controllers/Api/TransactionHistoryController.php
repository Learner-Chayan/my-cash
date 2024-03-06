<?php 

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Services\TransactionHistoryService;


class TransactionHistoryController extends Controller
{
    private  TransactionHistoryService $transactionHistoryService;

    public  function __construct(TransactionHistoryService $transactionHistoryService) {
       $this->transactionHistoryService = $transactionHistoryService;
    }

    public function list()
    {
        return $this->transactionHistoryService->list();
    }
}