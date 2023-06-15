<?php

use App\Http\Controllers\{
    AssessmentsController,
    DashboardController,
    HomeController,
    ProfileController,
    ScheduleController
};

use App\Http\Controllers\Auth\{
    RegisterController,
    AuthController
};

use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('index');

/*
*Route para dashboard
*/
Route::get('/dashboard', DashboardController::class)->name('dashboard')->middleware('auth');

/*
*Route para login
*/
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'auth'])->name('auth');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
*Route para Registro
*/
Route::get('/register', [RegisterController::class, 'register'])->name('register');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

/*
*Route para agendamentos
*/
Route::middleware('auth')->group(function() {
    Route::get('/schedules/my-schedules', [ScheduleController::class, 'mySchedules'])->name('schedules.mySchedules');
    Route::get('/schedules/type-service', [ScheduleController::class, 'typeForm'])->name('schedules.typeForm');

    Route::get('/create/{type}', [ScheduleController::class, 'create'])
        ->name('schedules.create')
        ->where('type', 'corte|corte_barba');
        
    Route::resource('/schedules', ScheduleController::class)->only(['index', 'store']);
}); 
/*
*Route para avaliacoes
*/
Route::resource('/assessments', AssessmentsController::class)->only(['index', 'store', 'destroy']);

/*
*Route para perfil
*/
Route::resource('/profile', ProfileController::class)->only(['index', 'update']);