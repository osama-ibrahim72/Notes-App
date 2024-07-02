<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\ForgetPasswordRequest;
use App\Mail\emailMailable;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\Response;

class ForgetPasswordController extends Controller
{
    /**
     * @param ForgetPasswordRequest $request
     * @return JsonResponse
     */
    public function __invoke(
        ForgetPasswordRequest $request
    ):JsonResponse
    {
        $user = User::where('username',$request->username)->first();
        $user->update([
            'otp' => $this->generateOtp(),
            'reset_password'=>true
        ]);
        Mail::to($user->email)->send(new EmailMailable($user->otp));
        return response()->json([
            'message' => __("Otp sent Successfully on your mail"),
            'status' => Response::HTTP_OK
        ], Response::HTTP_OK);

    }

    /**
     * @return int
     */
    private function generateOtp(): int
    {
        return random_int(1000,9999);
    }
}
