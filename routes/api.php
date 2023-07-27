<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// public Route
// Auth route
Route::post('/register',[Controllers\UserController::class,'registerUser']);
Route::post('/login',[Controllers\UserController::class,'login']);





// private route
Route::group(['middleware'=>'auth:sanctum'],function (){
    // post CRUD
    Route::resource('/posts',Controllers\PostCotroller::class);
    // Comment CRUD
    Route::get('/posts/{postID}/comments',[Controllers\CommentController::class,'index']);
    Route::post('/posts/{postID}/comments',[Controllers\CommentController::class,'store']);
    Route::put('/posts/{postID}/comments/{id}',[Controllers\CommentController::class,'update']);
    Route::delete('/posts/{postID}/comments/{id}',[Controllers\CommentController::class,'delete']);

    // user posts and user comments
     Route::get('/user/posts',[controllers\UserPostsComments::class,'userPosts']);
     Route::get('/user/comments',[controllers\UserPostsComments::class,'userComments']);


});