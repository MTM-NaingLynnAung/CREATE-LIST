<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\RegisterRequest;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Response;

class UserController extends Controller
{
    public function index()
    {
        return User::all();
    }
    public function store(RegisterRequest $request)
    {
        
        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);
        $user->save();
        return $user;
    }
    public function login(Request $request)
    {
        // $request->validate([
        //     'email' => 'required',
        //     'password' => 'required'
        // ]);
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];
        if(!Auth::attempt($credentials)){
            //return response()->json([
            //    'message' => 'Invalid credentials'
            //]);
            throw new AuthenticationException("Email or password is not valid");
        }
        $user = Auth::user();
        return $user->createToken($user->name)->plainTextToken;
        
        
    }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    }
}
