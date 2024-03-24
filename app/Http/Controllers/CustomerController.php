<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerRequest;
use App\Services\CustomerService;
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

}
