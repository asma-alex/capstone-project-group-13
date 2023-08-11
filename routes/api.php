<?php

use App\Http\Controllers\IdeaController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

//protected routes
Route::middleware(['auth:sanctum'])->group(function(){
    //get post comments
    //Route::get('ideas/{id}/comments', [IdeaController::class, 'showComments']);
    //create post
    Route::post('ideas', [IdeaController::class, 'store']);
    //delete post
    Route::delete('ideas/{id}', [IdeaController::class, 'destroy']);
    //update post
    Route::put('ideas/{id}', [IdeaController::class, 'update']);

    //like a post
    Route::post('/ideas/{idedaid}/{userid}', [LikesController::class, 'store']);

    //create comment
    Route::post('comments', [CommentController::class, 'store']);
});

//posts
//get all posts
Route::get('ideas', [IdeaController::class, 'index']);
//get an idea //not used
Route::get('ideas/{id}', [IdeaController::class, 'show']);
//get a post with comments
Route::get('ideas/{id}/comments', [IdeaController::class, 'showComments']);
//get all post of specific user
Route::get('ideas/user/{id}', [IdeaController::class, 'getUserIdeas']);
