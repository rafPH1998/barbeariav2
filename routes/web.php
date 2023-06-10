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
Route::get('/dashboard', DashboardController::class)->name('dashboard');

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
Route::resource('/schedules', ScheduleController::class)->only(['index', 'create', 'show', 'store']);

/*
*Route para avaliacoes
*/
Route::resource('/assessments', AssessmentsController::class)->only(['index', 'store', 'destroy']);

/*
*Route para perfil
*/
Route::resource('/profile', ProfileController::class)->only(['index', 'update']);