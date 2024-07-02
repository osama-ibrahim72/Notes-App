<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\RegisterRequest;
use App\Mail\EmailMailable;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\Response;

class RegisterController extends Controller
{
    /**
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function __invoke(
        RegisterRequest $request
    ):JsonResponse
    {

        if($user = User::create($request->validated())) {
            Mail::to($user->email)->send(new EmailMailable($user->otp));
            return response()->json([
                'message' => __("Otp sent Successfully on your mail"),
                'status' => Response::HTTP_OK
            ], Response::HTTP_OK);
        }

        return response()->json([
            'message' => __("We couldn't create a new user, please tyr again later"),
            'status' => Response::HTTP_BAD_REQUEST
        ], Response::HTTP_BAD_REQUEST);

    }
}
