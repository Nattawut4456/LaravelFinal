<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\Controller;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/login/{uri?}',[AuthController::class,'showLogin']);
Route::post('/checklogin',[AuthController::class,'checkLogin']);

Route::get('/register',[AuthController::class,'register']);
Route::post('/register',[AuthController::class,'storeUser']);

Route::get('/', [ContentController::class,'index']);
Route::get('/category/{id}',[ContentController::class,'viewCategory']);
Route::get('/category/{id}',[ContentController::class,'viewCategory']);
Route::get('/blog/search',[ContentController::class,'search']);
Route::get('/blog/{id}',[ContentController::class,'showBlog']);
Route::middleware(['auth.admin'])->group(function(){
    Route::get('/writeblog', [ContentController::class,'createBlog']);
    Route::post('/blog/store',[ContentController::class,'storeBlog']);
    Route::put('/blog/update/{id}',[ContentController::class,'updateBlog']);
    Route::get('/blog/edit/{id}',[ContentController::class,'editBlog']);
    Route::get('/blog/delete/{id}',[ContentController::class,'deleteBlog']);
    Route::post('/logout',[AuthController::class,'logout']);
    Route::get('/myblog',[ContentController::class,'myBlog']);
    Route::post('/favourite',[ContentController::class,'favourite']);
    Route::get('/favourite',[ContentController::class,'showFavourite']);
    Route::post('/blog/comment',[ContentController::class,'createComment']);
    Route::post('/blog/comment/delete/{blog_id}/{com_id}',[ContentController::class,'deleteComment']);
});


