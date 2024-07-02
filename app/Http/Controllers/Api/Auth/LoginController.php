<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function __invoke(
        LoginRequest $request
    )
    {
       $user = User::where('username',$request->username)->first();
       if(Hash::check($request->password , $user->password)){
           $token = $user->createToken($user->id)->plainTextToken;
           return($token);
       }
       return ('wrong password Or username');
    }
}
