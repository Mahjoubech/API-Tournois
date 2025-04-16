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
        
        $token = JWTAuth::fromUser($user);

        return response()->json([
            'message' => 'User registered successfully',
            'user' => $user,
            'token' => $token
        ], 201);    }

    public function login(Request $request){
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string|min:6',
        ]);
        // Check if the user exists
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }
        // Check if the password is correct
        if (!password_verify($request->password, $user->password)) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }
        // Generate a JWT token
        $token = JWTAuth::fromUser($user);
        return response()->json([
            'message' => 'User logged in successfully',
            'user' => $user,
            'token' => $token
        ], 200);

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


