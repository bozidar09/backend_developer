<?php

use App\Http\Controllers\auth\LoginController;
use App\Http\Controllers\auth\RegisterController;
use App\Http\Controllers\CopyController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FormatController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\PriceController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// ruta dostupna svima
Route::get('/', [HomeController::class, 'index']);

// rute dostupne samo gostima
Route::middleware('guest')->group(function(){
    Route::controller(RegisterController::class)->group(function(){
        Route::get('/register', 'create')->name('register.create');
        Route::post('/register', 'store')->name('register.store');
    });
    
    Route::get('/login', [LoginController::class, 'create'])->name('login.create');
    Route::post('/login', [LoginController::class, 'store'])->name('login.store');
});

// rute dostupne samo prijavljenim korisnicima
Route::middleware('member')->group(function(){
    Route::delete('/logout', [LoginController::class, 'destroy'])->name('logout');

    Route::controller(DashboardController::class)->group(function(){
        Route::get('/dashboard', 'index')->name('dashboard.index');
        Route::patch('/dashboard/{rental}-{copy}', 'returnMovie')->name('dashboard.return');
    });
    
    Route::resource('rentals', RentalController::class);
    
    Route::resource('users', UserController::class);
    
    Route::resource('copies', CopyController::class)->except('show');
    Route::get('/copies/{copy:barcode}', [CopyController::class, 'show'])->name('copies.show');
    Route::delete('/copies/{copy:barcode}/all', [CopyController::class, 'destroyAll'])->name('copies.destroy.all');
    
    Route::resource('formats', FormatController::class);
    
    Route::resource('movies', MovieController::class);
    
    Route::resource('prices', PriceController::class);
    
    Route::resource('genres', GenreController::class);
});


// Route::get('/prices', [PriceController::class, 'index'])->name('prices.index');
// Route::get('/prices/create', [PriceController::class, 'create'])->name('prices.create');
// Route::post('/prices', [PriceController::class, 'store'])->name('prices.store');
// Route::get('/prices/{price}', [PriceController::class, 'show'])->name('prices.show');
// Route::get('/prices/{price}/edit', [PriceController::class, 'edit'])->name('prices.edit');
// Route::put('/prices/{price}', [PriceController::class, 'update'])->name('prices.update');
// Route::delete('/prices/{price}', [PriceController::class, 'destroy'])->name('prices.destroy');

// Route::controller(PriceController::class)->group(function(){
//     Route::get('/prices', 'index')->name('prices.index');
//     Route::get('/prices/create', 'create')->name('prices.create');
//     Route::post('/prices', 'store')->name('prices.store');
//     Route::get('/prices/{price}', 'show')->name('prices.show');
//     Route::get('/prices/{price}/edit', 'edit')->name('prices.edit');
//     Route::put('/prices/{price}', 'update')->name('prices.update');
//     Route::delete('/prices/{price}', 'destroy')->name('prices.destroy');
// });

// možemo skraćeno dodati 7 uobičajenih metoda sa resource() i selekcionirati koje nam trebaju sa only()
// Route::resource('prices', PriceController::class)->only('index', 'store');

// ORM - object relational mapping - Eloquent