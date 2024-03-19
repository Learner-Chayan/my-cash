<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{

    protected $user;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user(); // Set the authenticated user

            // Check if the user has the 'student' role
            if ($this->user && $this->user->hasRole('customer')) {
                // Redirect to the home page if the user is a student
                Auth::logout();
                return redirect('/')->with('message', 'You cannot access this panel!');

            }
            if ($this->user && $this->user->hasRole('agent')) {
                // Redirect to the home page if the user is a instructor
                Auth::logout();
                return redirect('/')->with('message', 'You cannot access this panel!');
            }

            // Proceed with the request for users with other roles
            return $next($request);
        });
        $this->middleware(['auth','Setting','role:super-admin|admin']);
    }


    public function dashboard()
    {
         $data['page_title'] = "Dashboard";
         $data['totalCustomer']    = User::role('customer')->count();
         $data['totalTransaction'] = Transaction::count();

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
            'name'  => 'required',
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
            'phone' =>'required|unique:users,phone,'.$user->id,
            'image' => 'image|mimes:jpg,png,jpeg',

        ]);
        $in = $request->only('name','email','phone','image');
        $user->update($in);

        /** spattie media */
        //$user->addMedia
        // Add the new image to the 'user' collection
        if ($request->hasFile('image')) {
            $user->clearMediaCollection('user');
            $user->addMedia($request->image)->toMediaCollection('user');
        }
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
