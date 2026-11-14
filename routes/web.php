<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\CompanyAuthController;
use App\Http\Controllers\CompanyApplicantController;
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

Route::post('/student/logout', [StudentController::class, 'logout'])->middleware('student')->name('student.logout');

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
Route::get('/company/register', [CompanyAuthController::class, 'showRegister'])->name('company.register');
Route::post('/company/register', [CompanyAuthController::class, 'register'])->name('company.register.submit');

// company login
Route::get('/company/login', [CompanyAuthController::class, 'showLogin'])->name('company.login');
Route::post('/company/login', [CompanyAuthController::class, 'login'])->name('company.login.submit');

//logout
Route::post('/company/logout', [CompanyAuthController::class, 'logout'])->name('company.logout');


Route::middleware('company.auth')->group(function () {

    // Dashboard
    Route::get('/company/dashboard', [CompanyAuthController::class, 'dashboard'])
        ->name('company.dashboard');

    // Profile
    Route::get('/company/profile', [CompanyAuthController::class, 'profile'])
        ->name('company.profile');

    Route::put('/company/profile', [CompanyAuthController::class, 'updateProfile'])
        ->name('company.profile.update');

    Route::put('/company/password', [CompanyAuthController::class, 'updatePassword'])
        ->name('company.password.update');

    // Create Job
    Route::get('/company/job/create', [JobController::class, 'create'])
        ->name('company.job.create');

    // Store Job
    Route::post('/company/job/store', [JobController::class, 'store'])
        ->name('company.job.store');

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

    // Applicant Management
    Route::get('/company/applications', [CompanyApplicantController::class, 'index'])
        ->name('company.applications');

    Route::get('/company/jobs/{jobId}/applications', [CompanyApplicantController::class, 'jobApplicants'])
        ->name('company.job.applications');

    Route::get('/company/applications/{id}', [CompanyApplicantController::class, 'show'])
        ->name('company.application.show');

    Route::patch('/company/applications/{id}/status', [CompanyApplicantController::class, 'updateStatus'])
        ->name('company.application.updateStatus');
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

    // Profile Management
    Route::get('/student/profile', [StudentController::class, 'profile'])
        ->name('student.profile');
    Route::put('/student/profile', [StudentController::class, 'updateProfile'])
        ->name('student.profile.update');
    Route::put('/student/password', [StudentController::class, 'updatePassword'])
        ->name('student.password.update');

});

// Protected Resume Download Route (Admin, Student owner, Company job-owner)
Route::get('/applications/{id}/resume', [StudentJobController::class, 'downloadResume'])
    ->name('applications.resume.download');

// Admin Routes
Route::prefix('admin')->group(function () {

    // Guest Admin Routes
    Route::get('/login', [AuthController::class, 'showLogin'])->name('admin.login');
    Route::post('/login', [AuthController::class, 'login'])->name('admin.login.submit');

    // Protected Admin Routes
    Route::middleware('admin')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout'])->name('admin.logout');
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

        // Company Management
        Route::get('/companies', [CompanyController::class, 'index'])->name('admin.companies');
        Route::get('/companies/{id}', [CompanyController::class, 'show'])->name('admin.companies.show');
        Route::patch('/companies/{id}/approve', [CompanyController::class, 'approve'])->name('admin.companies.approve');
        Route::patch('/companies/{id}/reject', [CompanyController::class, 'reject'])->name('admin.companies.reject');

        // Student Management
        Route::get('/students', [AdminStudentController::class, 'index'])->name('admin.students');
        Route::get('/students/{id}', [AdminStudentController::class, 'show'])->name('admin.students.show');
        Route::delete('/students/{id}', [AdminStudentController::class, 'destroy'])->name('admin.students.delete');

        // Job Management
        Route::get('/jobs', [AdminJobController::class, 'index'])->name('admin.jobs');
        Route::get('/jobs/{id}', [AdminJobController::class, 'show'])->name('admin.jobs.show');
        Route::delete('/jobs/{id}', [AdminJobController::class, 'destroy'])->name('admin.jobs.delete');

        // Application Management
        Route::get('/applications', [ApplicationController::class, 'index'])->name('admin.applications');
        Route::get('/applications/{id}', [ApplicationController::class, 'show'])->name('admin.applications.show');
        Route::delete('/applications/{id}', [ApplicationController::class, 'destroy'])->name('admin.applications.delete');
    });

});









