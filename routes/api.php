<?php

use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;




route::post('/login',[AuthController::class,'login']);
route::post('/register',[AuthController::class,'register']);


route::middleware(['auth:sanctum'])->group(function(){
    route::post('/logout',[AuthController::class,'logout']);
    route::get('/profile',[AuthController::class,'profile']);
    route::apiResource('products',ProductController::class);

});



Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
