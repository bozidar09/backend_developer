<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::controller(HomeController::class)->group(function(){
    Route::get('/', 'index')->name('home.index');
    Route::get('/{tag}/tag', 'showTag')->name('home.tag');
    Route::get('/{category}/category', 'showCategory')->name('home.category');
    Route::get('/{user}/user', 'showUser')->name('home.user');
    Route::get('/{article}/article', 'showArticle')->name('home.article');
});

Route::middleware('guest')->group(function(){
    Route::controller(AuthenticatedSessionController::class)->group(function(){
        Route::get('/register', 'create')->name('register.create');
        Route::post('/register', 'store')->name('register.store');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::resource('comments', CommentController::class);

Route::resource('articles', ArticleController::class);

Route::resource('categories', CategoryController::class);

Route::resource('tags', TagController::class);

Route::resource('users', UserController::class);

Route::resource('roles', RoleController::class);

require __DIR__.'/auth.php';
