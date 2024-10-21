<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\FaultController;
use App\Http\Controllers\ArchiveController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RuleController;
use App\Http\Controllers\KelasController;

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

//Landing Login
Route::get('/', [LandingController::class, 'index'])->name('login');
Route::post('/', [LandingController::class, 'authenticate']);

//Dashboard
Route::middleware('auth')
    ->prefix('/dashboard')
    ->group(function () {
        Route::get('/', [DashboardController::class, 'index']);

        // Hanya untuk Administrator dan Guru
        Route::get('/scoreboard', [DashboardController::class, 'scoreboard'])->middleware('role:Administrator,Guru');

        // Hanya untuk Administrator
        Route::resource('/class', KelasController::class)->middleware('role:Administrator');

        // Hanya untuk Administrator dan Guru
        Route::resource('/student', StudentController::class)->middleware('role:Administrator,Guru');
        Route::post('/student/import', [StudentController::class, 'import'])->middleware('role:Administrator');
        // Rute untuk menghapus semua siswa di kelas tertentu
        Route::get('/student/delete-class/{kelas}', [StudentController::class, 'deleteByClass'])->middleware('role:Administrator');

        // Hanya untuk Administrator dan Guru
        Route::resource('/archive', ArchiveController::class)->middleware('role:Administrator,Guru');
        Route::get('/report-archive', [ArchiveController::class, 'report'])->middleware('role:Administrator');

        // Hanya untuk Administrator
        Route::resource('/rule', RuleController::class)->middleware('role:Administrator');

        // Hanya untuk Administrator
        Route::resource('/user', UserController::class)->middleware('role:Administrator');
        Route::get('/profile/edit', [UserController::class, 'changepass'])->name('profile.edit');
        Route::put('/profile/{user}', [UserController::class, 'store_changepass'])->name('profile.store');
        // Hanya untuk Administrator (untuk semua laporan)
        Route::get('/report-student', [StudentController::class, 'report'])->middleware('role:Administrator');
        Route::get('/report-fault', [FaultController::class, 'report'])->middleware('role:Administrator');

        // Route yang bisa diakses oleh semua role
        Route::resource('/fault', FaultController::class);
        Route::get('/student/select/{kelas}', [StudentController::class, 'selectByKelas']);
        Route::post('/logout', [DashboardController::class, 'logout']);
    });
