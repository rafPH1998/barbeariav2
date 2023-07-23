<?php

use App\Http\Controllers\{
    AssessmentsController,
    DashboardController,
    HomeController,
    ProfileController,
    CanceledsSchedule,
    EmployeController,
    ForgotPasswordController,
    ScheduleController,
    UserController
};

use App\Http\Controllers\Auth\{
    RegisterController,
    AuthController
};

use Illuminate\Support\Facades\Route;

/*
*Route para Home da pagina
*/
Route::get('/', HomeController::class)->name('index');

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

/**
 * Route para registro e recuperamento de senha
 */
Route::get('forgot-password', [ForgotPasswordController::class, 'forgotPassword'])->name('forgot.password');
Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('forgot.password-send-link');
Route::get('reset-password/{token}', [ForgotPasswordController::class, 'resetPassword'])->name('password.reset');
Route::post('reset-password', [ForgotPasswordController::class, 'updatePassword'])->name('password.update');


/*
*Route para agendamentos
*/
Route::middleware('auth')->group(function() {
    Route::get('/schedules/my-schedules', [ScheduleController::class, 'mySchedules'])->name('schedules.mySchedules');
    Route::get('/schedules/type-service', [ScheduleController::class, 'typeForm'])->name('schedules.typeForm');
    Route::get('/schedules/get-dates', [ScheduleController::class, 'getDates'])->name('schedules.getDates');
    Route::get('/schedules/get-barbers', [ScheduleController::class, 'getBarbers'])->name('schedules.getBarbers');
    
    Route::get('/create/{type}', [ScheduleController::class, 'create'])
            ->name('schedules.create')
            ->where('type', 'corte|corte_barba');
    
    Route::resource('/schedules', ScheduleController::class)->only(['index', 'store']);
    Route::post('/schedules/canceleds', CanceledsSchedule::class)->name('canceled');

    /*
    *Route para dashboard
    */
    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    /*
    *Route para dashboard
    */
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users-birthday', [UserController::class, 'birthday'])->name('users.birthday');
    Route::get('/users-missing', [UserController::class, 'missing'])->name('users.missing');

    /*
    *Route para avaliacoes
    */
    Route::resource('/assessments', AssessmentsController::class)->only(['index', 'store', 'destroy']);

    /*
    *Route para perfil
    */
    Route::post('/profile', [ProfileController::class, 'store']);
    Route::resource('/profile', ProfileController::class)->only('index');

     /*
    *Route para funcionarios
    */
    Route::resource('/employees', EmployeController::class)->except(['show', 'edit', 'create']);
    
}); 







