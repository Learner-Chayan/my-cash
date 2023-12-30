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
        session()->flash('success','Asset created successfully');
        return response()->json($test);


    }
    public function edit($id)
    {
       $asset = $this->assetService->getAsset($id);
       return response()->json($asset);
    }

    public function update(AssetRequest $request)
    {
        $id = $request->asset_id;
        $in   = $request->except('asset_id');
        $test = $this->assetService->update($in,$id);
        session()->flash('success','Asset Update successfully');
        return response()->json($test);


    }

}
