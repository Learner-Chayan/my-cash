<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Spatie\Permission\Models\Role;


class UserController extends Controller
{
    function __construct()
    {
        $this->middleware(['auth','role:admin|super-admin','Setting']);
    }

    public function index()
    {
        $page_title = "Manage User";
        $data       = User::with('roles')->where('id','!=',1)->get();
        return view('admin.users.index',compact('data','page_title'));
    }


    public function create()
    {
        $page_title = "New User Create";
        $roles      = Role::where('name','!=','super-admin')->get();
        return view('admin.users.create',compact('roles','page_title'));
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'name'  => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
        ]);

        $input = $request->all();
        $user  = User::create($input);
        $user->assignRole($request->input('roles'));

        session()->flash('success','User created successfully');
        return redirect()->route('users.index');
    }

    public function show($id)
    {
        $page_title = "User Show";
        $user = User::find($id);
        return view('admin.users.show',compact('user','page_title'));
    }


    public function edit($id) {
        $data['page_title'] = "User Edit";
        $data['user']  = User::findOrFail($id);
        $data['roles'] = Role::where('name','!=','super-admin')->get();
        return view('admin.users.edit',$data);

    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $this->validate($request, [
            'name'  => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'same:confirm-password',
        ]);

        $input = $request->only(['name', 'email','phone', 'password']);
        $roles = $request['roles'];
        $user->fill($input)->save();

        if (isset($roles)) {
            $user->roles()->sync($roles);
        }
        else {
            $user->roles()->detach();
        }

        return redirect()->route('users.index')
            ->with('success','User updated successfully');
    }

    public function destroy(Request $request,$id)
    {
        $user = User::find($id);
        $user->roles()->detach();
        $user->delete();
        return redirect()->route('users.index')
            ->with('success','User deleted successfully');
    }
}
