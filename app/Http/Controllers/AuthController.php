<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'meta' => ['success' => false, 'errors' => ['Password incorrect for: ' . $request->input('username')],
            ],
            ], 401);
        }

        $user = Auth::user();
        $token = JWTAuth::fromUser($user);

        return response()->json([
            'meta' => ['success' => true, 'errors' => []],
            'data' => [
                'token' => $token,
                'minutes_to_expire' => config('jwt.ttl'),
            ],
        ], 200);
    }
}

