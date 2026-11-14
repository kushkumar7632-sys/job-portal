@extends('layouts.company')

@section('title', 'Applicant Review: ' . ($application->student->name ?? 'Candidate'))
@section('header', 'Applicant Review')
@section('subheader', 'Application #' . $application->id . ' &bull; ' . ($application->job->job_title ?? 'Job Opening'))

@section('content')
<div class="space-y-6">

    <!-- Breadcrumb & Back Action -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <nav class="flex items-center gap-2 text-xs font-medium text-slate-400">
            <a href="{{ route('company.dashboard') }}" class="hover:text-blue-600 transition">Dashboard</a>
            <span>/</span>
            <a href="{{ route('company.applications') }}" class="hover:text-blue-600 transition">Applications</a>
            <span>/</span>
            <a href="{{ route('company.job.applications', $application->job_id) }}" class="hover:text-blue-600 transition">
                {{ $application->job->job_title ?? 'Job' }}
            </a>
            <span>/</span>
            <span class="text-blue-600 font-semibold">{{ $application->student->name ?? 'Candidate' }}</span>
        </nav>

        <a href="{{ route('company.job.applications', $application->job_id) }}"
           class="inline-flex items-center gap-2 text-xs font-semibold text-blue-600 hover:underline">
            &larr; Back to Job Applicants
        </a>
    </div>

    <!-- Candidate Header Hero Card -->
    <section class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-8 shadow-xs">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">

            <div class="flex items-start sm:items-center gap-5">
                <div class="w-16 h-16 rounded-2xl bg-blue-50 border border-blue-100 text-blue-600 flex items-center justify-center font-bold text-2xl shrink-0 shadow-inner">
                    {{ strtoupper(substr($application->student->name ?? 'C', 0, 1)) }}
                </div>

                <div class="min-w-0">
                    <div class="flex flex-wrap items-center gap-3">
                        <h2 class="text-2xl font-bold tracking-tight text-slate-900">
                            {{ $application->student->name ?? 'Candidate' }}
                        </h2>

                        <!-- Current Status Badge -->
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
                                Selected
                            </span>
                        @elseif($application->status === 'Rejected')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-red-50 text-red-700 border border-red-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                Rejected
                            </span>
                        @endif
                    </div>

                    <p class="text-sm text-slate-500 mt-1">
                        {{ $application->student->email ?? 'N/A' }}
                    </p>

                    <div class="mt-3 flex flex-wrap items-center gap-4 text-xs text-slate-400 font-medium">
                        @if(!empty($application->student->phone))
                            <span class="inline-flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                                </svg>
                                Phone: {{ $application->student->phone }}
                            </span>
                        @endif

                        <span class="inline-flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                <circle cx="12" cy="12" r="10"/>
                                <path d="M12 6v6l4 2"/>
                            </svg>
                            Submitted {{ $application->created_at ? $application->created_at->format('M d, Y') : 'N/A' }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Resume Download Action -->
            <div class="flex items-center gap-3 shrink-0">
                @if($application->resume)
                    <a href="{{ route('applications.resume.download', $application->id) }}"
                       target="_blank"
                       class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-5 py-2.5 rounded-xl shadow-xs transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                        </svg>
                        Download Resume
                    </a>
                @else
                    <span class="text-xs font-medium text-slate-400 bg-slate-100 px-4 py-2.5 rounded-lg border border-slate-200">
                        No Resume Attached
                    </span>
                @endif
            </div>

        </div>
    </section>

    <!-- 2-Column Split: Job & Candidate Details vs Hiring Decision -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Left: Job Details & Candidate Profile (2 Columns) -->
        <div class="lg:col-span-2 space-y-6">

            <!-- Applied Job Details Card -->
            <section class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-7 shadow-xs">
                <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                    <div>
                        <span class="text-xs font-semibold uppercase tracking-wider text-blue-600">Applied Job</span>
                        <h3 class="text-xl font-bold text-slate-900 mt-0.5">
                            {{ $application->job->job_title ?? 'Job Title' }}
                        </h3>
                    </div>

                    <a href="{{ route('company.job.applications', $application->job_id) }}"
                       class="text-xs font-semibold text-blue-600 hover:underline">
                        All Job Applicants &rarr;
                    </a>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 py-5 text-sm border-b border-slate-100">
                    <div>
                        <span class="text-xs text-slate-400 block">Job Type</span>
                        <span class="font-semibold text-slate-800 mt-0.5 block">
                            {{ $application->job->job_type ?? 'N/A' }}
                        </span>
                    </div>
                    <div>
                        <span class="text-xs text-slate-400 block">Location</span>
                        <span class="font-semibold text-slate-800 mt-0.5 block">
                            {{ $application->job->location ?? 'N/A' }}
                        </span>
                    </div>
                    <div>
                        <span class="text-xs text-slate-400 block">Salary</span>
                        <span class="font-semibold text-slate-800 mt-0.5 block">
                            {{ $application->job->salary ?? 'N/A' }}
                        </span>
                    </div>
                    <div>
                        <span class="text-xs text-slate-400 block">Experience</span>
                        <span class="font-semibold text-slate-800 mt-0.5 block">
                            {{ $application->job->experience ?? 'N/A' }}
                        </span>
                    </div>
                </div>

                <div class="pt-5">
                    <h4 class="text-xs font-semibold uppercase tracking-wider text-slate-400 mb-2">
                        Job Description & Requirements
                    </h4>
                    <p class="text-sm text-slate-600 leading-relaxed whitespace-pre-line">
                        {{ $application->job->description ?? 'No description provided.' }}
                    </p>
                </div>
            </section>

            <!-- Candidate Contact Summary Card -->
            <section class="bg-white border border-slate-200 rounded-2xl p-6 shadow-xs">
                <h3 class="text-base font-bold text-slate-900 mb-4">
                    Candidate Contact Information
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-sm">
                    <div class="p-4 rounded-xl bg-slate-50 border border-slate-100">
                        <span class="text-xs text-slate-400 block">Full Name</span>
                        <span class="font-semibold text-slate-800 mt-1 block">
                            {{ $application->student->name ?? 'N/A' }}
                        </span>
                    </div>

                    <div class="p-4 rounded-xl bg-slate-50 border border-slate-100">
                        <span class="text-xs text-slate-400 block">Email Address</span>
                        <span class="font-semibold text-slate-800 mt-1 block break-all">
                            {{ $application->student->email ?? 'N/A' }}
                        </span>
                    </div>

                    <div class="p-4 rounded-xl bg-slate-50 border border-slate-100">
                        <span class="text-xs text-slate-400 block">Phone</span>
                        <span class="font-semibold text-slate-800 mt-1 block">
                            {{ $application->student->phone ?? 'Not provided' }}
                        </span>
                    </div>
                </div>
            </section>

        </div>

        <!-- Right: Status Decision & Application Meta (1 Column) -->
        <div class="space-y-6">

            <!-- Hiring Decision Card -->
            <section class="bg-white border border-slate-200 rounded-2xl p-6 shadow-xs">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-900 text-base">
                            Hiring Decision
                        </h3>
                        <p class="text-xs text-slate-400">
                            Update applicant status
                        </p>
                    </div>
                </div>

                <form action="{{ route('company.application.updateStatus', $application->id) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PATCH')

                    <div>
                        <label for="status" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">
                            Application Status
                        </label>
                        <select id="status"
                                name="status"
                                required
                                class="w-full rounded-lg border border-slate-300 bg-white py-2.5 px-3.5 text-sm text-slate-800 outline-none transition focus:border-blue-600 focus:ring-2 focus:ring-blue-100">
                            <option value="Pending" {{ old('status', $application->status) === 'Pending' ? 'selected' : '' }}>
                                Pending
                            </option>
                            <option value="Shortlisted" {{ old('status', $application->status) === 'Shortlisted' ? 'selected' : '' }}>
                                Shortlisted
                            </option>
                            <option value="Selected" {{ old('status', $application->status) === 'Selected' ? 'selected' : '' }}>
                                Selected
                            </option>
                            <option value="Rejected" {{ old('status', $application->status) === 'Rejected' ? 'selected' : '' }}>
                                Rejected
                            </option>
                        </select>
                        @error('status')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit"
                            class="w-full inline-flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold text-sm px-5 py-2.5 rounded-lg transition shadow-sm">
                        Update Status
                    </button>
                </form>

                <div class="mt-5 pt-4 border-t border-slate-100 text-xs text-slate-400 space-y-1.5">
                    <p>&bull; <strong>Pending:</strong> Under initial evaluation.</p>
                    <p>&bull; <strong>Shortlisted:</strong> Cleared for interview rounds.</p>
                    <p>&bull; <strong>Selected:</strong> Offer extended / hired.</p>
                    <p>&bull; <strong>Rejected:</strong> Application dismissed.</p>
                </div>
            </section>

            <!-- Application Metadata Card -->
            <section class="bg-white border border-slate-200 rounded-2xl p-5 shadow-xs text-xs text-slate-500 space-y-2.5">
                <div class="flex justify-between py-1 border-b border-slate-100">
                    <span>Application ID</span>
                    <span class="font-mono text-slate-700 font-semibold">#{{ $application->id }}</span>
                </div>
                <div class="flex justify-between py-1 border-b border-slate-100">
                    <span>Submission Date</span>
                    <span class="text-slate-700 font-medium">{{ $application->created_at ? $application->created_at->toDayDateTimeString() : 'N/A' }}</span>
                </div>
                <div class="flex justify-between py-1">
                    <span>Last Status Update</span>
                    <span class="text-slate-700 font-medium">{{ $application->updated_at ? $application->updated_at->diffForHumans() : 'N/A' }}</span>
                </div>
            </section>

        </div>

    </div>

</div>
@endsection
