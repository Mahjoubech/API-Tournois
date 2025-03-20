<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request){
        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:6',
        ]);
        $user = User::create($data);
        $token = $user->createToken($request->name);
         return response()->json(['message' => 'User registered successfully'], 201);
    }

    public function login(Request $request){
        $data = $request->validate([
          'email' => 'required|string|email|exists:users',
          'password' => 'required'
        ]);
        $user = User::where('email',$request->email)->first();
        if(!$user || !Hash::check($request->password,$user->password)){
            return response()->json(['message' => 'Incorrect'], 401);
        }
  $token = $user->createToken($user->name);

  return ['user' => $user,
  'token' => $token->plainTextToken
];
    }
    public function logout(Request $request){
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Logged out successfully'], 200);



    }
    public function user(Request $request)
{
    return response()->json($request->user(), 200);
}


}
