<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\QueueController;
use App\Http\Controllers\WorkScheduleController;
use App\Http\Controllers\PatientRecordController;
use App\Http\Controllers\OpdFormController;
use App\Http\Controllers\OpdSubmissionController;
use App\Http\Controllers\FollowUpOpdFormController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\PatientTrendController;
use App\Http\Controllers\EncoderOpdFormController;
use App\Http\Controllers\ObOpdFormController;
use App\Http\Controllers\EncoderPatientRecordController;
use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\HighRiskOpdFormController;

// 1) Authentication / root redirect
Auth::routes();
Route::get('/', fn() => redirect()->route('login'));

Route::get('queue/{token}/print',  // <-- NEW
    [QueueController::class,'printReceipt'])
    ->middleware('auth')
    ->name('queue.tokens.print');

Route::get('patients/search', [PatientRecordController::class, 'search'])
     ->middleware('auth','role:admin,encoder')
     ->name('patients.search');
     
Route::middleware('auth')->prefix('ob-opd/forms')->group(function () {
    Route::get('/',                [ObOpdFormController::class,'index'])   ->name('ob-opd-forms.index');
    Route::get('create',           [ObOpdFormController::class,'create'])  ->name('ob-opd-forms.create');
    Route::post('/',               [ObOpdFormController::class,'store'])   ->name('ob-opd-forms.store');
    Route::get('{submission}',     [ObOpdFormController::class,'show'])    ->name('ob-opd-forms.show');
    Route::get('{submission}/edit',[ObOpdFormController::class,'edit'])    ->name('ob-opd-forms.edit');
    Route::put('{submission}',     [ObOpdFormController::class,'update'])  ->name('ob-opd-forms.update');
    Route::delete('{submission}',  [ObOpdFormController::class,'destroy']) ->name('ob-opd-forms.destroy');

});

// 3) Public queue display & status
Route::middleware(['auth','role:admin,encoder,patient'])->group(function(){
    Route::get('queue/display',             [QueueController::class,'selectDepartment'])
         ->name('queue.display.select');
    Route::get('queue/{department}/display',[QueueController::class,'display'])
         ->name('queue.display');
    Route::get('queue/{department}/status', [QueueController::class,'status'])
         ->name('queue.status');
});

