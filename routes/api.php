<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\BlogsController;
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

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/admins',[AdminAuthController::class,'admins']);
    Route::get('/logout',[AdminAuthController::class,'logout']);
    Route::prefix('/admin')->group(function(){
    Route::controller(CategoryController::class)->group(function () {
    Route::get('/categories', 'index');
    Route::post('/category/store', 'store');
    Route::get('/category/{slug}', 'edit');
    Route::post('/category/update', 'update');
    Route::delete('/category/destroy/{id}', 'destroy');
    Route::get('/categories/blogs', 'CategoryBlogs');

    });
    Route::controller(BlogsController::class)->group(function () {
    Route::get('/posts', 'index');
    Route::post('/post/store', 'store');
    });
    });
});
Route::controller(AdminAuthController::class)->group(function () {
    Route::post('/user/login', 'login');
    });

