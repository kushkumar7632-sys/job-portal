<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Job;

class JobController extends Controller
{
    // Show all jobs
    public function index()
    {
        $jobs = Job::with('company')->latest()->get();

        return view('admin.job.index', compact('jobs'));
    }

    // Show job details
    public function show($id)
    {
        $job = Job::with('company')->findOrFail($id);

        return view('admin.job.show', compact('job'));
    }

    // Delete job
    public function destroy($id)
    {
        $job = Job::findOrFail($id);

        $job->delete();

        return back()->with('success', 'Job deleted successfully.');
    }
}