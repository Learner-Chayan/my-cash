<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerRequest;
use App\Models\User;
use App\Services\CustomerService;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class CustomerController extends Controller
{
    protected $customerService;
    public function __construct(CustomerService $customerService)
    {
        $this->middleware(['auth','Setting','role:admin|super-admin']);
        $this->customerService = $customerService;
    }

    public function index($type)
    {
        $types = ['agent', 'regular'];

        if (in_array($type, $types)) {
            $data['page_title'] = ucwords($type)." Customer";
            $data['customers'] = $this->customerService->getCustomer($type);
            return view('admin.customer.index',$data);
        }else{
            return redirect()->back();
        }

    }

    public function edit($id)
    {
        $data['page_title'] = "Customer Edit";
        $data['roles'] = Role::whereIn('name', ['agent', 'regular'])->get();
        $data['customer'] = $this->customerService->getSingle($id);
        return view('admin.customer.edit',$data);
    }
    public function update(CustomerRequest $request,$id)
    {
        $in   = $request->except('_token','_method');
        $this->customerService->update($in,$id);
        session()->flash('success','Update successfully.');
        return redirect()->back();
    }

    public function show($id)
    {
        $data['customer']   = $this->customerService->getSingle($id);
        $data['page_title'] = ucwords( $data['customer']->name)." Details";
        $media = $data['customer']->getMedia('user')->first();
        $data['image'] = $media ? $media->getUrl() : asset('default-user.png');
        return view('admin.customer.show',$data);
    }
    public function verificationRequest()
    {
        $data['page_title'] = "Verification request";
        $data['customers'] = $this->customerService->getCustomerAgent();
        return view('admin.customer.request',$data);
    }
    public function verifyRequest($id)
    {
        $data['page_title'] = "Verifiy request";
        $data['customer']   = $this->customerService->getSingle($id);
        //profile picture
        $media = $data['customer']->getMedia('user')->first();
        $data['image'] = $media ? $media->getUrl() : asset('default-user.png');
        // front side
        $frontSidemMedia = $data['customer']->getMedia('frontSide')->first();
        $data['frontSide'] = $frontSidemMedia ? $frontSidemMedia->getUrl() : '0';

        // back side
        $backSidemMedia = $data['customer']->getMedia('backSide')->first();
        $data['backSide'] = $backSidemMedia ? $backSidemMedia->getUrl() : '0';

        // back side
        $selfiMedia = $data['customer']->getMedia('selfie')->first();
        $data['selfi'] = $selfiMedia ? $selfiMedia->getUrl() : '0';
        return view('admin.customer.request-show',$data);
    }

    public function verificationRequestUpdate($id)
    {
        $this->customerService->updateVerification($id);
        session()->flash('success','Update successfully.');
        return redirect()->route('request');
    }
    // need to remove
    public function verificationRequestStore(Request $request)
    {
        $user = User::find($request->customer_id);
        if ($request->front_side) {
            $user->clearMediaCollection('frontSide');
            $user->addMediaFromRequest('front_side')->toMediaCollection('frontSide');
        }

        if ($request->back_side) {
            $user->clearMediaCollection('backSide');
            $user->addMediaFromRequest('back_side')->toMediaCollection('backSide');
        }

        if ($request->selfie) {
            $user->clearMediaCollection('selfie');
            $user->addMediaFromRequest('selfie')->toMediaCollection('selfie');
        }


        $user->save();
        return redirect()->back();
    }

}
