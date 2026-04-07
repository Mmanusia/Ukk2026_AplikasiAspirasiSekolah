<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AspirasiController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\InputAspirasiController;

Route::get('/home', function () {
    return view('index');
})->middleware('auth')->name('home');
Route::get('/', function () {
    return view('auth.login');
});
Route::get('/index', function () {
    return view('auth.login');
});

Route::middleware('auth')->group(function () {
    Route::middleware('role:siswa')->group(function () {
        Route::resource('input_aspirasi', InputAspirasiController::class);
    });

    Route::middleware('role:admin')->group(function () {
        Route::resource('kategori', KategoriController::class);
        Route::resource('aspirasi', AspirasiController::class);
    });
});