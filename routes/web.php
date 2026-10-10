<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\CompanyAuthController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\StudentJobController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\StudentController as AdminStudentController;
use App\Http\Controllers\Admin\JobController as AdminJobController;
use App\Http\Controllers\Admin\ApplicationController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/student/register',[StudentController::class,'register'])->name('student.register');
Route::post('/student/store',[StudentController::class,'store'])->name('student.store');

Route::get('/student/login',[StudentController::class,'showLogin'])->name('student.login');
Route::post('/student/login',[StudentController::class,'login'])->name('student.login.submit');

Route::get('/student/dashboard', [StudentController::class, 'dashboard'])->middleware('student')->name('student.dashboard');

Route::get('/student/logout', [StudentController::class, 'logout'])->middleware('student')->name('student.logout');

//company register
// Route::get('/company/register', [CompanyAuthController::class, 'showRegister']);
// Route::post('/company/register', [CompanyAuthController::class, 'register']);

// company login
// Route::get('/company/login', [CompanyAuthController::class, 'showLogin']);
// Route::post('/company/login', [CompanyAuthController::class, 'login']);

// Dashboard
// Route::get('/company/dashboard', [CompanyAuthController::class, 'dashboard']);

//logout.
// Route::post('/company/logout', [CompanyAuthController::class, 'logout']);


// Route::get('/company/dashboard', [CompanyAuthController::class, 'dashboard'])->middleware('company.auth');

// Route::middleware('company.auth')->group(function () {

//     Route::get('/company/profile', [CompanyAuthController::class, 'profile'])
//     ->name('company.profile');

//     Route::get('/company/dashboard', [CompanyAuthController::class, 'dashboard']);

//     Route::get('/company/job/create', [JobController::class, 'create'])->middleware('company.auth');

//     Route::post('/company/job/store', [JobController::class, 'store'])->middleware('company.auth');

//     Route::get('/company/jobs',[JobController::class,'index'])->name('company.jobs');

//     Route::get('/company/job/edit/{id}', [JobController::class, 'edit'])->name('job.edit');

//     Route::put('/company/job/update/{id}', [JobController::class, 'update'])->name('job.update');

//     Route::delete('/company/job/delete/{id}', [JobController::class, 'destroy'])->name('job.delete');

// });


//company register
Route::get('/company/register', [CompanyAuthController::class, 'showRegister']);
Route::post('/company/register', [CompanyAuthController::class, 'register']);

// company login
Route::get('/company/login', [CompanyAuthController::class, 'showLogin']);
Route::post('/company/login', [CompanyAuthController::class, 'login']);

//logout
Route::post('/company/logout', [CompanyAuthController::class, 'logout']);


Route::middleware('company.auth')->group(function () {

    // Dashboard
    Route::get('/company/dashboard', [CompanyAuthController::class, 'dashboard'])
        ->name('company.dashboard');

    // Profile
    Route::get('/company/profile', [CompanyAuthController::class, 'profile'])
        ->name('company.profile');

    // Create Job
    Route::get('/company/job/create', [JobController::class, 'create']);

    // Store Job
    Route::post('/company/job/store', [JobController::class, 'store']);

    // Manage Jobs
    Route::get('/company/jobs', [JobController::class, 'index'])
        ->name('company.jobs');

    // Edit Job
    Route::get('/company/job/edit/{id}', [JobController::class, 'edit'])
        ->name('job.edit');

    // Update Job
    Route::put('/company/job/update/{id}', [JobController::class, 'update'])
        ->name('job.update');

    // Delete Job
    Route::delete('/company/job/delete/{id}', [JobController::class, 'destroy'])
        ->name('job.delete');
});

Route::middleware('student')->group(function (){

    // View Jobs
    Route::get('/students/jobs',
        [StudentJobController::class, 'index'])
        ->name('student.jobs');


    // Job Details
    Route::get('/student/jobs/{id}',
        [StudentJobController::class, 'show'])
        ->name('student.job.details');


    // Apply Job
    Route::post('/student/jobs/{id}/apply',
        [StudentJobController::class, 'apply'])
        ->name('student.job.apply');


    // Resume Upload Page
    Route::get('/student/jobs/{id}/resume',
        [StudentJobController::class, 'resumeUpload'])
        ->name('student.resume.upload');


    // Store Resume
    Route::post('/student/jobs/{id}/resume',
        [StudentJobController::class, 'uploadResume'])
        ->name('student.resume.store');

    // My Application
    Route::get('/student/applications',
    [StudentJobController::class, 'myApplications'])
    ->name('student.applications');

});

// Admin Authentication
Route::prefix('admin')->group(function () {

    // Login
    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('admin.login');

    Route::post('/login', [AuthController::class, 'login'])
        ->name('admin.login.submit');

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('admin.logout');

    Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('admin')
    ->name('admin.dashboard');

    // Company Management
Route::get('/companies', [CompanyController::class, 'index'])
    ->middleware('admin')
    ->name('admin.companies');

Route::patch('/companies/{id}/approve', [CompanyController::class, 'approve'])
    ->middleware('admin')
    ->name('admin.companies.approve');

Route::patch('/companies/{id}/reject', [CompanyController::class, 'reject'])
    ->middleware('admin')
    ->name('admin.companies.reject');

    // Student Management
Route::get('/students', [AdminStudentController::class, 'index'])
    ->middleware('admin')
    ->name('admin.students');

Route::get('/students/{id}', [AdminStudentController::class, 'show'])
    ->middleware('admin')
    ->name('admin.students.show');

Route::delete('/students/{id}', [AdminStudentController::class, 'destroy'])
    ->middleware('admin')
    ->name('admin.students.delete');

    // Job Management
Route::get('/jobs', [AdminJobController::class, 'index'])
    ->middleware('admin')
    ->name('admin.jobs');

Route::get('/jobs/{id}', [AdminJobController::class, 'show'])
    ->middleware('admin')
    ->name('admin.jobs.show');

Route::delete('/jobs/{id}', [AdminJobController::class, 'destroy'])
    ->middleware('admin')
    ->name('admin.jobs.delete');

    Route::get('/applications', [ApplicationController::class, 'index'])
    ->middleware('admin')
    ->name('admin.applications');

Route::get('/applications/{id}', [ApplicationController::class, 'show'])
    ->middleware('admin')
    ->name('admin.applications.show');

Route::delete('/applications/{id}', [ApplicationController::class, 'destroy'])
    ->middleware('admin')
    ->name('admin.applications.delete');

});









