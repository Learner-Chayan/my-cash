<?php 

namespace App\Services;
use App\Enums\TransactionStatusEnums;
use App\Models\Transaction;
use Exception;

class TransactionHistoryService {

    public function list()
    {
        try {
            $user = auth()->user();
            // $transactions =  Transaction::with(['sender' => function($query){
            //     $query->select('id','name', 'pay_id');
            // }])
            // ->with(['receiver' => function($query){
            //     $query->select('id','name', 'pay_id');
            // }])
            // ->where('sender_id', $user->id)->orWhere('receiver_id', $user->id)->get();

            $transactions =  Transaction::with('sender')
                ->with('receiver')
                ->where('sender_id', $user->id)
                ->orWhere('receiver_id', $user->id)->get();

           return $transactions;

        } catch (Exception $e) {
            return response(["status" => false, "message" => $e->getMessage()], 422);
        }
    }

    
    public function receives()
    {
        try {
            $user = auth()->user();
            $transactions =  Transaction::with('sender')
                ->with('receiver')
                ->where('receiver_id', $user->id)
                ->where('status', TransactionStatusEnums::CLAIMED)
                ->get();
           return $transactions;

        } catch (Exception $e) {
            return response(["status" => false, "message" => $e->getMessage()], 422);
        }
    }

    public function sends()
    {
        try {
            $user = auth()->user();
            $transactions =  Transaction::with('sender')
                ->with('receiver')
                ->where('sender_id', $user->id)
                //->where('status', TransactionStatusEnums::CLAIMED)
                ->get();
           return $transactions;

        } catch (Exception $e) {
            return response(["status" => false, "message" => $e->getMessage()], 422);
        }
    }
}