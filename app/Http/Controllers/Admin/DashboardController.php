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
        $today = now()->toDateString();

        // Core entity counts
        $studentCount = Student::count();

        // Company counts
        $companyCount = Company::count();
        $approvedCompanyCount = Company::where('is_approved', 1)->count();
        $pendingCompanyCount = Company::where('is_approved', 0)->count();

        // Job counts
        $jobCount = Job::count();
        $activeJobCount = Job::where('status', 1)
            ->whereDate('deadline', '>=', $today)
            ->count();
        $closedJobCount = Job::where(function ($q) use ($today) {
            $q->where('status', 0)
              ->orWhereDate('deadline', '<', $today);
        })->count();

        // Application counts
        $applicationCount = Application::count();
        $pendingApplicationCount = Application::where('status', 'Pending')->count();
        $shortlistedApplicationCount = Application::where('status', 'Shortlisted')->count();
        $selectedApplicationCount = Application::where('status', 'Selected')->count();
        $rejectedApplicationCount = Application::where('status', 'Rejected')->count();

        // Recent Activity with eager loaded relationships to avoid N+1 queries
        $recentPendingCompanies = Company::where('is_approved', 0)
            ->latest()
            ->take(5)
            ->get();

        $recentJobs = Job::with('company')
            ->latest()
            ->take(5)
            ->get();

        $recentApplications = Application::with(['student', 'job.company'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'studentCount',
            'companyCount',
            'approvedCompanyCount',
            'pendingCompanyCount',
            'jobCount',
            'activeJobCount',
            'closedJobCount',
            'applicationCount',
            'pendingApplicationCount',
            'shortlistedApplicationCount',
            'selectedApplicationCount',
            'rejectedApplicationCount',
            'recentPendingCompanies',
            'recentJobs',
            'recentApplications'
        ));
    }
}
