<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Job;

class JobController extends Controller
{
    public function create(){
        return view('company.jobs.create');
    }


    public function store(Request $request)
   {
    $request->validate([
        'job_title'   => 'required|max:255',
        'job_type'    => 'required',
        'location'    => 'required|max:255',
        'salary'      => 'required|max:255',
        'experience'  => 'required|max:255',
        'vacancy'     => 'required|integer|min:1',
        'description' => 'required',
        'deadline'    => 'required|date',
    ]);

    Job::create([
        'company_id'  => session('company_id'),
        'job_title'   => $request->job_title,
        'job_type'    => $request->job_type,
        'location'    => $request->location,
        'salary'      => $request->salary,
        'experience'  => $request->experience,
        'vacancy'     => $request->vacancy,
        'description' => $request->description,
        'deadline'    => $request->deadline,
        'status'      => true,
    ]);

    return redirect('/company/jobs')
        ->with('success', 'Job posted successfully.');

    }

    public function index()
{
    $jobs = Job::where('company_id', session('company_id'))
                ->latest()
                ->get();

    return view('company.jobs.index', compact('jobs'));
}

    public function edit($id)
{
    $job = Job::where('company_id', session('company_id'))
              ->findOrFail($id);

    return view('company.jobs.edit', compact('job'));
}

    public function update(Request $request, $id)
    {
        $request->validate([
            'job_title' => 'required|max:255',
            'job_type'  => 'required',
            'location'  => 'required|max:255',
            'salary'    => 'required|max:255',
            'experience' => 'required|max:255',
            'vacancy' => 'required|integer|min:1',
            'description' => 'required',
            'deadline' => 'required|date',
        ]);

        $job = job::where('company_id', session('company_id'))->findOrFail($id);

        $job->update([
            'job_title' => $request->job_title,
            'job_type'  => $request->job_type,
            'location'  => $request->location,
            'salary'    => $request->salary,
            'experience' => $request->experience,
            'vacancy' => $request->vacancy,
            'description' => $request->description,
            'deadline' => $request->deadline,

        ]);
        return redirect('/company/jobs')->with('success', 'Job Updated successfully.');
    }

    public function destroy($id)
    {
         $job = Job::where('company_id', session('company_id'))->findOrFail($id);

         $job->delete();

         return redirect('/company/jobs')->with('success', 'Job deleted successfully.');
    }
}
