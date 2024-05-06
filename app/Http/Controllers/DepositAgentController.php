<?php

namespace App\Http\Controllers;

use App\Http\Requests\DepositAgentRequest;
use App\Services\DepositAgentService;
use Exception;
use Illuminate\Support\Facades\DB;

class DepositAgentController extends Controller
{
    protected $depositAgentService;
    protected $user;
    public function __construct(DepositAgentService $depositAgentService)
    {
        $this->middleware(['auth','Setting','role:admin|super-admin']);
        $this->depositAgentService = $depositAgentService;
        $this->middleware(function ($request,$next){
           $this->user = auth()->user();
           return $next($request);
        });
    }

    public function index()
    {
        $data['page_title'] = "Deposit agent list";
        $data['agents']     = $this->depositAgentService->agentList();
        return view('admin.deposit-agent.index',$data);

    }
    public function create()
    {
        $data['page_title'] = "Add new deposit agent";
        return view('admin.deposit-agent.create',$data);

    }
    public function store(DepositAgentRequest $request)
    {
        try {
            DB::beginTransaction();
            $in = $request->all();
            $this->depositAgentService->store($in);
            DB::commit();
            return redirect()->route('deposit-agent.index')->with('success', 'Deposit Agent successfully created');

        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors($e->getMessage())->withInput();
        }
    }
    public function edit($id)
    {
        $data['page_title'] = "Deposit agent edit";
        $data['agent'] = $this->depositAgentService->agentGet($id);
        return view('admin.deposit-agent.edit',$data);
    }
    public function update(DepositAgentRequest $request,$id)
    {
        try {
            DB::beginTransaction();
            $in = $request->all();
            $this->depositAgentService->update($in,$id);
            DB::commit();
            return redirect()->route('deposit-agent.index')->with('success', 'Deposit Agent successfully update');

        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors($e->getMessage())->withInput();
        }
    }
    public function destroy($id)
    {
       $this->depositAgentService->delete($id);
        return redirect()->route('deposit-agent.index')->with('success', 'Deposit Agent successfully delete');

    }
}
