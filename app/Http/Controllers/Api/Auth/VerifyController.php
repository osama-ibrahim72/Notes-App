<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\VerifyRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyController extends Controller
{
    /**
     * @param VerifyRequest $request
     * @return JsonResponse
     */
    public function __invoke(
        VerifyRequest $request
    ):JsonResponse
    {
        $user = User::where('email',$request->email)->first();
        if($request->otp == $user->otp ){
            $user->update([
                'otp'=>null,
                'email_verified_at'=>now(),
                'reset_password'=>$request->reset_password
            ]);
            $token = $user->createToken($user->id)->plainTextToken;
            return response()->json([
                'token'=>$token,
                'message' => __("Loged in Successfully"),
                'status' => Response::HTTP_OK
            ], Response::HTTP_OK);
        }
        return response()->json([
            'message' => __("Wrong Otp, please tyr again later"),
            'status' => Response::HTTP_BAD_REQUEST
        ], Response::HTTP_BAD_REQUEST);
    }
}
