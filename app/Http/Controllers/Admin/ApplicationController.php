<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Application;

class ApplicationController extends Controller
{
    // Application listing with search, status filtering, eager-loading, pagination, and statistics
    public function index(Request $request)
    {
        $query = Application::with(['student', 'job.company']);

        // Search: Student name, Student email, Job title, Company name
        if ($request->filled('search')) {
            $search = trim($request->input('search'));
            $query->where(function ($q) use ($search) {
                $q->whereHas('student', function ($sq) use ($search) {
                    $sq->where('name', 'like', "%{$search}%")
                       ->orWhere('email', 'like', "%{$search}%");
                })->orWhereHas('job', function ($jq) use ($search) {
                    $jq->where('job_title', 'like', "%{$search}%")
                       ->orWhereHas('company', function ($cq) use ($search) {
                           $cq->where('company_name', 'like', "%{$search}%");
                       });
                });
            });
        }

        // Status filters: Pending, Shortlisted, Selected, Rejected
        if ($request->filled('status')) {
            $status = trim($request->input('status'));
            $validStatuses = ['Pending', 'Shortlisted', 'Selected', 'Rejected'];
            foreach ($validStatuses as $validStatus) {
                if (strcasecmp($status, $validStatus) === 0) {
                    $query->where('status', $validStatus);
                    break;
                }
            }
        }

        $applications = $query->latest()->paginate(10)->withQueryString();

        // Statistical summary counts for admin overview cards
        $totalApplicationsCount = Application::count();
        $pendingCount = Application::where('status', 'Pending')->count();
        $shortlistedCount = Application::where('status', 'Shortlisted')->count();
        $selectedCount = Application::where('status', 'Selected')->count();
        $rejectedCount = Application::where('status', 'Rejected')->count();

        return view('admin.application.index', compact(
            'applications',
            'totalApplicationsCount',
            'pendingCount',
            'shortlistedCount',
            'selectedCount',
            'rejectedCount'
        ));
    }

    // Application details with student, job, and company information
    public function show($id)
    {
        $application = Application::with(['student', 'job.company'])->findOrFail($id);

        return view('admin.application.show', compact('application'));
    }

    // Safe deletion with physical resume cleanup guard
    public function destroy($id)
    {
        $application = Application::findOrFail($id);
        $resumePath = $application->resume;

        // Check if another application references the exact same physical resume path
        $isResumeShared = false;
        if (!empty($resumePath)) {
            $isResumeShared = Application::where('id', '!=', $application->id)
                ->where('resume', $resumePath)
                ->exists();
        }

        // Perform application record deletion inside a transaction
        DB::transaction(function () use ($application) {
            $application->delete();
        });

        // Perform physical file cleanup only after database transaction commits
        // and only if the file is NOT shared by any other application
        if (!empty($resumePath) && !$isResumeShared) {
            $configuredDisk = config('filesystems.resume_disk', 'local');
            $disksToCheck = array_unique([$configuredDisk, 'local', 'public']);

            foreach ($disksToCheck as $disk) {
                try {
                    if (Storage::disk($disk)->exists($resumePath)) {
                        Storage::disk($disk)->delete($resumePath);
                        break;
                    }
                } catch (\Throwable $e) {
                    // Continue checking other disks
                }
            }
        }

        return redirect()->route('admin.applications')->with('success', 'Application deleted successfully.');
    }
}
