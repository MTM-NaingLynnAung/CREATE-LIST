<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\UserResource;

class AuthController extends Controller
{
    public function user(){
        return new UserResource(auth()->user());
    }
    public function login(LoginRequest $request){
        if(!auth()->attempt($request->only('email', 'password'))){
            throw new AuthenticationException("Email or password is not valid");
        }

        $token = auth()->user()->createToken('user-token');

        return [
            'message' => ['successfully logged in'],
            'token' => $token->plainTextToken
        ];
    }
}
