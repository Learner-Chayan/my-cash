<?php
namespace App\Services;


use App\Models\Account;
use App\Models\Transaction;
use App\Models\TransactionPin;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class TransactionService{



    public function store(array $data)
    {
        $trans = Transaction::create($data);// create transaction
        $this->senderAccountUpdate($trans);// update account
        $this->transactionPin($trans);// make for transaction pin
        return $trans;

    }

    public function checkSederBalance($data)
    {
        $baseQuery = [
            'asset_type' => $data['asset_type'],
            'user_id' => Auth::user()->id,
        ];
        $account = Account::where($baseQuery)->first();
        if (!is_numeric($data['amount']) || $data['amount'] <= 0){
            return response(['status' => false, 'message' => 'amount must be greater than 0'], 400);
        }
        elseif ($account->balance < $data['amount']){
            return response(['status' => false, 'message' => 'insufficient balance'], 400);
        }else{
            return response(['status' => true, 'message' => 'sufficient balance'], 200);

        }

    }

    public function senderAccountUpdate($trans)
    {
        $baseQuery = [
            'asset_type' => $trans->asset_type,
            'user_id' => $trans->sender_id,
        ];
        $account = Account::where($baseQuery)->first();
        $account->balance -= $trans->amount;
        $account->save();
        return $account;
    }
    public function transactionPin($trans)
    {
        $transId = $trans->id;
        $now = Carbon::now();
        $sevenDaysBefore = $now->addDay(7);
        $validDate = Carbon::parse($sevenDaysBefore)->format('Y-m-d H:i:s');

        $attempts = 3;

        $tp = TransactionPin::create([
           'transaction_id' => $transId,
           'pin'=> rand(000,99999),
           'expiration_time' => $validDate,
           'attemps' => $attempts,
        ]);
        return $tp;
    }

}
?>
