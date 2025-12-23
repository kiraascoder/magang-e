<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\RoleLoginController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\MahasiswaController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    Route::get('/login', [RoleLoginController::class, 'show'])->name('login');
    Route::post('/login', [RoleLoginController::class, 'login'])->name('login.post');
});

Route::post('/logout', [RoleLoginController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| ROOT
|--------------------------------------------------------------------------
*/
Route::get('/', fn() => view('welcome'))->name('home');

/*
|--------------------------------------------------------------------------
| ADMIN (role:admin)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'role:admin'])
    ->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/users', [AdminController::class, 'users'])->name('users');
        Route::get('/instansi', [AdminController::class, 'instansi'])->name('instansi');
        Route::get('/periode', [AdminController::class, 'periode'])->name('periode');
        Route::get('/penempatan', [AdminController::class, 'penempatan'])->name('penempatan');
        Route::get('/users/create', [AdminController::class, 'usersCreate'])->name('users.create');
        Route::post('/users', [AdminController::class, 'usersStore'])->name('users.store');
        Route::get('/users/{user}/edit', [AdminController::class, 'usersEdit'])->name('users.edit');
        Route::put('/users/{user}', [AdminController::class, 'usersUpdate'])->name('users.update');
        Route::delete('/users/{user}', [AdminController::class, 'usersDestroy'])->name('users.destroy');
        Route::get('/instansi/create', [AdminController::class, 'instansiCreate'])->name('instansi.create');
        Route::post('/instansi', [AdminController::class, 'instansiStore'])->name('instansi.store');
        Route::get('/instansi/{instansi}/edit', [AdminController::class, 'instansiEdit'])->name('instansi.edit');
        Route::put('/instansi/{instansi}', [AdminController::class, 'instansiUpdate'])->name('instansi.update');
        Route::delete('/instansi/{instansi}', [AdminController::class, 'instansiDestroy'])->name('instansi.destroy');
        Route::get('/periode/create', [AdminController::class, 'periodeCreate'])->name('periode.create');
        Route::post('/periode', [AdminController::class, 'periodeStore'])->name('periode.store');
        Route::get('/periode/{periode}/edit', [AdminController::class, 'periodeEdit'])->name('periode.edit');
        Route::put('/periode/{periode}', [AdminController::class, 'periodeUpdate'])->name('periode.update');
        Route::delete('/periode/{periode}', [AdminController::class, 'periodeDestroy'])->name('periode.destroy');
        Route::get('/penempatan/create', [AdminController::class, 'penempatanCreate'])->name('penempatan.create');
        Route::post('/penempatan', [AdminController::class, 'penempatanStore'])->name('penempatan.store');
        Route::get('/penempatan/{penempatan}/edit', [AdminController::class, 'penempatanEdit'])->name('penempatan.edit');
        Route::put('/penempatan/{penempatan}', [AdminController::class, 'penempatanUpdate'])->name('penempatan.update');
        Route::delete('/penempatan/{penempatan}', [AdminController::class, 'penempatanDestroy'])->name('penempatan.destroy');
    });

/*
|--------------------------------------------------------------------------
| DOSEN (role:dosen)
|--------------------------------------------------------------------------
*/
Route::prefix('dosen')->name('dosen.')->middleware(['auth', 'role:dosen'])->group(function () {
    Route::get('/dashboard', [DosenController::class, 'dashboard'])->name('dashboard');
    Route::get('/mahasiswa', [DosenController::class, 'mahasiswa'])->name('mahasiswa');
    Route::get('/nilai', [DosenController::class, 'nilai'])->name('nilai');
    Route::get('/laporan', [DosenController::class, 'laporan'])->name('laporan');
    Route::get('/logbook', [DosenController::class, 'logbookIndex'])->name('logbook');
    Route::get('/logbook/{logbook}', [DosenController::class, 'logbookShow'])->name('logbook.show');
    Route::patch('/logbook/{logbook}/approve', [DosenController::class, 'logbookApprove'])->name('logbook.approve');
    Route::patch('/logbook/{logbook}/reject', [DosenController::class, 'logbookReject'])->name('logbook.reject');
    Route::get('/jurnal', [DosenController::class, 'jurnalIndex'])->name('jurnal');
    Route::get('/jurnal/{pekan}', [DosenController::class, 'jurnalShow'])->name('jurnal.show');
    Route::patch('/jurnal/{pekan}/approve', [DosenController::class, 'jurnalApprove'])->name('jurnal.approve');
    Route::patch('/jurnal/{pekan}/reject', [DosenController::class, 'jurnalReject'])->name('jurnal.reject');

    // Laporan Akhir 
    Route::get('/laporan-akhir', [DosenController::class, 'laporanAkhirIndex'])->name('laporan_akhir');
    Route::get('/laporan-akhir/{laporan}', [DosenController::class, 'laporanAkhirShow'])->name('laporan_akhir.show');
    Route::patch('/laporan-akhir/{laporan}/approve', [DosenController::class, 'laporanAkhirApprove'])->name('laporan_akhir.approve');
    Route::patch('/laporan-akhir/{laporan}/reject', [DosenController::class, 'laporanAkhirReject'])->name('laporan_akhir.reject');
});


/*
|--------------------------------------------------------------------------
| MAHASISWA (role:mahasiswa)
|--------------------------------------------------------------------------
*/
Route::prefix('mahasiswa')
    ->name('mahasiswa.')
    ->middleware(['auth', 'role:mahasiswa'])
    ->group(function () {

        Route::get('/dashboard', [MahasiswaController::class, 'dashboard'])->name('dashboard');

        // LOGBOOK
        Route::get('/logbook', [MahasiswaController::class, 'logbookIndex'])->name('logbook');
        Route::get('/logbook/create', [MahasiswaController::class, 'logbookCreate'])->name('logbook.create');
        Route::post('/logbook', [MahasiswaController::class, 'logbookStore'])->name('logbook.store');
        Route::get('/logbook/{logbook}/edit', [MahasiswaController::class, 'logbookEdit'])->name('logbook.edit');
        Route::put('/logbook/{logbook}', [MahasiswaController::class, 'logbookUpdate'])->name('logbook.update');
        Route::delete('/logbook/{logbook}', [MahasiswaController::class, 'logbookDestroy'])->name('logbook.destroy');
        Route::patch('/logbook/{logbook}/submit', [MahasiswaController::class, 'logbookSubmit'])->name('logbook.submit');

        // JURNAL
        Route::get('/jurnal', [MahasiswaController::class, 'jurnalIndex'])->name('jurnal');
        Route::get('/jurnal/create', [MahasiswaController::class, 'jurnalCreate'])->name('jurnal.create');
        Route::post('/jurnal', [MahasiswaController::class, 'jurnalStore'])->name('jurnal.store');
        Route::get('/jurnal/{pekan}', [MahasiswaController::class, 'jurnalShow'])->name('jurnal.show');
        Route::put('/jurnal/harian/{harian}', [MahasiswaController::class, 'jurnalHarianUpdate'])->name('jurnal.harian.update');
        Route::patch('/jurnal/{pekan}/submit', [MahasiswaController::class, 'jurnalSubmit'])->name('jurnal.submit');
        Route::delete('/jurnal/{pekan}', [MahasiswaController::class, 'jurnalDestroy'])->name('jurnal.destroy');

        // MENU LAIN
        Route::get('/nilai', [MahasiswaController::class, 'nilai'])->name('nilai');
        Route::get('/laporan', [MahasiswaController::class, 'laporan'])->name('laporan');
        Route::get('/profil', [MahasiswaController::class, 'profil'])->name('profil');

        // Laporan Akhir 
        Route::get('/laporan-akhir', [MahasiswaController::class, 'laporanAkhirIndex'])->name('laporan_akhir');
        Route::get('/laporan-akhir/upload', [MahasiswaController::class, 'laporanAkhirCreate'])->name('laporan_akhir.create');
        Route::post('/laporan-akhir', [MahasiswaController::class, 'laporanAkhirStore'])->name('laporan_akhir.store');
        Route::delete('/laporan-akhir/{laporan}', [MahasiswaController::class, 'laporanAkhirDestroy'])->name('laporan_akhir.destroy');
        Route::patch('/laporan-akhir/{laporan}/submit', [MahasiswaController::class, 'laporanAkhirSubmit'])->name('laporan_akhir.submit');
    });
