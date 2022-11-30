<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\user;
use Auth;

class API_Controller extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed',
        ]);
        if((user::where('email', $request->email)->first()))
        {
            return response([
                'message' => 'This is Already Exist',
                'status' => 'Failed'
            ],401);
        }
        else
        {
            $user = user::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            $token = $user->createToken($request->email)->plainTextToken;
            return response([
                'token' => $token,
                'message' => 'Successfully Registered',
                'status' => 'Success'
            ],200);
        }
    }
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        $user = user::where('email', $request->email)->first();
        if($user && Hash::check($request->password,$user->password))
        {
            $token = $user->createToken($request->email)->plainTextToken;
            return response([
                'token' => $token,
                'message' => 'Login Successfully',
                'status' => 'Success'
            ],200);
        }
        else
        {
            return response([
                'message' => 'Please Enter Valid data',
                'status' => 'Failed'
            ],401);
        }
    }
    public function logout()
    {
        auth()->user()->tokens()->delete();
        return response([
            'message' => 'Logout Successfully',
            'status' => 'Success'
        ],200);
    }
    public function logged_user()
    {
        $logged_user = auth()->user();
        return response([
            'user' => $logged_user,
            'message' => 'Logged User Data',
            'status' => 'Success'
        ],200);
    }
    public function change_password(Request $request)
    {
        $request->validate([
            'password' => 'required|confirmed',
        ]);
        $logged_user = auth()->user();
        $logged_user->password = Hash::make($request->password);
        $logged_user->save();
        return response([
            'message' => 'Change Password Successfully',
            'status' => 'Success'
        ],200);
    }
}
