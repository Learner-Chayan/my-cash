<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;

class HomeController extends Controller
{

    public function __construct()
    {
        // $this->middleware(['auth','role:admin|super-admin','Setting']);
        $this->middleware(['auth','Setting']);
    }

    public function dashboard()
    {
        
         $data['page_title'] = "Dashboard1";
         return view('admin.dashboard.dashboard',$data);
    }
    public function editProfile()
    {
        $data['page_title'] = "Edit Your Profile";
        $data['user'] = User::findOrFail(Auth::user()->id);

        $media = $data['user']->getMedia('user')->first();
        $data['image'] = $media ? $media->getUrl() : "";
        return view('admin.dashboard.edit-profile',$data);
    }
    public function updateProfile(Request $request)
    {
        $user = User::findOrFail(Auth::user()->id);
        $request->validate([
            'name' => 'required',
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
            'phone' =>'required|unique:users,phone,'.$user->id,
            'image' => 'image|mimes:jpg,png,jpeg',

        ]);
        $in = $request->only('name','email','phone','image');
        // if ($request->hasFile('image'))
        // {
        //     File::delete(public_path("images/user/$user->image"));
        //     $image = $request->file('image');
        //     $image_name = rand(00000,19999).'.'.$image->getClientOriginalExtension();
        //    // Image::make($image)->resize(215,215)->save(public_path("images/user/$image_name"));
        //     $in['image'] = $image_name;

        // }
        $user->update($in);


        /** spattie media */
        //$user->addMedia
        $user->addMedia($request->image)->toMediaCollection('user');
        /** Spattie media */


        session()->flash('success','Profile Update successfully.');
        return redirect()->back();
    }

    public function changePassword ()
    {
        $data['page_title'] = "Change Password";
        return view('admin.dashboard.change-password',$data);
    }

    public function updatePassword(Request $request)
    {
        $this->validate($request, [
            'old_password' => 'required',
            'password' => 'required',
        ]);
        try{

            DB::beginTransaction();
                $current_password = Auth::user()->getAuthPassword();
                $user = Auth::user();
                if (Hash::check($request->old_password, $current_password))
                {
                    $user->password = $request->password;
                    $user->save();
                    session()->flash('success','Password Change Successfully Done!');
                    return redirect()->back();
                }else{

                    session()->flash('error','Current Password Not Match');
                    return redirect()->back();
                }
            DB::commit();
        } catch (\PDOException $e) {
            DB::rollback();
            session()->flash('success',$e->getMessage());
        }

    }
}
