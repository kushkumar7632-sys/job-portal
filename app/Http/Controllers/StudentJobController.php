<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\Application;

class StudentJobController extends Controller
{
    // View all available jobs
    public function index()
    {
        $jobs = Job::where('status', true)
                   ->latest()
                   ->get();

        return view('student.jobs.index', compact('jobs'));
    }


    // Job details
    public function show($id)
    {
        $job = Job::where('status', true)
                  ->findOrFail($id);

        return view('student.jobs.show', compact('job'));
    }

    public function apply($id)
{
    $studentId = session('student_id');

    $job = Job::where('status', true)
              ->findOrFail($id);


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
        'resume' => 'required|mimes:pdf,doc,docx|max:2048',
    ]);

    if ($request->hasFile('resume')) {

        $file = $request->file('resume');

        $filename = time() . '_' . $studentId . '.' . $file->getClientOriginalExtension();

        $file->storeAs('resumes', $filename, 'public');

        $application->update([
            'resume' => 'resumes/' . $filename,
        ]);
    }

    return redirect()
        ->route('student.job.details', $application->job_id)
        ->with('success', 'Resume uploaded successfully!');
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