<?php

namespace App\Http\Controllers;

use App\Http\Requests\AssetPriceRequest;
use App\Services\AssetPriceService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AssetPriceController extends Controller
{
    protected $assetPriceService;
    public function __construct(AssetPriceService $assetPriceService)
    {
        $this->middleware(['auth','Setting','role:admin|super-admin']);
        $this->assetPriceService = $assetPriceService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['page_title'] = "Asset Price List";
        $data['prices'] = $this->assetPriceService->index();
        return view('admin.asset.price-index',$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['page_title'] = "Add New Asset Price";
        return view('admin.asset.price-create',$data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AssetPriceRequest $request)
    {
        try {
            DB::beginTransaction();
            $in = $request->except('_token');
            $this->assetPriceService->store($in);
            DB::commit();
            return redirect()->route('asset-price.index')->with('success', 'Successfully Save');

        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors($e->getMessage())->withInput();
        }
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
        $data['page_title'] = "Asset Price List";
        $data['price'] = $this->assetPriceService->get($id);
        return view('admin.asset.price-edit',$data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            DB::beginTransaction();
            $in = $request->except('_token');
            $this->assetPriceService->update($in,$id);
            DB::commit();
            return redirect()->route('asset-price.index')->with('success', 'Successfully Save');

        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors($e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->assetPriceService->destroy($id);
        return redirect()->back()->with('success', 'Successfully Delete');
    }
}
