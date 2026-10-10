<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;

class ApplicationController extends Controller
{
    public function index()
    {
        $applications = Application::with(['student', 'job.company'])
            ->latest()
            ->get();

        return view('admin.application.index', compact('applications'));
    }

    public function show($id)
    {
        $application = Application::with(['student', 'job.company'])
            ->findOrFail($id);

        return view('admin.application.show', compact('application'));
    }

    public function destroy($id)
    {
        $application = Application::findOrFail($id);

        $application->delete();

        return back()->with(
            'success',
            'Application deleted successfully.'
        );
    }
}