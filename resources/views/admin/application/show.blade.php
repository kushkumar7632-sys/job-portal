@extends('layouts.admin')

@section('title', 'Application Details #' . $application->id)
@section('header', 'Application Details')

@section('content')
<div class="space-y-6">

    <!-- Top Action Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <a href="{{ route('admin.applications') }}"
           class="inline-flex items-center gap-2 text-xs font-semibold text-slate-600 hover:text-indigo-600 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            <span>Back to Applications</span>
        </a>

        <div class="flex items-center gap-2">
            <form action="{{ route('admin.applications.delete', $application->id) }}"
                  method="POST"
                  onsubmit="return confirm('Are you sure you want to delete this application record? If a private resume file is associated and not shared, it will be safely removed.');">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="px-3 py-1.5 rounded-lg text-xs font-semibold bg-rose-50 text-rose-700 border border-rose-200 hover:bg-rose-100 transition-colors">
                    Delete Application
                </button>
            </form>
        </div>
    </div>

    <!-- Application Status & Summary Card -->
    <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-xs">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pb-6 border-b border-slate-100">
            <div class="flex items-start gap-4">
                <div class="w-14 h-14 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0 border border-indigo-100">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <div>
                    <div class="flex flex-wrap items-center gap-2.5">
                        <h2 class="text-xl font-bold text-slate-900">
                            Application #{{ $application->id }}
                        </h2>

                        @if($application->status === 'Pending')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                Pending Review
                            </span>
                        @elseif($application->status === 'Shortlisted')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                                Shortlisted
                            </span>
                        @elseif($application->status === 'Selected')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                Selected / Offered
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-rose-50 text-rose-700 border border-rose-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                Rejected
                            </span>
                        @endif
                    </div>

                    <p class="text-xs text-slate-500 mt-1">
                        Submitted on <span class="font-medium text-slate-800">{{ $application->created_at ? $application->created_at->format('M d, Y, h:i A') : 'N/A' }}</span>
                    </p>
                </div>
            </div>

            <!-- Resume Action Area -->
            <div class="flex items-center gap-3">
                @if($application->resume)
                    <a href="{{ route('applications.resume.download', $application->id) }}"
                       target="_blank"
                       class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold bg-indigo-600 hover:bg-indigo-700 text-white shadow-xs transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <span>Download Resume</span>
                    </a>
                @else
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-medium bg-slate-100 text-slate-500">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                        </svg>
                        <span>No Resume Attached</span>
                    </span>
                @endif
            </div>
        </div>

        <!-- Key Submission Timestamps -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 pt-5 text-xs sm:text-sm">
            <div>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Application ID</p>
                <p class="font-bold text-slate-900 mt-1">#{{ $application->id }}</p>
            </div>
            <div>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Submission Date</p>
                <p class="font-semibold text-slate-900 mt-1">
                    {{ $application->created_at ? $application->created_at->format('M d, Y, h:i A') : 'N/A' }}
                </p>
            </div>
            <div>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Last Status Update</p>
                <p class="font-semibold text-slate-900 mt-1">
                    {{ $application->updated_at ? $application->updated_at->format('M d, Y, h:i A') : 'N/A' }}
                </p>
            </div>
        </div>
    </div>

    <!-- Candidate Information Card -->
    <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-xs">
        <div class="flex items-center justify-between pb-4 border-b border-slate-100">
            <h3 class="text-sm sm:text-base font-bold text-slate-900">
                Candidate Information
            </h3>
            @if($application->student)
                <a href="{{ route('admin.students.show', $application->student->id) }}"
                   class="inline-flex items-center gap-1.5 text-xs font-semibold text-indigo-600 hover:text-indigo-700 transition-colors">
                    <span>View Student Profile</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                </a>
            @endif
        </div>

        @if($application->student)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 pt-5 text-xs sm:text-sm">
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Full Name</p>
                    <p class="font-bold text-slate-900 mt-1">{{ $application->student->name }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Email Address</p>
                    <p class="font-semibold text-slate-900 mt-1 break-all">{{ $application->student->email }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Phone Number</p>
                    <p class="font-semibold text-slate-900 mt-1">{{ $application->student->phone ?? 'Not provided' }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Candidate ID</p>
                    <p class="font-semibold text-slate-900 mt-1">#{{ $application->student->id }}</p>
                </div>
            </div>
        @else
            <p class="text-xs text-slate-400 italic pt-4">No associated candidate account found for this application record.</p>
        @endif
    </div>

    <!-- Job Information Card -->
    <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-xs">
        <div class="flex items-center justify-between pb-4 border-b border-slate-100">
            <h3 class="text-sm sm:text-base font-bold text-slate-900">
                Job Posting Information
            </h3>
            @if($application->job)
                <a href="{{ route('admin.jobs.show', $application->job->id) }}"
                   class="inline-flex items-center gap-1.5 text-xs font-semibold text-indigo-600 hover:text-indigo-700 transition-colors">
                    <span>View Job Posting</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                </a>
            @endif
        </div>

        @if($application->job)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 pt-5 text-xs sm:text-sm">
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Job Title</p>
                    <p class="font-bold text-slate-900 mt-1">{{ $application->job->job_title }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Location</p>
                    <p class="font-semibold text-slate-900 mt-1">{{ $application->job->location }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Job Type</p>
                    <p class="font-semibold text-slate-900 mt-1">{{ $application->job->job_type }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Salary Offering</p>
                    <p class="font-semibold text-slate-900 mt-1">{{ $application->job->salary ?? 'Not specified' }}</p>
                </div>
            </div>
        @else
            <p class="text-xs text-slate-400 italic pt-4">No associated job posting found for this application record.</p>
        @endif
    </div>

    <!-- Employer Information Card -->
    <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-xs">
        <div class="flex items-center justify-between pb-4 border-b border-slate-100">
            <h3 class="text-sm sm:text-base font-bold text-slate-900">
                Employer Information
            </h3>
            @if($application->job && $application->job->company)
                <a href="{{ route('admin.companies.show', $application->job->company->id) }}"
                   class="inline-flex items-center gap-1.5 text-xs font-semibold text-indigo-600 hover:text-indigo-700 transition-colors">
                    <span>View Company Profile</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                </a>
            @endif
        </div>

        @if($application->job && $application->job->company)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 pt-5 text-xs sm:text-sm">
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Company Name</p>
                    <p class="font-bold text-slate-900 mt-1">{{ $application->job->company->company_name }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Primary Contact</p>
                    <p class="font-semibold text-slate-900 mt-1">{{ $application->job->company->owner_name ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Email Address</p>
                    <p class="font-semibold text-slate-900 mt-1 break-all">{{ $application->job->company->email }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Industry</p>
                    <p class="font-semibold text-slate-900 mt-1">{{ $application->job->company->industry ?? 'Not specified' }}</p>
                </div>
            </div>
        @else
            <p class="text-xs text-slate-400 italic pt-4">No associated employer found for this application record.</p>
        @endif
    </div>

</div>
@endsection
