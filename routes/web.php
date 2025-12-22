<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\RoleLoginController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\MahasiswaController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [RoleLoginController::class, 'show'])->middleware('guest')->name('login');
Route::post('/login', [RoleLoginController::class, 'login'])->middleware('guest')->name('login.post');
Route::post('/logout', [RoleLoginController::class, 'logout'])->middleware('auth')->name('logout');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->middleware('auth')->name('dashboard');
    Route::get('/users', [AdminController::class, 'users'])->middleware('auth')->name('users');
    Route::get('/instansi', [AdminController::class, 'instansi'])->middleware('auth')->name('instansi');
    Route::get('/periode', [AdminController::class, 'periode'])->middleware('auth')->name('periode');
    Route::get('/penempatan', [AdminController::class, 'penempatan'])->middleware('auth')->name('penempatan');
});
Route::prefix('dosen')->name('dosen.')->group(function () {
    Route::get('/dashboard', [DosenController::class, 'dashboard'])->middleware('auth')->name('dashboard');
    Route::get('/mahasiswa', [DosenController::class, 'mahasiswa'])->middleware('auth')->name('mahasiswa');
    Route::get('/logbook', [DosenController::class, 'logbook'])->middleware('auth')->name('logbook');
    Route::get('/nilai', [DosenController::class, 'nilai'])->middleware('auth')->name('nilai');
    Route::get('/laporan', [DosenController::class, 'laporan'])->middleware('auth')->name('laporan');
});
Route::prefix('mahasiswa')->name('mahasiswa.')->group(function () {
    Route::get('/dashboard', [MahasiswaController::class, 'dashboard'])->middleware('auth')->name('dashboard');
    Route::get('/logbook', [MahasiswaController::class, 'logbook'])->middleware('auth')->name('logbook');
    Route::get('/jurnal', [MahasiswaController::class, 'jurnal'])->middleware('auth')->name('jurnal');
    Route::get('/nilai', [MahasiswaController::class, 'nilai'])->middleware('auth')->name('nilai');
    Route::get('/laporan', [MahasiswaController::class, 'laporan'])->middleware('auth')->name('laporan');
    Route::get('/profil', [MahasiswaController::class, 'profil'])->middleware('auth')->name('profil');
});
Route::get('/', function () {
    return view('welcome');
});
