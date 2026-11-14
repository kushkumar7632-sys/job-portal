<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\Application;
use App\Models\Student;
use App\Models\Company;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class StudentJobController extends Controller
{
    // View all available jobs with search, filtering, and pagination
    public function index(Request $request)
    {
        $query = Job::with('company')
            ->where('status', true)
            ->whereDate('deadline', '>=', now()->toDateString())
            ->whereHas('company', function ($q) {
                $q->where('is_approved', true);
            });

        // Keyword search by job title or description
        if ($request->filled('search')) {
            $search = trim($request->input('search'));
            $query->where(function ($q) use ($search) {
                $q->where('job_title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Job type filtering
        if ($request->filled('job_type')) {
            $jobType = trim($request->input('job_type'));
            $query->where('job_type', $jobType);
        }

        // Location filtering
        if ($request->filled('location')) {
            $location = trim($request->input('location'));
            $query->where('location', 'like', "%{$location}%");
        }

        // Experience filtering
        if ($request->filled('experience')) {
            $experience = trim($request->input('experience'));
            $query->where('experience', 'like', "%{$experience}%");
        }

        $jobs = $query->latest()->paginate(9)->withQueryString();

        return view('student.jobs.index', compact('jobs'));
    }


    // Job details
    public function show($id)
    {
        $today = now()->toDateString();

        $job = Job::with('company')
            ->where('status', true)
            ->whereDate('deadline', '>=', $today)
            ->whereHas('company', function ($query) {
                $query->where('is_approved', true);
            })
            ->findOrFail($id);

        $studentId = session('student_id');
        $application = Application::where('student_id', $studentId)
                                  ->where('job_id', $job->id)
                                  ->first();

        $alreadyApplied = !is_null($application);

        return view('student.jobs.show', compact('job', 'alreadyApplied', 'application'));
    }

    public function apply($id)
    {
        $studentId = session('student_id');
        $today = now()->toDateString();

        // Recheck job active status & company approval
        $job = Job::where('status', true)
            ->whereHas('company', function ($query) {
                $query->where('is_approved', true);
            })
            ->findOrFail($id);

        // Enforce backend deadline validation
        if ($job->deadline < $today || \Carbon\Carbon::parse($job->deadline)->endOfDay()->isPast()) {
            return redirect()
                ->route('student.jobs')
                ->with('error', 'This job posting has expired and is no longer accepting applications.');
        }

        // Check if already applied
        $alreadyApplied = Application::where('student_id', $studentId)
                                      ->where('job_id', $job->id)
                                      ->exists();

        if ($alreadyApplied) {
            return redirect()
                ->route('student.job.details', $job->id)
                ->with('error', 'You have already applied for this job.');
        }

        Application::create([
            'student_id' => $studentId,
            'job_id'     => $job->id,
            'status'     => 'Pending',
        ]);

        return redirect()
            ->route('student.resume.upload', $job->id)
            ->with('success', 'Application submitted. Please upload your resume.');
    }
// Show Resume Upload Page
public function resumeUpload($id)
{
    $studentId = session('student_id');

    $application = Application::where('student_id', $studentId)
                              ->where('job_id', $id)
                              ->firstOrFail();

    return view('student.jobs.resume', compact('application'));
}


// Upload Resume
public function uploadResume(Request $request, $id)
{
    $studentId = session('student_id');

    $application = Application::where('student_id', $studentId)
                              ->where('job_id', $id)
                              ->firstOrFail();

    $request->validate([
        'resume' => [
            'required',
            'file',
            'mimes:pdf,doc,docx',
            'mimetypes:application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'max:2048',
        ],
    ], [
        'resume.required' => 'Please select a resume file to upload.',
        'resume.file' => 'The uploaded resume must be a valid file.',
        'resume.mimes' => 'The resume must be a file of type: PDF, DOC, or DOCX.',
        'resume.mimetypes' => 'The uploaded file must be a valid PDF, DOC, or DOCX document.',
        'resume.max' => 'The resume must not be larger than 2MB.',
    ]);

    if ($request->hasFile('resume')) {
        $file = $request->file('resume');

        // Randomized, unguessable filename stored outside public directory
        $extension = $file->getClientOriginalExtension();
        $filename = 'resume_' . Str::random(40) . '.' . $extension;
        $newPath = 'resumes/' . $filename;

        $uploadDisk = config('filesystems.resume_disk', 'local');

        // 1. Store the new file on configured resume storage disk (local or Cloudflare R2)
        try {
            $stored = $file->storeAs('resumes', $filename, $uploadDisk);
            if (!$stored) {
                return back()->with('error', 'Failed to store resume file. Please try again.');
            }
        } catch (\Throwable $e) {
            Log::error('Resume storage error: ' . $e->getMessage(), ['exception' => $e]);
            return back()->with('error', 'Unable to upload resume due to a storage service error. Please try again later.');
        }

        $oldResume = $application->resume;

        // 2. Update database record safely
        try {
            $application->update([
                'resume' => $newPath,
            ]);
        } catch (\Throwable $e) {
            // If database update fails, delete newly uploaded file from the upload disk
            try {
                Storage::disk($uploadDisk)->delete($newPath);
            } catch (\Throwable $deleteEx) {
                // Ignore cleanup error
            }
            throw $e;
        }

        // 3. Delete previous file only after replacement upload succeeds
        if ($oldResume && $oldResume !== $newPath) {
            $disksToCheck = array_unique([$uploadDisk, 'local', 'public']);
            foreach ($disksToCheck as $oldDisk) {
                try {
                    if (Storage::disk($oldDisk)->exists($oldResume)) {
                        Storage::disk($oldDisk)->delete($oldResume);
                        break;
                    }
                } catch (\Throwable $e) {
                    // Continue checking other disks
                }
            }
        }
    }

    return redirect()
        ->route('student.job.details', $application->job_id)
        ->with('success', 'Resume uploaded successfully!');
}

/**
 * Securely download or view an application resume with strict multi-role authorization.
 */
public function downloadResume(Request $request, $id)
{
    $application = Application::with('job.company')->findOrFail($id);

    if (empty($application->resume)) {
        abort(404, 'No resume document associated with this application.');
    }

    $isAuthorized = false;

    // 1. Admin authorization: uses existing admin guard
    if (Auth::guard('admin')->check()) {
        $isAuthorized = true;
    }

    // 2. Student authorization: session exists, student record exists in DB, and owns the application
    if (!$isAuthorized && session()->has('student_id')) {
        $student = Student::find(session('student_id'));
        if ($student && $student->id === $application->student_id) {
            $isAuthorized = true;
        }
    }

    // 3. Company authorization: session exists, company record exists in DB, is approved, and owns the job
    if (!$isAuthorized && session()->has('company_id')) {
        $company = Company::find(session('company_id'));
        if ($company && $company->is_approved && $application->job && $application->job->company_id === $company->id) {
            $isAuthorized = true;
        }
    }

    // 4. Unauthorized requests return HTTP 403 Forbidden
    if (!$isAuthorized) {
        abort(403, 'Unauthorized access to resume.');
    }

    // Check configured resume disk first, then fallback to local private storage, then legacy public storage
    $disk = null;
    $configuredDisk = config('filesystems.resume_disk', 'local');
    $candidateDisks = array_unique([$configuredDisk, 'local', 'public']);

    foreach ($candidateDisks as $candidate) {
        try {
            if (Storage::disk($candidate)->exists($application->resume)) {
                $disk = $candidate;
                break;
            }
        } catch (\Throwable $e) {
            Log::warning("Storage disk [{$candidate}] check error: " . $e->getMessage());
        }
    }

    if (!$disk) {
        abort(404, 'Resume file could not be found in storage.');
    }

    // Safe sanitized download filename (does not expose internal physical storage path)
    $extension = pathinfo($application->resume, PATHINFO_EXTENSION) ?: 'pdf';
    $downloadName = 'Resume_Application_' . $application->id . '.' . $extension;

    try {
        $mimeType = Storage::disk($disk)->mimeType($application->resume) ?? 'application/pdf';
    } catch (\Throwable $e) {
        $mimeType = 'application/pdf';
    }

    if ($request->query('download') == '1') {
        return Storage::disk($disk)->download($application->resume, $downloadName);
    }

    return Storage::disk($disk)->response($application->resume, $downloadName, [
        'Content-Type' => $mimeType,
        'Content-Disposition' => 'inline; filename="' . $downloadName . '"',
    ]);
}

// My Applications
public function myApplications()
{
    $studentId = session('student_id');

    $applications = Application::with('job')
                               ->where('student_id', $studentId)
                               ->latest()
                               ->get();

    return view('student.jobs.applications', compact('applications'));
}

}