<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
Use App\Http\Controllers\UserController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\CommentsController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



    Route::post('/register', [UserController::class, 'create']);
    Route::post('/login', [UserController::class, 'login']);
    Route::post('/logout', [UserController::class, 'logout'])->middleware(['auth:api']);
    Route::post('/post', [PostsController::class, 'create'])->middleware(['auth:api']);
    Route::get('/post/{id}', [PostsController::class, 'show'])->withoutMiddleware(['auth:api']);
    Route::post('/post/update/{id}', [PostsController::class, 'edit'])->middleware(['auth:api']);
    Route::delete('/post/{id}', [PostsController::class, 'delete'])->middleware(['auth:api']);
    Route::get('/post/searchall', [PostsController::class, 'all'])->withoutMiddleware('auth:api');
    Route::post('/post/{id}/comment', [CommentsController::class, 'create'])->middleware(['auth:api']);
    Route::post('/post/{id}/comment/update/{idComment}', [CommentsController::class, 'edit'])->middleware(['auth:api']);
    Route::post('/post/{id}/comment/{idComment}', [CommentsController::class, 'destroy'])->middleware(['auth:api']);
    Route::get('/post/{id}/comment/{idComment}', [CommentsController::class, 'show'])->withoutMiddleware(['auth:api']);

