<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\user;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed',
        ]);
        $user = user::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $token = $user->createToken('mytoken' )->plainTextToken;
        return response([
            'user' => $user,
            'token' => $token
        ],201);
    }
    public function logout()
    {
        auth()->user()->tokens()->delete();
        return response([
            'message' => 'SuccessFull Logged out'
        ]);
    }
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        $user = user::where('email', $request->email)->first();
        if(!$user || !Hash::check($request->password,$user->password))
        {
            return response([
                'message' => 'The Provided credentials are incorrect.'
            ],401);
        }
        else
        {
            $token = $user->createToken('mytoken' )->plainTextToken;
            return response([
                'user' => $user,
                'token' => $token
            ],200);
        }
    }
}
