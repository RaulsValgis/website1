<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth:api", [
            'except' => [
                'login',
                'register'
            ]
        ]); 
    }

    public function Register(Request $request)
    {
        $request->validate([
            'name'      => 'required',
            'email'     => 'required|email',
            'password'  => 'required|min:8'
        ]);

        $user = User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => $request->password,
        ]);

        $token = Auth::login($user);

        return response()->json([
            'status'    => 'success',
            'message'   => 'User Registered Succesfully!',
            'user'      => $user,
            'token'     => $token
        ]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'=> 'required',
            'password'=> 'required'
        ]);

        $credentials = $request->only('email','password');

        $token = Auth::attempt($credentials);

        if (!$token) {
            return response()->json([
                'status'=> 'error',
                'message'=> 'Login Failed'
            ]);
        };
        return response()->json([
            'status'=> 'success',
            'message'=> 'Logged in Succesfully!',
            'token' => $token
        ]);




    }









}