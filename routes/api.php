<?php

use App\Http\Controllers\Api\Auth\ForgetPasswordController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\LogoutController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Auth\ResetPasswordController;
use App\Http\Controllers\Api\Auth\VerifyController;
use App\Http\Controllers\Api\Notes\NoteController;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group([
    'as' =>'api'
], function (){

        Route::group([
            'as' => 'auth',
            'prefix' => 'auth',
        ], function () {
            Route::post('/register', [RegisterController::class, '__invoke']);
            Route::post('/login',[LoginController::class,'__invoke']);
            Route::delete('/logout',[LogoutController::class , '__invoke']);
            Route::post('/verify',[VerifyController::class,'__invoke']);
            Route::post('/forget_password',[ForgetPasswordController::class,'__invoke']);
            Route::post('/reset_password',[ResetPasswordController::class,'__invoke']);
        });
    Route::group([
        'middleware' => [
            Authenticate::class . ':sanctum',
        ]
    ], function () {

        /**
         * user account
         */
        Route::group([
            'as' => 'account.',
        ], function () {
            Route::apiResource('notes', NoteController::class);
        });
    });
});
