<?php

namespace App\Http\Controllers;

use App\Enums\TransactionStatusEnums;
use App\Services\TransactionService;
use App\Services\UserService;
use Illuminate\Http\Request;

class SendController extends Controller
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
    public function index($type, $value)
    {
        $data = [
            'type' => $type,
            'value' => $value,
        ];
        return $this->userService->getUser($data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $valid = $this->validate($request,[
            'sender_id' => 'required|exists:users,id',
            'receiver_id' => 'required|exists:users,id',
            'transaction_type' => 'required',
            'amount' => 'required',
        ]);
        if (!$valid) {
    //            return redirect()->withErrors($valid->errors());
            return response()->json(['errors' => $valid->errors()->all()]);
        }
        $in = $request->except('_token');
        $in['trans_id'] = uniqid();
        $in['status'] = TransactionStatusEnums::PENDING;
        $test = $this->transactionService->store($in);
        return $test;

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
