<?php

namespace App\Http\Controllers;

use App\Http\Requests\AssetRequest;
use App\Services\AssetService;
use Illuminate\Http\Request;

class AssetController extends Controller
{
    protected $assetService;
    public function __construct(AssetService $assetService)
    {
        $this->middleware(['auth','Setting','role:super-admin|admin']);
        $this->assetService = $assetService;
    }

    public function index()
    {
        $data['page_title'] = "Asset list";
        $data['assets'] = $this->assetService->index();
        return view('admin.dashboard.asset',$data);
    }
    public function store(AssetRequest $request)
    {
        $in   = $request->all();
        $test = $this->assetService->store($in);
        dd($test);
        session()->flash('success','Asset created successfully');
        return redirect()->back();

    }
    public function edit($id)
    {
       $asset = $this->assetService->getAsset($id);
       return response()->json($asset);
    }


}
