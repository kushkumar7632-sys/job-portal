<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Application;
use App\Models\Job;

class CompanyApplicantController extends Controller
{
    /**
     * Display a paginated listing of applicants for all jobs owned by the company.
     */
    public function index(Request $request)
    {
        $companyId = session('company_id');

        $query = Application::whereHas('job', function ($q) use ($companyId) {
            $q->where('company_id', $companyId);
        })->with(['student', 'job']);

        // Search by candidate name or email
        if ($request->filled('search')) {
            $search = trim($request->input('search'));
            $query->whereHas('student', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter by application status
        $validStatuses = ['Pending', 'Shortlisted', 'Rejected', 'Selected'];
        if ($request->filled('status') && in_array($request->input('status'), $validStatuses, true)) {
            $query->where('status', $request->input('status'));
        }

        // Filter by specific job
        if ($request->filled('job_id')) {
            $jobId = $request->input('job_id');
            if (Job::where('company_id', $companyId)->where('id', $jobId)->exists()) {
                $query->where('job_id', $jobId);
            }
        }

        $applications = $query->latest()->paginate(10)->withQueryString();
        $jobs = Job::where('company_id', $companyId)->orderBy('job_title')->get();

        return view('company.applications.index', compact('applications', 'jobs'));
    }

    /**
     * Display applicants for a specific job owned by the company.
     */
    public function jobApplicants(Request $request, $jobId)
    {
        $companyId = session('company_id');

        // Verify the job belongs to the logged-in company (returns 404 otherwise)
        $selectedJob = Job::where('company_id', $companyId)->findOrFail($jobId);

        $query = Application::where('job_id', $selectedJob->id)
            ->with(['student', 'job']);

        // Search by candidate name or email
        if ($request->filled('search')) {
            $search = trim($request->input('search'));
            $query->whereHas('student', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter by application status
        $validStatuses = ['Pending', 'Shortlisted', 'Rejected', 'Selected'];
        if ($request->filled('status') && in_array($request->input('status'), $validStatuses, true)) {
            $query->where('status', $request->input('status'));
        }

        $applications = $query->latest()->paginate(10)->withQueryString();
        $jobs = Job::where('company_id', $companyId)->orderBy('job_title')->get();

        return view('company.applications.index', compact('applications', 'jobs', 'selectedJob'));
    }

    /**
     * Display applicant details for a company-owned application.
     */
    public function show($id)
    {
        $companyId = session('company_id');

        // Scoped to jobs owned by this company (returns 404 otherwise)
        $application = Application::whereHas('job', function ($q) use ($companyId) {
            $q->where('company_id', $companyId);
        })->with(['student', 'job'])->findOrFail($id);

        return view('company.applications.show', compact('application'));
    }

    /**
     * Update the application status with strict scoping and validation.
     */
    public function updateStatus(Request $request, $id)
    {
        $companyId = session('company_id');

        // Strictly verify company ownership
        $application = Application::whereHas('job', function ($q) use ($companyId) {
            $q->where('company_id', $companyId);
        })->findOrFail($id);

        // Strict whitelist validation
        $request->validate([
            'status' => 'required|in:Pending,Shortlisted,Rejected,Selected',
        ]);

        // Update ONLY status field
        $application->update([
            'status' => $request->input('status'),
        ]);

        return redirect()->back()->with('success', 'Application status updated to ' . $request->input('status') . ' successfully.');
    }
}
