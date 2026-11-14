<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Job;

class JobController extends Controller
{
    public function create()
    {
        return view('company.jobs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'job_title'   => 'required|string|min:3|max:255',
            'job_type'    => 'required|string|in:Full Time,Part Time,Internship,Contract,Remote',
            'location'    => 'required|string|max:255',
            'salary'      => 'required|string|max:255',
            'experience'  => 'required|string|max:255',
            'vacancy'     => 'required|integer|min:1|max:9999',
            'description' => 'required|string|min:10',
            'deadline'    => 'required|date',
        ]);

        Job::create([
            'company_id'  => session('company_id'),
            'job_title'   => trim($request->input('job_title')),
            'job_type'    => trim($request->input('job_type')),
            'location'    => trim($request->input('location')),
            'salary'      => trim($request->input('salary')),
            'experience'  => trim($request->input('experience')),
            'vacancy'     => (int) $request->input('vacancy'),
            'description' => trim($request->input('description')),
            'deadline'    => $request->input('deadline'),
            'status'      => true,
        ]);

        return redirect('/company/jobs')
            ->with('success', 'Job posted successfully.');
    }

    public function index(Request $request)
    {
        $companyId = session('company_id');

        $query = Job::where('company_id', $companyId)
                    ->withCount('applications')
                    ->latest();

        if ($request->filled('search')) {
            $search = trim($request->input('search'));
            $query->where(function ($q) use ($search) {
                $q->where('job_title', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%")
                  ->orWhere('job_type', 'like', "%{$search}%");
            });
        }

        $jobs = $query->paginate(10)->withQueryString();

        $totalJobs = Job::where('company_id', $companyId)->count();
        $activeJobs = Job::where('company_id', $companyId)->where('status', true)->count();
        $totalVacancies = Job::where('company_id', $companyId)->sum('vacancy');

        return view('company.jobs.index', compact('jobs', 'totalJobs', 'activeJobs', 'totalVacancies'));
    }

    public function edit($id)
    {
        $job = Job::where('company_id', session('company_id'))
                  ->findOrFail($id);

        return view('company.jobs.edit', compact('job'));
    }

    public function update(Request $request, $id)
    {
        $job = Job::where('company_id', session('company_id'))->findOrFail($id);

        $request->validate([
            'job_title'   => 'required|string|min:3|max:255',
            'job_type'    => 'required|string|in:Full Time,Part Time,Internship,Contract,Remote',
            'location'    => 'required|string|max:255',
            'salary'      => 'required|string|max:255',
            'experience'  => 'required|string|max:255',
            'vacancy'     => 'required|integer|min:1|max:9999',
            'description' => 'required|string|min:10',
            'deadline'    => 'required|date',
            'status'      => 'required|in:0,1',
        ]);

        $job->update([
            'job_title'   => trim($request->input('job_title')),
            'job_type'    => trim($request->input('job_type')),
            'location'    => trim($request->input('location')),
            'salary'      => trim($request->input('salary')),
            'experience'  => trim($request->input('experience')),
            'vacancy'     => (int) $request->input('vacancy'),
            'description' => trim($request->input('description')),
            'deadline'    => $request->input('deadline'),
            'status'      => (bool) $request->input('status'),
        ]);

        return redirect('/company/jobs')->with('success', 'Job updated successfully.');
    }

    public function destroy($id)
    {
        $job = Job::where('company_id', session('company_id'))->findOrFail($id);

        if ($job->applications()->exists()) {
            return redirect()->route('company.jobs')
                ->with('error', 'Cannot delete this job because candidates have already applied to it. You can change its status to Closed instead.');
        }

        $job->delete();

        return redirect()->route('company.jobs')->with('success', 'Job deleted successfully.');
    }
}
