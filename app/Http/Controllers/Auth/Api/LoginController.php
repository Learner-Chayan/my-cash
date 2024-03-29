<?php

namespace App\Http\Controllers\Auth\Api;

use App\Enums\UserIdTypeEnums;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Enums\Status;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\PersonalAccessToken;
use App\Http\Requests\SigninRequest;

class LoginController extends Controller
{
    public function login(SigninRequest $request):JsonResponse
    {
        // $valid = Validator::make($request->all(), [
        //     'email' => ['required','string','email', 'max:255'],
        //     'password'=> ['required','string','min:8'],
        // ]);
        // if ($valid->fails()) {
        //     return new JsonResponse($valid->errors(),422);
        // }

        $request->merge(['status'=>Status::ACTIVE]);
        if($request->user_id_type === UserIdTypeEnums::EMAIL){
            $request->merge(['email' => $request->user_id]);
            if(!Auth::guard('web')->attempt($request->only('email', 'password', 'status'))) {
                return new JsonResponse([
                    'status'=> false,
                    'message'=>  'Invalid Credentials',
                    "errors" => []
                ]);
            }
        }else{
            $request->merge(['phone' => $request->user_id]);
            if(!Auth::guard('web')->attempt($request->only('phone', 'password', 'status'))) {
                return new JsonResponse([
                    'status'=> false,
                    'message'=>  'Invalid Credentials',
                    "errors" => []
                ]);
            }
        }

        $user = Auth::user();
        $userTokens = PersonalAccessToken::where('tokenable_id', $user->id)
                                ->where('tokenable_type', User::class)
                                ->get();
        foreach ($userTokens as $token) {
            $token->delete();
        }
        $token = $user->createToken('login_token')->plainTextToken;

        return new JsonResponse([
            'message' => 'Logged In Successfully',
            'token'=> $token,
            'user'=> new UserResource($user),
        ], 201);
    }

    public function refreshToken(Request $request):JsonResponse
    {

        try {
            $request->validate([
                'token' => ['required','string'], 
            ]);
    
            $oldToken = $request->get('token');
            $token = PersonalAccessToken::findToken($oldToken);
            $user = $token->tokenable;
            $token->delete();
            $newToken = $user->createToken('login_token')->plainTextToken;
            $user = Auth::user();
            return new JsonResponse([
                'status' => true,
                'message' => 'Token Generated Successfully',
                'token'=> $newToken,
                'user'=> new UserResource($user),
            ], 201);
        } catch (\Throwable $th) {
            return new JsonResponse([
                'status' => false,
                'message'=> $th->getMessage(),
                'token'  => null
            ], 422);
        }

    }
}
