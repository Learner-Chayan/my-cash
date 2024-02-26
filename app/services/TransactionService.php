<?php
namespace App\Services;


use App\Models\Account;
use App\Models\Transaction;

class TransactionService{



    public function store(array $data)
    {
        $trans = [
            'sender_id' => $data['sender_id'],
            'receiver_id' => $data['receiver_id'],
            'transaction_type' => $data['transaction_type'],
            'amount' => $data['amount'],
//            'status' => $data['status'],
        ];
        $trans = Transaction::create($trans);
//        $test = $this->updateAccount($trans);
        return $trans;

    }

    public function updateAccount($trans)
    {
        $baseQuery = [
            'asset_type' => $trans->transaction_type,
            'user_id' => $trans->sender_id,
        ];
        return $baseQuery;
        $account = Account::where('asset_type',$trans->transaction_type);
    }

}
?>
