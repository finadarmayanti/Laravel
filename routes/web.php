<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserControllers;
use App\Http\Controllers\AuthControllers;
use App\Http\Controllers\LoginControllers;
use App\Http\Controllers\RegisterControllers;
use App\Http\Controllers\HomeControllers;
use App\Http\Controllers\PostsControllers;
use App\Http\Controllers\ProfileControllers;
use App\Http\Controllers\SearchControllers;
use App\Http\Controllers\CommentControllers;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', [HomeControllers::class, 'index'])->middleware('auth');

Route::get('/about', function () {
    return view('about');
});

Route::get('/register', [RegisterControllers::class, 'registerPage'])->name('register');
Route::post('/register', [RegisterControllers::class, 'registerProses'])->name('register.proses');
Route::get('/login', [LoginControllers::class, 'loginPage'])->name('login');
Route::post('/login', [LoginControllers::class, 'loginProses'])->name('login.proses');

Route::get('/home', [PostsControllers::class, 'index'])->name('home');
Route::resource('posts', PostsControllers::class);

// Di sini, Anda memiliki route yang tidak perlu:
// Route::get('/posts', [PostsControllers::class, 'index'])->name('posts.index');
// Karena Anda sudah memiliki route resource di atas.

Route::post('/posts/{id}/like', [PostsControllers::class, 'like'])->name('posts.like');
Route::post('/posts/{id}/dislike', [PostsControllers::class, 'dislike'])->name('posts.dislike');
Route::get('/posts/{post}', [PostsControllers::class, 'show'])->name('post.show');

// Perbaikan di router untuk menyimpan komentar
Route::post('/posts/{post}/comment', [PostsControllers::class, 'comment'])->name('posts.comment.store');
Route::put('/comment/{comment}', [CommentControllers::class, 'update'])->name('comment.update');
Route::delete('/comment/{comment}', [CommentControllers::class, 'destroy'])->name('comment.destroy');

Route::get('/profile', [ProfileControllers::class, 'show'])->name('profile.show');
Route::put('/profile/update', [ProfileControllers::class, 'update'])->name('profile.update');
Route::get('/profile/{userId}', [ProfileControllers::class, 'profile'])->name('profile');

Route::get('/search', [SearchControllers::class, 'searchUsers'])->name('search.users');
