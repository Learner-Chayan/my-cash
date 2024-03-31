<?php

namespace App\Http\Controllers;

use App\Services\AdsApprovalService;
use Illuminate\Http\Request;

class AdsApprovalController extends Controller
{

    protected $adsApprovalService;
    protected $user;
    public function __construct(AdsApprovalService $adsApprovalService)
    {
        $this->middleware(['auth','Setting','role:admin|super-admin']);
        $this->adsApprovalService = $adsApprovalService;

        $this->middleware(function ($request,$next){
           $this->user = auth()->user();
           return $next($request);
        });
    }
    public function index()
    {
        $data['page_title'] = "P2P Post List";
        $data['ads'] = $this->adsApprovalService->index();
        return view('admin.ads.index',$data);
    }
    public function show($id)
    {
        $data['ad'] = $this->adsApprovalService->get($id);
        $data['page_title'] = $data['ad']->ads_unique_num ." Post Details";
        return view('admin.ads.show',$data);
    }
    public function destroy($id)
    {
        $this->adsApprovalService->changeStatus($id);
        return redirect()->route('ads.index')->with('success', 'Successfully Change');
    }
}
