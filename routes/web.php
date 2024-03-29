<?php

use App\Http\Controllers\{
    AssessmentsController,
    BarberController,
    DashboardController,
    HomeController,
    ProfileController,
    CanceledsSchedule,
    EmployeController,
    ForgotPasswordController,
    ScheduleController,
    ServiceSchedule,
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
 * Route para recuperamento de senha
 */
Route::get('forgot-password', [ForgotPasswordController::class, 'forgotPassword'])->name('forgot.password');
Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('forgot.password-send-link');
Route::get('reset-password/{token}', [ForgotPasswordController::class, 'resetPassword'])->name('password.reset');
Route::post('reset-password', [ForgotPasswordController::class, 'updatePassword'])->name('password.update');


/*
*Route para agendamentos
*/
Route::middleware('auth')->group(function() {
    Route::get('/schedules/calendar', [ScheduleController::class, 'calendar'])->name('schedules.calendar');
    Route::get('/schedules/my-schedules', [ScheduleController::class, 'mySchedules'])->name('schedules.mySchedules');
    Route::get('/schedules/type-service', [ScheduleController::class, 'typeForm'])->name('schedules.typeForm');
    Route::get('/schedules/get-dates', [ScheduleController::class, 'getDates'])->name('schedules.getDates');
    Route::get('/schedules/get-barbers', [ScheduleController::class, 'getBarbers'])->name('schedules.getBarbers');
    
    Route::get('/create/{type}', [ScheduleController::class, 'create'])->name('schedules.create');
 
    
    Route::resource('/schedules', ScheduleController::class)->only(['index', 'store']);
    Route::post('/schedules/canceleds', CanceledsSchedule::class)->name('canceled');

    /*
    *Route para dashboard
    */
    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    /*
    *Route para barbeiros
    */
    Route::get('/barbers', [BarberController::class, 'index'])->name('barbers');
    Route::post('/barbers', [BarberController::class, 'store'])->name('barbers');

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

    Route::get('/services', [ServiceSchedule::class, 'index'])->name('services.index');
    Route::get('/services/create', [ServiceSchedule::class, 'create'])->name('services.create');
    Route::post('/services/create', [ServiceSchedule::class, 'store'])->name('services.create');
    Route::delete('/services/{id}', [ServiceSchedule::class, 'destroy'])->name('services.delete');
    
}); 







