<?php

use App\Helpers\ResponseHelpers;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Spatie\FlareClient\Api;


//for auth
Route::post('register',[AuthController::class,'register']);
Route::post('login',[AuthController::class,'login']);

Route::group(['middleware'=>'auth:api'],function(){
  
    //for logout
    Route::post('logout',[AuthController::class,'logout']);

    //for profile
    Route::get('profile',[ProfileController::class,'profile']);

    //for categories
    Route::get('categories',[CategoryController::class,'index']);

    //for post create
    Route::post('post',[PostController::class,'create']);

    //for show posts
    Route::get('post',[PostController::class,'index']);

      //for show posts detail
    Route::get('post/{id}',[PostController::class,'show']);

    //for show own posts
    Route::get('authposts',[ProfileController::class,'posts']);
});