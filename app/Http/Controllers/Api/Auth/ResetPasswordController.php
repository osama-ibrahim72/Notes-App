<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Requests\Api\Auth\ResestPasswordRequest;
use Symfony\Component\HttpFoundation\Response;


class ResetPasswordController extends Controller
{
    /**
     * @param ResestPasswordRequest $request
     * @return JsonResponse
     */
    public function __invoke(
        ResestPasswordRequest $request
    ):JsonResponse
    {
        $user = User::where([
            'email'=>$request->email,
            'reset_password'=>true
        ])->first();
        if($user){
            $user->update([
                'password'=>$request->password
            ]);
            return response()->json([
                'message' => __("reset password Successfully"),
                'status' => Response::HTTP_OK
            ], Response::HTTP_OK);
        }
        return response()->json([
            'message' => __("We couldn't reset your password, please tyr again later"),
            'status' => Response::HTTP_BAD_REQUEST
        ], Response::HTTP_BAD_REQUEST);

    }
}
