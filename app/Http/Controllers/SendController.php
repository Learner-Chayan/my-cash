<?php

namespace App\Http\Controllers;

use App\Enums\TransactionStatusEnums;
use App\Models\User;
use App\Services\TransactionService;
use Exception;
use App\Services\UserService;
use Illuminate\Http\Request;

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

        $in['trans_id']    = uniqid();
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
        return $unlock;
        if (!$unlock['status']) {
            return response(['status' => false, 'message' => $unlock['message']], 400);
        }else{

            return response(['status' => true, 'message' => $unlock['message'],'data' => $unlock['data']], 200);

        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
