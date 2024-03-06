<?php 

namespace App\Services;
use App\Models\Transaction;
use Exception;

class TransactionHistoryService {

    public function list()
    {
        try {
            $user = auth()->user();
            $transactions =  Transaction::with(['sender' => function($query){
                $query->select('id','name', 'pay_id');
            }])
            ->with(['receiver' => function($query){
                $query->select('id','name', 'pay_id');
            }])
            ->where('sender_id', $user->id)->orWhere('receiver_id', $user->id)->get();
            foreach ($transactions as $transaction) {
                dd($transaction);
            }
        } catch (Exception $e) {
            //throw $th;
        }
    }
}