<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function __invoke(
        RegisterRequest $request
    )
    {
        $user = User::create($request->validated());
        $token = $user->createToken($user->id)->plainTextToken;
        return([$user , $token]);
    }
}
