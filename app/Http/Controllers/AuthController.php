<?php

namespace App\Http\Controllers;

use App\Models\User;
use Laravel\Passport\Token;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('UserToken')->accessToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
            'message' =>'User Register Successfully',
        ],200);
    }
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $user = $request->user();
        $token = $user->createToken('API Token')->accessToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
            'message' =>'User Logged in Succesfull'
        ],200);
    }

    public function getUsers()
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        return response()->json([
            'logged_user' => $user, 
            'users' => User::where('id', '!=', $user->id)->get(['id', 'name', 'email']),
        ], 200);
    }

    // public function authorize(Request $request)
    // {

    //     $token = $request->bearerToken();

    //     if ($token && Auth::guard('api')->user()) {
    //         return response()->json(['status' => 'authorized']);
    //     }

    //     return response()->json(['status' => 'unauthorized'], 403);


    // }

}
