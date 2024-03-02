<?php

namespace App\Http\Controllers;

use App\Enums\TransactionStatusEnums;
use App\Models\Transaction;
use App\Models\User;
use App\Services\TransactionService;
use Exception;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SendController extends BaseController
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
    public function store(Request $request)
    {
        $valid = $this->validate($request,[
            'receiver_pay_id' => 'required|exists:users,pay_id',
            'asset_type' => 'required',
            'transaction_type' => 'required',
            'amount' => 'required',
        ]);
        if (!$valid) {
            return response()->json(['errors' => $valid->errors()->all()]);
        }
        $in = $request->except('_token');
        // Check sender balance
        $balanceCheck = $this->transactionService->checkSederBalance($in);
        if (!$balanceCheck['status']) {
            return response(['status' => false, 'message' => $balanceCheck['message']], 400);
        }
        $receiver = $this->userService->getPayIdUser($request->receiver_pay_id);

        $in['trans_id']    = $this->generateUniqueTransactionID();
        $in['status']      = TransactionStatusEnums::PENDING;
        $in['sender_id']   = auth()->user()->id;
        $in['receiver_id'] = $receiver['data']['id'];

        $trans = $this->transactionService->store($in);
        if (!$trans['status']) {
            return response(['status' => false, 'message' => $trans['message']], 400);
        }else{

            return response(['status' => true, 'message' => $trans['message'],'data' => $trans['data']], 200);

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
            $randomString = strtoupper(Str::random(3)); // 3 random letters
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
