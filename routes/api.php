<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthControllers;
use App\Http\Controllers\Api\Postku;
use App\Http\Controllers\API\Profileku;
use App\Http\Controllers\API\Commentku;
use App\Http\Controllers\CommentControllers;
use App\Http\Controllers\PostApiController;
use App\Http\Controllers\PostsControllers;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and will be assigned to
| the "api" middleware group. Make something great!
|
*/

Route::post('/register', [AuthControllers::class, 'register'])->name('register.api');
Route::post('/login', [AuthControllers::class, 'login'])->name('login.api');

// Ini rute yang membutuhkan autentikasi
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/', function (Request $request) {
        return $request->user();
    });

    Route::post('posts', [Postku::class, 'store']);
    Route::post('/posts', [PostsControllers::class, 'store']);
    
    // Tambahkan rute GET untuk mengambil daftar posting
    Route::get('posts', [Postku::class, 'index']);
    Route::get('posts/{id}', [Postku::class, 'show']);
    Route::put('posts/{id}', [Postku::class, 'update'])->name('posts.update');
    Route::delete('posts/{id}', [Postku::class, 'destroy'])->name('posts.destroy');
    
    Route::post('/profile', [Profileku::class, 'ganti_profile']);
    Route::get('/profile', [Profileku::class, 'show'])->name('profile.show');
    Route::get('/profile/{userId}', [Profileku::class, 'profile'])->name('profile');
    
    Route::resource('comments', CommentControllers::class);

    Route::post('/posts', [PostApiController::class, 'create']);
});
