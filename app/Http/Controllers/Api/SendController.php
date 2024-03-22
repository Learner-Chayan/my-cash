<?php

namespace App\Http\Controllers\Api;

use App\Enums\TransactionStatusEnums;
use App\Enums\TransactionTypeEnums;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\User;
use App\Services\TransactionService;
use Exception;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Requests\SendRequest;

class SendController extends controller
{
    protected $userService;
    protected $transactionService;
    public function __construct(UserService $userService, TransactionService $transactionService)
    {
        $this->middleware(['auth','Setting',]);
        $this->userService = $userService;
        $this->transactionService = $transactionService;

    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $request->validate([
            'type' => 'required',
            'value' => 'required'
        ]);

        $in = $request->except('_token');
        $user = $this->userService->getUser($in);
        if (!$user['status']) {
            return response(['status' => false, 'message' => $user['message']], 404);
        }else{

            return response(['status' => true, 'message' => $user['message'],'data' => $user['data']], 200);

        }


    }

    /**
     * Show the form for creating a new resource.
     */
    public function checkBalance(Request $request)
    {
        $valid = $this->validate($request,[
            'asset_type' => 'required|exists:accounts,asset_type',
            'amount' => 'required',
        ]);
        if (!$valid) {
            return response()->json(['errors' => $valid->errors()->all()]);
        }
        $in = $request->except('_token');
        $balanceCheck = $this->transactionService->checkSederBalance($in);
        if (!$balanceCheck['status']) {
            return response(['status' => false, 'message' => $balanceCheck['message']], 400);
        }else{

            return response(['status' => true, 'message' => $balanceCheck['message']], 200);

        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SendRequest $request)
    {

        try {
            $in = $request->all();
            // Check sender balance
            $balanceCheck = $this->transactionService->checkSederBalance($in);
            if (!$balanceCheck['status']) {
                return response(['status' => false, 'message' => $balanceCheck['message']], 400);
            }
            if (strcmp($request['pay_pin'], auth()->user()->pay_pin) !== 0){
                return response(['status' => false, 'message' => "Wrong pay pin !!"], 400);
            }
    
            $receiver = $this->userService->getPayIdUser($request->receiver_pay_id);
            $in['trans_id']    = $this->generateUniqueTransactionID();
            $in['sender_id']   = auth()->user()->id;
            $in['receiver_id'] = $receiver['data']['id'];
            return $this->transactionService->store($in);
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function unlockSendMoney(Request $request)
    {
        $valid = $this->validate($request,[
            'trans_id' => 'required|exists:transaction_pins,trans_id',
            'pin' => 'required',
//            'pin' => 'required|exists:transaction_pins,pin',
        ]);
        if (!$valid) {
            return response()->json(['errors' => $valid->errors()->all()]); //422 unprocessable content
        }

        //Check the receiver id & trans_id matched or not 
        $user = auth()->user();
        $transaction = Transaction::where(['user_id' => $user->id, 'transaction_type'=> TransactionTypeEnums::RECEIVED , 'trans_id' => $request->trans_id])->first();
        if(!$transaction){
            return response(['status' => false, 'message' => "Unauthorized !! Invalid Request"], 401); 
        }

        $in = $request->except('_token');
        $unlock = $this->transactionService->unlockMoney($in);
        if (!$unlock['status']) {
            return response(['status' => false, 'message' => $unlock['message']], 400);
        }else{
            return response(['status' => true, 'message' => $unlock['message'],'data' => $unlock['data']], 200);
        }
    }

    function generateUniqueTransactionID() {
        $unique = false;
        $transactionID = '';

        while (!$unique) {
            // Generate random string
            $randomString = strtoupper(Str::random(6)); // 3 random letters
            $randomNumbers = rand(100, 999); // 3 random numbers

            // Combine them
            $transactionID = $randomNumbers . $randomString;

            // Check if it exists in the database (assuming your model is called Transaction)
            $exists = Transaction::where('trans_id', $transactionID)->exists();

            if (!$exists) {
                $unique = true;
            }
        }

        return $transactionID;
    }

}
