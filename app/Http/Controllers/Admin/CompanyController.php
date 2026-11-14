<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Application;

class CompanyController extends Controller
{
    // Show all companies with search, filter, withCount, and pagination
    public function index(Request $request)
    {
        $query = Company::withCount('jobs');

        // Search by company_name, owner_name, email, or industry
        if ($request->filled('search')) {
            $search = trim($request->input('search'));
            $query->where(function ($q) use ($search) {
                $q->where('company_name', 'like', "%{$search}%")
                  ->orWhere('owner_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('industry', 'like', "%{$search}%");
            });
        }

        // Approval status filter: all, approved, pending
        if ($request->filled('status')) {
            $status = strtolower(trim($request->input('status')));
            if ($status === 'approved') {
                $query->where('is_approved', true);
            } elseif ($status === 'pending') {
                $query->where('is_approved', false);
            }
        }

        $companies = $query->latest()->paginate(10)->withQueryString();

        return view('admin.company.index', compact('companies'));
    }

    // Show company details with scoped jobs and counts
    public function show($id)
    {
        $company = Company::withCount('jobs')->findOrFail($id);

        // Load the company's jobs with application count, scoped to this company
        $jobs = $company->jobs()
            ->withCount('applications')
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $totalJobsCount = $company->jobs_count;

        // Total applications across all jobs for this company
        $totalApplicationsCount = Application::whereIn('job_id', $company->jobs()->select('id'))->count();

        return view('admin.company.show', compact(
            'company',
            'jobs',
            'totalJobsCount',
            'totalApplicationsCount'
        ));
    }

    // Approve company
    public function approve($id)
    {
        $company = Company::findOrFail($id);

        $company->update([
            'is_approved' => true,
        ]);

        return back()->with('success', 'Company approved successfully.');
    }

    // Reject company
    public function reject($id)
    {
        $company = Company::findOrFail($id);

        $company->update([
            'is_approved' => false,
        ]);

        return back()->with('success', 'Company rejected successfully.');
    }  
}
