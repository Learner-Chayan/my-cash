<?php

namespace App\Http\Controllers\Auth\Api;

use App\Http\Controllers\BaseController as BaseController;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegisterController extends BaseController
{
    public function register(Request $request)
    {

        return 'Hello World';


        // $valid = Validator::make($request->all(),[
        //     'name'  => 'required|string',
        //     'phone' => 'required|string|unique:users,phone|max:14|regex:/^[0-9]+$/',
        //     'email' => 'required|email|unique:users,email|max:255',
        //     'password' => 'required|min:6',
        //     'confirm_password' => 'required|same:password',
        // ]);
        // if ($valid->fails()){
        //     return $this->sendError('validation Error',$valid->errors()->all());
        // }
        // $user = User::create([
        //     'name'  => $request->name,
        //     'phone' => $request->phone,
        //     'email' => $request->email,
        //     'password' => $request->password,
        // ]);

        // $success['token'] = $user->createToken('RestApi')->plainTextToken;
        // $success['name']  = $user->name;
        // return $this->sendSuccess($success,'Successfully Save');
    }
}
