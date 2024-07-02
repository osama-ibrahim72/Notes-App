<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends Controller
{
    /**
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function __invoke(
        LoginRequest $request
    )
    {
       $user = User::where('username',$request->username)->first();
       if($user->email_verified_at == null){
           return response()->json([
               'message' => __("your email Not verified"),
               'status' => Response::HTTP_BAD_REQUEST
           ], Response::HTTP_BAD_REQUEST);
       }
       if(Hash::check($request->password , $user->password)){
           $token = $user->createToken($user->id)->plainTextToken;
           return response()->json([
               'token'=>$token,
               'message' => __("Loged in Successfully"),
               'status' => Response::HTTP_OK
           ], Response::HTTP_OK);
       }
        return response()->json([
            'message' => __("wrong password Or username"),
            'status' => Response::HTTP_BAD_REQUEST
        ], Response::HTTP_BAD_REQUEST);
    }
}
