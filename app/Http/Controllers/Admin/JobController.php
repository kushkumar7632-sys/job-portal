<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Job;
use App\Models\Application;

class JobController extends Controller
{
    // Show all jobs with search, status filters, eager loaded relationships, application count, and pagination
    public function index(Request $request)
    {
        $query = Job::with('company')->withCount('applications');

        // Search: Job title, Job location, Company name
        if ($request->filled('search')) {
            $search = trim($request->input('search'));
            $query->where(function ($q) use ($search) {
                $q->where('job_title', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%")
                  ->orWhereHas('company', function ($cq) use ($search) {
                      $cq->where('company_name', 'like', "%{$search}%");
                  });
            });
        }

        // Status filters: all, active, expired, closed
        if ($request->filled('status')) {
            $status = strtolower(trim($request->input('status')));
            $today = now()->toDateString();

            if ($status === 'active') {
                $query->where('status', true)->whereDate('deadline', '>=', $today);
            } elseif ($status === 'expired') {
                $query->whereDate('deadline', '<', $today);
            } elseif ($status === 'closed') {
                $query->where('status', false);
            }
        }

        $jobs = $query->latest()->paginate(10)->withQueryString();

        // Statistical summary counts for admin overview cards
        $today = now()->toDateString();
        $totalJobsCount = Job::count();
        $activeJobsCount = Job::where('status', true)->whereDate('deadline', '>=', $today)->count();
        $expiredJobsCount = Job::whereDate('deadline', '<', $today)->count();
        $closedJobsCount = Job::where('status', false)->count();
        $totalApplicationsCount = Application::count();

        return view('admin.job.index', compact(
            'jobs',
            'totalJobsCount',
            'activeJobsCount',
            'expiredJobsCount',
            'closedJobsCount',
            'totalApplicationsCount'
        ));
    }

    // Show job details and scoped candidate application history
    public function show($id)
    {
        $job = Job::with('company')->withCount('applications')->findOrFail($id);

        // Application history scoped strictly to this job with eager loaded student details
        $applications = $job->applications()
            ->with('student')
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.job.show', compact('job', 'applications'));
    }

    // Delete job with strict data safety guardrails
    public function destroy($id)
    {
        $job = Job::withCount('applications')->findOrFail($id);

        // STRICT DATA SAFETY GUARD: Block deletion if job has any applications
        // to prevent MySQL cascade from destroying candidate application history
        if ($job->applications_count > 0) {
            return back()->with('error', "Cannot delete job posting because {$job->applications_count} candidate application(s) exist. Deleting this job would destroy candidate application records and history.");
        }

        // Safe deletion inside transaction for jobs with zero applications
        DB::transaction(function () use ($job) {
            $job->delete();
        });

        return redirect()->route('admin.jobs')->with('success', 'Job posting deleted successfully.');
    }
}
