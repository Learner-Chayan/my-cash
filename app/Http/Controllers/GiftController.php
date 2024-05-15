<?php

namespace App\Http\Controllers;

use App\Http\Requests\GiftRequest;
use App\Services\GiftService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GiftController extends Controller
{
    protected $giftService;
    public function __construct(GiftService $giftService)
    {
        $this->middleware(['auth','Setting','role:admin|super-admin']);
        $this->giftService = $giftService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['page_title'] = "Gift Post List";
        $data['gifts']      = $this->giftService->index();
        return view('admin.gift.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['page_title'] = "Add New Gift Post";
        return view('admin.gift.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'identifier' => 'required',
            'asset_type' => 'required',
            'gift_type' => 'required',
            'amount' => 'required|numeric',
            'image' => 'image|mimes:png,jpg,webp,svg,jpeg'
        ]);


        try {
            DB::beginTransaction();
            $in = $request->except('_token');
            $this->giftService->store($in);
            DB::commit();
            return redirect()->route('gift.index')->with('success', 'Successfully Saved!');

        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data['page_title'] = "Gift Post Details";
        $data['gift']       = $this->giftService->get($id);
        return view('admin.gift.show',$data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data['page_title'] = "Edit Gift Post ";
        $data['gift']       = $this->giftService->get($id);
        return view('admin.gift.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(GiftRequest $request, string $id)
    {
        try {
            DB::beginTransaction();
            $in = $request->except('_token');
            $this->giftService->update($in,$id);
            DB::commit();
            return redirect()->route('gift.index')->with('success', 'Successfully Update!');

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
        $this->giftService->destroy($id);
        return redirect()->route('gift.index')->with('success','Successfully Delete!');
    }
}
