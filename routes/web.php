<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::prefix('mahasiswa')->group(function () {

});
Route::prefix('dosen')->group(function () {

});
Route::prefix('admin')->group(function () {
    
});

