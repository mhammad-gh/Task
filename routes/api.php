<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\BaseController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\User\UserController;

    //          Admin                 //
Route::group(['middleware' => 'api'], function($router) {
    Route::post('/register', [BaseController::class, 'register']);
    Route::post('/login', [BaseController::class, 'login']);

    //   Management User Information  //
    Route::get('/getUser',[CustomerController::class,'index']);
    Route::post('/create',[CustomerController::class,'store']);
    Route::post('/update',[CustomerController::class,'update']);
    Route::get('/user_profile/{id}',[CustomerController::class,'user_profile']);
    Route::post('/delete/{id}',[CustomerController::class,'delete']);

    //   Management Product Information  //
    Route::resource('product',ProductController::class);
    Route::post('/assign',[ProductController::class,'assign']);
    Route::get('/destroy/{id}',[ProductController::class,'destroy']);

});

   //          User                     //
Route::group(['middleware' => 'api'], function($router) {
    Route::get('/view/{id}',[UserController::class,'view']);
});
