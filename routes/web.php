<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\FaultController;
use App\Http\Controllers\ArchiveController;
use App\Http\Controllers\UserController;

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
        Route::resource('/student', StudentController::class);
        Route::resource('/fault', FaultController::class);
        Route::resource('/archive', ArchiveController::class);
        Route::resource('/user', UserController::class);
        Route::post('/student/import', [StudentController::class, 'import']);
        Route::post('/logout', [DashboardController::class, 'logout']);
        Route::get('/report-student', [StudentController::class, 'report']);
        Route::get('/report-fault', [FaultController::class, 'report']);
        Route::get('/report-archive', [ArchiveController::class, 'report']);
    });
