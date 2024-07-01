<?php

use App\Http\Controllers\Api\Auth\RegisterController;
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
        });
});
