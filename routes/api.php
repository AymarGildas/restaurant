<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//link for user regristration fr[AuthController::class,'register']);

//link for user login from authcontroller login function

//link for logout using auth:sactum where only authenticated user will logout
Route::middleware('auth:sanctum')->group(function () {

    
});

