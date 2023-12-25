<?php

namespace App\Http\Controllers\Auth\Api;

use App\Http\Controllers\BaseController as BaseController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\SignupRequest;

class RegisterController
{
    public function register(SignupRequest $request)
    {
        $user = User::create([
            'name'  => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => $request->password,
        ]);
        // $success['token'] = $user->createToken('RestApi')->plainTextToken;
        // $success['name']  = $user->name;

        return response(['status' => true, 'message' => 'Registration Completed Successfully'], 201);
    }
}
