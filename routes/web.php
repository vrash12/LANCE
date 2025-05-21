<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\QueueController;
use App\Http\Controllers\WorkScheduleController;
use App\Http\Controllers\PatientRecordController;
use App\Http\Controllers\OpdFormController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\PatientTrendController;
use App\Http\Controllers\EncoderOpdFormController;
use App\Http\Controllers\ChangePasswordController;

// 1) Authentication routes (login, register if enabled, password resets)
Auth::routes();
Route::get('/', fn() => redirect()->route('login'));

Route::get('queue/display', [QueueController::class,'selectDepartment'])
     ->name('queue.display.select')
     ->middleware('auth','role:admin,encoder,patient');

// 4) Full-screen display (any logged-in role)
Route::get('queue/{department}/display', [QueueController::class,'display'])
     ->name('queue.display')
     ->middleware('auth','role:admin,encoder,patient');

// 5) Live-status JSON endpoint (any logged-in role)
Route::get('queue/{department}/status', [QueueController::class,'status'])
     ->name('queue.status')
     ->middleware('auth','role:admin,encoder,patient');

Route::middleware('auth')->group(function () {

    // 3a) Change Password (shared by all roles)
    Route::get('password/change',   [ChangePasswordController::class, 'show'])
         ->name('password.change');
    Route::post('password/change',  [ChangePasswordController::class, 'update'])
         ->name('password.change.update');


Route::get('queue/history', [QueueController::class,'history'])
     ->name('queue.history');
    // 4) ADMIN ONLY
    Route::middleware('role:admin')->group(function () {
        // Admin dashboard
        Route::get('/home', [HomeController::class,'index'])->name('home');
        Route::patch('queue/{department}/serve-next-admin',
    [QueueController::class,'serveNextAdmin'])
  ->name('queue.serveNext.admin')
  ->middleware('auth','role:admin');

   Route::get('queue/{department}/display/admin',
    [QueueController::class,'adminDisplay'])
  ->name('queue.display.admin');
       
        Route::patch  ('queue/{department}/serve-next',    [QueueController::class,'serveNext'])->name('queue.serveNext');
        Route::delete ('queue/{department}/tokens/{token}',[QueueController::class,'destroy'])->name('queue.tokens.destroy');

        // Full admin queue management
        Route::get    ('queue',            [QueueController::class,'departments'])->name('queue.index');
        Route::get    ('queue/{department}',[QueueController::class,'show'])->name('queue.show');
        Route::get    ('queue/{department}/tokens/{token}/edit',[QueueController::class,'edit'])->name('queue.tokens.edit');
        Route::patch  ('queue/{department}/tokens/{token}',     [QueueController::class,'update'])->name('queue.tokens.update');
        Route::post   ('queue/{department}/tokens',             [QueueController::class,'store'])->name('queue.store');

        // User & patient CRUD + exports
        Route::resource('users', UserController::class);
        Route::resource('patients', PatientRecordController::class);
        Route::get('patients/{patient}/export.xlsx',[PatientRecordController::class,'exportExcel'])->name('patients.export.excel');
        Route::get('patients/{patient}/export.pdf', [PatientRecordController::class,'exportPdf'  ])->name('patients.export.pdf');

        // OPD form export
        Route::get('opd_forms/{opd_form}/export.pdf',[OpdFormController::class,'exportPdf'])->name('opd_forms.export.pdf');

        // Trends
        Route::get ('trends',           [PatientTrendController::class,'index'])         ->name('trends.index');
        Route::post('trends/request',   [PatientTrendController::class,'requestInsight'])->name('trends.request');
        Route::get ('trends/export.xlsx',[PatientTrendController::class,'exportExcel'])  ->name('trends.excel');
        Route::get ('trends/export.pdf', [PatientTrendController::class,'exportPdf'])    ->name('trends.pdf');

        // Reports
        Route::prefix('reports')->name('reports.')->group(function () {
            Route::get('/',           [ReportController::class,'index'])      ->name('index');
            Route::post('generate',   [ReportController::class,'generate'])   ->name('generate');
            Route::get('verify',      [ReportController::class,'verify'])     ->name('verify');
            Route::get('export.xlsx', [ReportController::class,'exportExcel'])->name('excel');
            Route::get('export.pdf',  [ReportController::class,'exportPdf'])  ->name('pdf');
        });

        // Work schedules & OPD forms
        Route::resource('schedules', WorkScheduleController::class);
        Route::resource('opd_forms', OpdFormController::class);
    });

    // 5) Shared resource: departments
    Route::resource('departments', DepartmentController::class);

    // 6) ENCODER ONLY
    Route::middleware('role:encoder')->prefix('encoder')->name('encoder.opd.')->group(function(){
        Route::get('/',       [EncoderOpdFormController::class,'index']) ->name('index');
        Route::get('create',  [EncoderOpdFormController::class,'create'])->name('create');
        Route::post('/',      [EncoderOpdFormController::class,'store']) ->name('store');
        Route::get('{opdSubmission}', [EncoderOpdFormController::class,'show'])->name('show');
    });

    // 7) PATIENT ONLY
    Route::middleware('role:patient')->group(function () {
        // Patient “home”
            Route::view('/dashboard', 'patient.dashboard')
         ->name('patient.dashboard');

        // Join the queue
        Route::get ('/my-queue',                    [QueueController::class,'patientQueue'])     ->name('patient.queue');
        Route::post('/my-queue/{department}/tokens', [QueueController::class,'patientStore'])     ->name('patient.queue.store');
    });
});
