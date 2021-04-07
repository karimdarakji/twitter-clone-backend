<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TweetController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;



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

//User controller
Route::post('register',[UserController::class,'register']);
Route::post('login',[UserController::class,'login']);
Route::post('uploadProfileImage',[UserController::class,'uploadProfileImage']);
Route::get('getprofilepicture',[UserController::class,'getprofilepicture']);
Route::get('getuser/{id}',[UserController::class,'getuser']);
Route::get('getuser_notfollowed/{id}',[UserController::class,'getuser_notfollowed']);

//Tweet controller
Route::post('tweet',[TweetController::class,'tweet']);
Route::get('gettweets/{id}',[TweetController::class,'gettweets']);
Route::delete('delete/{id}',[TweetController::class,'delete']);
Route::get('searchtweet/{key}',[TweetController::class,'searchtweet']);

//Follow controller
Route::post('follow/{id_sender}/{id_receiver}',[FollowController::class,'follow']);
Route::get('check/{id_sender}/{id_receiver}',[FollowController::class,'check']);
Route::delete('unfollow/{id_sender}/{id_receiver}',[FollowController::class,'unfollow']);

//Like controller
Route::post('like/{user}',[LikeController::class,'like']);
Route::get('getlike/{user}',[LikeController::class,'getlike']);
Route::delete('deletelike/{user}/{tweet_id}',[LikeController::class,'deletelike']);

//Comment controller
Route::post('comment/{tweetid}/{user}',[CommentController::class,'comment']);
Route::get('getcomment/{tweetid}',[CommentController::class,'getcomment']);
Route::delete('deletecomment/{user}/{tweet_id}',[CommentController::class,'deletecomment']);