// 4) Shared authenticated routes
Route::middleware('auth')->group(function () {
    // OPD submission detail
    Route::get('opd_submissions/{submission}',
         [OpdSubmissionController::class,'show'])
         ->name('opd_submissions.show');

    // Password change
    Route::get('password/change', [ChangePasswordController::class,'show'])
         ->name('password.change');
    Route::post('password/change', [ChangePasswordController::class,'update'])
         ->name('password.change.update');

    // Queue history
    Route::get('queue/history', [QueueController::class,'history'])
         ->name('queue.history');

    // 5A) Admin-only
    Route::middleware('role:admin')->group(function () {
        // Dashboard
        Route::get('/home', [HomeController::class,'index'])->name('home');

        // Queue admin controls
        Route::patch('queue/{department}/serve-next-admin',
            [QueueController::class,'serveNextAdmin'])
            ->name('queue.serveNext.admin');
        Route::get('queue/{department}/display/admin',
            [QueueController::class,'adminDisplay'])
            ->name('queue.display.admin');
        Route::patch('queue/{department}/serve-next',
            [QueueController::class,'serveNext'])
            ->name('queue.serveNext');
        Route::delete('queue/{department}/tokens/{token}',
            [QueueController::class,'destroy'])
            ->name('queue.tokens.destroy');
        Route::get('queue', [QueueController::class,'departments'])
            ->name('queue.index');
        Route::get('queue/{department}', [QueueController::class,'show'])
            ->name('queue.show');
        Route::get('queue/{department}/tokens/{token}/edit',
            [QueueController::class,'edit'])
            ->name('queue.tokens.edit');
        Route::patch('queue/{department}/tokens/{token}',
            [QueueController::class,'update'])
            ->name('queue.tokens.update');
        Route::post('queue/{department}/tokens',
            [QueueController::class,'store'])
            ->name('queue.store');

        // User & patient CRUD + exports
        Route::resource('users', UserController::class);
        Route::resource('patients', PatientRecordController::class);
        Route::get('patients/{patient}/export.xlsx',
            [PatientRecordController::class,'exportExcel'])
            ->name('patients.export.excel');
        Route::get('patients/{patient}/export.pdf',
            [PatientRecordController::class,'exportPdf'])
            ->name('patients.export.pdf');

        // OPD form templates (admin)
        Route::resource('opd_forms', OpdFormController::class);
        Route::get('opd_forms/{opd_form}/export.pdf',
            [OpdFormController::class,'exportPdf'])
            ->name('opd_forms.export.pdf');

        // Follow-up form templates
        Route::resource('follow-up-forms', FollowUpOpdFormController::class);

        // Trends & reports
        Route::get('trends', [PatientTrendController::class,'index'])
             ->name('trends.index');
        Route::post('trends/request',
            [PatientTrendController::class,'requestInsight'])
            ->name('trends.request');
        Route::get('trends/export.xlsx',
            [PatientTrendController::class,'exportExcel'])
            ->name('trends.excel');
        Route::get('trends/export.pdf',
            [PatientTrendController::class,'exportPdf'])
            ->name('trends.pdf');
        Route::prefix('reports')->name('reports.')->group(function () {
            Route::get('/',           [ReportController::class,'index'])->name('index');
            Route::post('generate',   [ReportController::class,'generate'])->name('generate');
            Route::get('verify',      [ReportController::class,'verify'])->name('verify');
            Route::get('export.xlsx', [ReportController::class,'exportExcel'])->name('excel');
            Route::get('export.pdf',  [ReportController::class,'exportPdf'])->name('pdf');
        });

        // Work schedules
        Route::resource('schedules', WorkScheduleController::class);
    });

    // 5B) Encoder-only
    Route::middleware('role:encoder')->prefix('encoder')->name('encoder.')->group(function () {
        Route::get('/', [EncoderPatientRecordController::class,'index'])->name('index');

        // Encoder OPD filling
        Route::get('opd',         [EncoderOpdFormController::class,'index'])->name('opd.index');
        Route::get('opd/create',  [EncoderOpdFormController::class,'create'])->name('opd.create');
        Route::post('opd',        [EncoderOpdFormController::class,'store'])->name('opd.store');
        Route::get('opd/{profile}',     [EncoderOpdFormController::class,'show'])->name('opd.show');
        Route::get('opd/{profile}/edit',[EncoderOpdFormController::class,'edit'])->name('opd.edit');
        Route::put('opd/{profile}',     [EncoderOpdFormController::class,'update'])->name('opd.update');
        Route::delete('opd/{profile}',  [EncoderOpdFormController::class,'destroy'])->name('opd.destroy');
    });

    // 6) Fill & submit any OPD template
    Route::get('opd_forms/{form}/fill',
         [OpdFormController::class,'fill'])
         ->middleware('role:admin,encoder,patient')
         ->name('opd_forms.fill');
    Route::post('opd_forms/{form}/submit',
         [OpdFormController::class,'submit'])
         ->middleware('role:admin,encoder,patient')
         ->name('opd_forms.submit');

    // 7) Work schedule detail
    Route::get('/schedules/{schedule}/show',
         [WorkScheduleController::class,'show'])
         ->name('schedules.show');
});

  Route::prefix('opd_forms/follow_up')->name('follow-up-opd-forms.')->controller(FollowUpOpdFormController::class)->group(function(){
        Route::get('/',          'index')   ->name('index');
        Route::get('create',     'create')  ->name('create');
        Route::post('/',         'store')   ->name('store');
        Route::get('{submission}','show')   ->name('show');
        Route::get('{submission}/edit','edit')->name('edit');
        Route::put('{submission}','update')  ->name('update');
        Route::delete('{submission}','destroy')->name('destroy');
    });

Route::middleware('auth')->name('high-risk-opd-forms.')->prefix('high-risk-opd-forms')->group(function(){
    Route::get    ('/',           [HighRiskOpdFormController::class,'index'])->name('index');
    Route::get    ('/create',     [HighRiskOpdFormController::class,'create'])->name('create');
    Route::post   ('/',           [HighRiskOpdFormController::class,'store'])->name('store');
    Route::get    ('/{submission}',     [HighRiskOpdFormController::class,'show'])->name('show');
    Route::get    ('/{submission}/edit',[HighRiskOpdFormController::class,'edit'])->name('edit');
    Route::put    ('/{submission}',     [HighRiskOpdFormController::class,'update'])->name('update');
    Route::delete ('/{submission}',     [HighRiskOpdFormController::class,'destroy'])->name('destroy');
});

