<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;
class AuthController extends Controller
{
    public function register(Request $request){
        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:6',
        ]);
        $user = User::create($data);
         return response()->json(['message' => 'User registered successfully' , 'user' => $user], 201);
    }

    public function login(Request $request){
        $credentials = $request->only('email', 'password');

        if (!$token = Auth::attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
        }

    public function logout(Request $request){

        Auth::logout();
        return response()->json(['message' => 'User logged out successfully']);
    }
    public function user(Request $request)
{
    return response()->json(Auth::user(), 200);
}
      public function refresh()
{
    return $this->respondWithToken(Auth::refresh());
}

protected function respondWithToken($token)
{
    return response()->json([
        'access_token' => $token,
        'token_type' => 'bearer',
        'expires_in' => Auth::factory()->getTTL() * 60
    ]);
}
}


