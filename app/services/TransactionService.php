<?php
namespace App\Services;


use App\Enums\TransactionStatusEnums;
use App\Enums\TransactionTypeEnums;
use App\Models\Account;
use App\Models\Transaction;
use App\Models\TransactionPin;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class TransactionService{



    public function store(array $data)
    {

        if (Hash::check($data['pay_pin'],auth()->user()->pay_pin)){

            $trans = Transaction::create($data);// create transaction
            $this->senderAccountUpdate($trans);// update account
            $pin = $this->transactionPin($trans);// make for transaction pin
            $trans->transaction_pin = $pin;
            $returnData = [
                'transaction_type' => $trans->transaction_type,
                'asset_type' => $trans->asset_type,
                'amount' => $trans->amount,
                'note' => $trans->note,
                'trans_id' => $trans->trans_id,
                'transaction_pin' => $pin,
                'receiver_pay_id' => $data['receiver_pay_id'],
                'sender_pay_id'   => auth()->user()->pay_id,

            ];
            return ['status' => true, 'message' => 'Successfully Data Save!','data' => $returnData];
        }else{
            return ['status' => false, 'message' => 'Wrong Pin Enter'];
        }

    }

    public function checkSederBalance($data)
    {
        $baseQuery = [
            'asset_type' => $data['asset_type'],
            'user_id' => Auth::user()->id,
        ];
        $account = Account::where($baseQuery)->first();
        if (!is_numeric($data['amount']) || $data['amount'] <= 0) {
            return ['status' => false, 'message' => 'Amount must be greater than 0'];
        } elseif ($account->balance < $data['amount']) {
            return ['status' => false, 'message' => 'Insufficient balance'];
        } else {
            return ['status' => true, 'message' => 'Sufficient balance'];
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
           'trans_id' => $trans->trans_id,
           'pin'=> rand(10000,99999),
           'expiration_time' => $validDate,
           'attempts' => $attempts,
        ]);
        return $tp->pin;
    }

    public function unlockMoney($data)
    {
        $pinForCheck = TransactionPin::where('trans_id',$data['trans_id'])->first();
        if ($pinForCheck->pin == $data['pin']){
            $baseQuery = [
                'trans_id' => $data['trans_id'],
                'pin' => $data['pin'],
            ];
            $pinDetails = TransactionPin::where($baseQuery)->first();
            if ($pinDetails){
                $recived = $this->recieved($pinDetails);
                $receiverPayId = $this->findReceiver($recived->receiver_id);
                $returnData = [
                    'transaction_type' => $recived->transaction_type,
                    'asset_type' => $recived->asset_type,
                    'amount' => $recived->amount,
                    'trans_id' => $recived->trans_id,
                    'status'   => $recived->status,
                    'receiver_pay_id' => $receiverPayId,
                    'sender_pay_id'   => auth()->user()->pay_id,
                ];
                $pinForCheck->delete(); // delete the transaction pin if attempt is 0;
                return ['status' => true ,'message' => "Successfully Received Amount!",'data' => $returnData];
            }
        }else{
            $pinForCheck->attempts -= 1;
            $pinForCheck->save();
            if ($pinForCheck->attempts <= 0) {

                $this->refund($pinForCheck); // update sender account
                $pinForCheck->delete(); // delete the transaction pin if attempt is 0;
                return ['status' => false ,'message' => "Attempt failed your limit. transaction refund the sender!"];
            }else{
                return ['status' => false ,'message' => "Attempt failed. You have {$pinForCheck->attempts} attempts left."];

            }

        }

    }

    public function refund($pinForCheck)
    {
        $transaction = Transaction::find($pinForCheck->transaction_id);
        $transaction->status = TransactionStatusEnums::REFUND;
        $transaction->transaction_type = TransactionTypeEnums::REFUND;

        // account update
        $baseQuery = [
            'user_id' => $transaction->sender_id,
            'asset_type' => $transaction->asset_type,
        ];
        $account = Account::where($baseQuery)->first();
        $account->balance += $transaction->amount;
        $account->save();
        $transaction->save();
        return $transaction;

    }
    public function recieved($pinDetails)
    {
        $transaction = Transaction::findOrFail($pinDetails->transaction_id);
        $transaction->status = TransactionStatusEnums::CLAIMED;
        $transaction->transaction_type = TransactionTypeEnums::RECEIVED;

        // account update
        $baseQuery = [
            'user_id' => $transaction->receiver_id,
            'asset_type' => $transaction->asset_type,
        ];
        $account = Account::where($baseQuery)->first();
        $account->balance += $transaction->amount;
        $account->save();
        $transaction->save();
        return $transaction;

    }

    public function findReceiver($receiverId)
    {
        return User::findOrFail($receiverId)->pay_id;

    }
}
?>
