<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Company;
use App\Models\Job;
use App\Models\Application;

class DashboardController extends Controller
{
    public function index()
    {
        $studentCount = Student::count();
        $companyCount = Company::count();
        $jobCount = Job::count();
        $applicationCount = Application::count();

        return view('admin.dashboard', compact(
            'studentCount',
            'companyCount',
            'jobCount',
            'applicationCount'
        ));
    }
}