<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use Validator;

class RegisterController extends Controller
{
    // Regsiter User
    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);

        if($validator->fails()) {
            return response()->json('Validator Error', $validator->errors());
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['Message' => 'User Registered Successfully','access_token' => $token]);
    }

    // Login User
    public function login(Request $request) {
        // $validator = Validator::make([
        //     'email' => 'required|email',
        //     'password' => 'required'
        // ]);

        // if($validator->fails()) {
        //     return response()->json('Validator Error', $validator->errors());
        // }

        if(!Auth::attempt($request->only('email','password')))
        {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $user = User::where('email', $request['email'])->firstorfail();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['message' => 'Hi'.$user->name.'Welcome to home','access_token'=>$token]);
    }

    // Logout User
    public function logout() {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'You are successfully logged out'
        ];
    }

}
