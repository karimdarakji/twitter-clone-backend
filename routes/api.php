<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TweetController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register',[UserController::class,'register']);
Route::post('login',[UserController::class,'login']);
Route::post('uploadProfileImage',[UserController::class,'uploadProfileImage']);
Route::get('getprofilepicture',[UserController::class,'getprofilepicture']);
Route::post('tweet',[TweetController::class,'tweet']);
Route::get('gettweets',[TweetController::class,'gettweets']);
Route::post('getuser',[UserController::class,'getuser']);

