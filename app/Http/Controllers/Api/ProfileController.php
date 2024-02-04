<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index ()
    {
        $user = Auth::user();
        return new UserResource($user);
    }

    public function changePassword (Request $request) {
        $user = Auth::user();
    }
}
