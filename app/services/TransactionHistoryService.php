<?php 

namespace App\Services;
use App\Enums\TransactionStatusEnums;
use App\Enums\TransactionTypeEnums;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Exception;
use Carbon\Carbon;

class TransactionHistoryService {

    public function list(Request $request)
    {
        try {
            $user = auth()->user();
            $requests = $request->all();

            $transactions =  Transaction::with('model','transactionPin')
                ->where('user_id', $user->id)
                ->where(function($query) use ($requests) {
                    if(isset($requests['start_date']) && isset($requests['end_date'])){
                        $start_date =  date('Y-m-d', strtotime($requests['start_date']));
                        $end_date   = date('Y-m-d', strtotime($requests['end_date']));
                        $query->whereDate('date' , '>=' , $start_date)->whereDate('date', '<=' , $end_date);
                    }else {
                        $today = Carbon::now();
                        $start_date = date('Y-m-d', strtotime($today->subDays(7)->toDateString()));
                        $end_date   = date('Y-m-d');
                        $query->whereDate('date' , '>=' , $start_date)->whereDate('date', '<=' , $end_date);
                    }
                })
                ->get();

           return $transactions;

        } catch (Exception $e) {
            return response(["status" => false, "message" => $e->getMessage()], 422);
        }
    }

    
    public function receives(Request $request)
    {
        try {
            $user = auth()->user();
            $requests = $request->all();
            $transactions =  Transaction::with('model')
                ->where('user_id', $user->id)
                ->where('transaction_type', TransactionTypeEnums::RECEIVED)
                ->where(function($query) use ($requests) {
                    if(isset($requests['start_date']) && isset($requests['end_date'])){
                        $start_date =  date('Y-m-d', strtotime($requests['start_date']));
                        $end_date   = date('Y-m-d', strtotime($requests['end_date']));
                        $query->whereDate('date' , '>=' , $start_date)->whereDate('date', '<=' , $end_date);
                    }else {
                        $today = Carbon::now();
                        $start_date = date('Y-m-d', strtotime($today->subDays(7)->toDateString()));
                        $end_date   = date('Y-m-d');
                        $query->whereDate('date' , '>=' , $start_date)->whereDate('date', '<=' , $end_date);
                    }
                })
                ->get();
           return $transactions;

        } catch (Exception $e) {
            return response(["status" => false, "message" => $e->getMessage()], 422);
        }
    }

    public function sends(Request $request)
    {
        try {
            $user = auth()->user();
            $requests = $request->all();

            $transactions =  Transaction::with('model')
                ->where('user_id', $user->id)
                ->where('transaction_type', TransactionTypeEnums::SEND)
                ->where(function($query) use ($requests) {
                    if(isset($requests['start_date']) && isset($requests['end_date'])){
                        $start_date =  date('Y-m-d', strtotime($requests['start_date']));
                        $end_date   = date('Y-m-d', strtotime($requests['end_date']));
                        $query->whereDate('date' , '>=' , $start_date)->whereDate('date', '<=' , $end_date);
                    }else {
                        $today = Carbon::now();
                        $start_date = date('Y-m-d', strtotime($today->subDays(7)->toDateString()));
                        $end_date   = date('Y-m-d');
                        $query->whereDate('date' , '>=' , $start_date)->whereDate('date', '<=' , $end_date);
                    }
                })
                ->get();
           return $transactions;

        } catch (Exception $e) {
            return response(["status" => false, "message" => $e->getMessage()], 422);
        }
    }
}