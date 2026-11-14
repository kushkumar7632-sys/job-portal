@extends('layouts.company')

@section('title', 'Company Dashboard')
@section('header', 'Employer Dashboard')
@section('subheader', "Welcome back, " . session('company_name') . ". Here's your recruitment overview.")

@section('content')
<div class="space-y-8">

    <!-- Overview Bar & Action -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <p class="text-xs font-semibold uppercase tracking-wider text-blue-600 mb-1">
                Recruitment Overview
            </p>
            <h2 class="text-2xl font-bold tracking-tight text-slate-900">
                Performance & Candidate Pipeline
            </h2>
        </div>

        <a href="{{ route('company.job.create') }}"
           class="inline-flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-5 py-2.5 rounded-lg shadow-sm transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Post a New Job
        </a>
    </div>

    <!-- Core Statistics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">

        <!-- Total Jobs -->
        <div class="bg-white border border-slate-200 rounded-xl p-6 shadow-xs hover:border-slate-300 transition">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">
                        Total Job Postings
                    </p>
                    <h3 class="text-3xl font-bold text-slate-900 mt-3">
                        {{ $totalJobs }}
                    </h3>
                    <p class="text-xs text-slate-400 mt-1.5">
                        Jobs created by your company
                    </p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <rect x="3" y="7" width="18" height="14" rx="2" stroke-width="1.8"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 7V4h8v3M3 12h18"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Applications -->
        <div class="bg-white border border-slate-200 rounded-xl p-6 shadow-xs hover:border-slate-300 transition">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">
                        Total Applications
                    </p>
                    <h3 class="text-3xl font-bold text-slate-900 mt-3">
                        {{ $totalApplications }}
                    </h3>
                    <p class="text-xs text-slate-400 mt-1.5">
                        Candidate applications received
                    </p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                        <circle cx="9" cy="7" r="4" stroke-width="1.8"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M22 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Company Verification Status -->
        <div class="bg-white border border-slate-200 rounded-xl p-6 shadow-xs hover:border-slate-300 transition">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">
                        Verification Status
                    </p>
                    <h3 class="text-2xl font-bold text-emerald-600 mt-3 flex items-center gap-2">
                        <span>Approved</span>
                        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                    </h3>
                    <p class="text-xs text-slate-400 mt-1.5">
                        Verified Employer Organization
                    </p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
            </div>
        </div>

    </div>

    <!-- Application Status Breakdown -->
    <div>
        <p class="text-xs font-semibold uppercase tracking-wider text-slate-500 mb-3">
            Application Pipeline Stages
        </p>

        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">

            <!-- Pending -->
            <div class="bg-white border border-slate-200 rounded-xl p-4 sm:p-5 shadow-xs">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold uppercase tracking-wider text-amber-600">Pending</span>
                    <span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span>
                </div>
                <p class="text-3xl font-bold text-slate-900 mt-2">
                    {{ $pendingApplications }}
                </p>
                <p class="text-xs text-slate-400 mt-1">Under initial review</p>
            </div>

            <!-- Shortlisted -->
            <div class="bg-white border border-slate-200 rounded-xl p-4 sm:p-5 shadow-xs">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold uppercase tracking-wider text-blue-600">Shortlisted</span>
                    <span class="w-2.5 h-2.5 rounded-full bg-blue-500"></span>
                </div>
                <p class="text-3xl font-bold text-slate-900 mt-2">
                    {{ $shortlistedApplications }}
                </p>
                <p class="text-xs text-slate-400 mt-1">Cleared for interviews</p>
            </div>

            <!-- Selected -->
            <div class="bg-white border border-slate-200 rounded-xl p-4 sm:p-5 shadow-xs">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold uppercase tracking-wider text-emerald-600">Selected</span>
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                </div>
                <p class="text-3xl font-bold text-slate-900 mt-2">
                    {{ $selectedApplications }}
                </p>
                <p class="text-xs text-slate-400 mt-1">Hired / Offered</p>
            </div>

            <!-- Rejected -->
            <div class="bg-white border border-slate-200 rounded-xl p-4 sm:p-5 shadow-xs">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold uppercase tracking-wider text-red-600">Rejected</span>
                    <span class="w-2.5 h-2.5 rounded-full bg-red-500"></span>
                </div>
                <p class="text-3xl font-bold text-slate-900 mt-2">
                    {{ $rejectedApplications }}
                </p>
                <p class="text-xs text-slate-400 mt-1">Declined candidates</p>
            </div>

        </div>
    </div>

    <!-- Quick Actions Grid -->
    <div>
        <div class="mb-4">
            <h3 class="text-base font-bold text-slate-900">
                Recruitment Quick Actions
            </h3>
            <p class="text-xs text-slate-500 mt-0.5">
                Quick access to common recruitment workflows and configurations
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

            <!-- Post a Job -->
            <a href="{{ route('company.job.create') }}"
               class="group block bg-white border border-slate-200 hover:border-blue-300 hover:shadow-sm rounded-xl p-5 transition">
                <div class="w-10 h-10 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center mb-4 transition group-hover:bg-blue-600 group-hover:text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                </div>
                <h4 class="font-bold text-slate-900 text-sm">
                    Post a New Job
                </h4>
                <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                    Create and publish a new job opening for applicants.
                </p>
                <div class="mt-4 text-xs font-semibold text-blue-600 flex items-center gap-1">
                    Create Job <span class="transition group-hover:translate-x-1">&rarr;</span>
                </div>
            </a>

            <!-- Manage Jobs -->
            <a href="{{ route('company.jobs') }}"
               class="group block bg-white border border-slate-200 hover:border-violet-300 hover:shadow-sm rounded-xl p-5 transition">
                <div class="w-10 h-10 rounded-lg bg-violet-50 text-violet-600 flex items-center justify-center mb-4 transition group-hover:bg-violet-600 group-hover:text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 6h16M4 10h16M4 14h10M4 18h10"/>
                    </svg>
                </div>
                <h4 class="font-bold text-slate-900 text-sm">
                    Manage Jobs
                </h4>
                <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                    Review, edit, activate, or close your published jobs.
                </p>
                <div class="mt-4 text-xs font-semibold text-violet-600 flex items-center gap-1">
                    View Listings <span class="transition group-hover:translate-x-1">&rarr;</span>
                </div>
            </a>

            <!-- Applications -->
            <a href="{{ route('company.applications') }}"
               class="group block bg-white border border-slate-200 hover:border-emerald-300 hover:shadow-sm rounded-xl p-5 transition">
                <div class="w-10 h-10 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center mb-4 transition group-hover:bg-emerald-600 group-hover:text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                        <circle cx="9" cy="7" r="4" stroke-width="1.8"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M22 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/>
                    </svg>
                </div>
                <h4 class="font-bold text-slate-900 text-sm">
                    Candidate Applications
                </h4>
                <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                    Review resumes and make candidate hiring decisions.
                </p>
                <div class="mt-4 text-xs font-semibold text-emerald-600 flex items-center gap-1">
                    Review Applicants <span class="transition group-hover:translate-x-1">&rarr;</span>
                </div>
            </a>

            <!-- Profile -->
            <a href="{{ route('company.profile') }}"
               class="group block bg-white border border-slate-200 hover:border-amber-300 hover:shadow-sm rounded-xl p-5 transition">
                <div class="w-10 h-10 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center mb-4 transition group-hover:bg-amber-600 group-hover:text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <rect x="4" y="2" width="16" height="20" rx="2" stroke-width="1.8"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 22v-4h6v4M8 6h.01M16 6h.01M8 10h.01M16 10h.01M8 14h.01M16 14h.01"/>
                    </svg>
                </div>
                <h4 class="font-bold text-slate-900 text-sm">
                    Company Profile
                </h4>
                <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                    Update organization identity, contacts, and password.
                </p>
                <div class="mt-4 text-xs font-semibold text-amber-600 flex items-center gap-1">
                    Edit Profile <span class="transition group-hover:translate-x-1">&rarr;</span>
                </div>
            </a>

        </div>
    </div>

    <!-- Recent Candidate Applications Table -->
    <div class="bg-white border border-slate-200 rounded-xl overflow-hidden shadow-xs">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between flex-wrap gap-4">
            <div>
                <h3 class="text-base font-bold text-slate-900">
                    Recent Candidate Applications
                </h3>
                <p class="text-xs text-slate-400 mt-0.5">
                    Latest candidates who applied to your open positions
                </p>
            </div>

            <a href="{{ route('company.applications') }}"
               class="text-xs font-semibold text-blue-600 hover:underline">
                View All Applications &rarr;
            </a>
        </div>

        @if($recentApplications->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-100 text-xs font-bold uppercase tracking-wider text-slate-400">
                            <th class="py-3 px-6">Candidate</th>
                            <th class="py-3 px-6">Position</th>
                            <th class="py-3 px-6">Applied</th>
                            <th class="py-3 px-6">Status</th>
                            <th class="py-3 px-6 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm">
                        @foreach($recentApplications as $recent)
                            <tr class="hover:bg-slate-50/70 transition">
                                <td class="py-3.5 px-6">
                                    <div class="font-semibold text-slate-900">
                                        {{ $recent->student->name ?? 'Candidate' }}
                                    </div>
                                    <div class="text-xs text-slate-400">
                                        {{ $recent->student->email ?? '' }}
                                    </div>
                                </td>
                                <td class="py-3.5 px-6">
                                    <span class="font-medium text-slate-800">
                                        {{ $recent->job->job_title ?? 'Job Title' }}
                                    </span>
                                </td>
                                <td class="py-3.5 px-6 text-xs text-slate-500">
                                    {{ $recent->created_at ? $recent->created_at->diffForHumans() : '' }}
                                </td>
                                <td class="py-3.5 px-6">
                                    @if($recent->status === 'Pending')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                            Pending
                                        </span>
                                    @elseif($recent->status === 'Shortlisted')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                                            Shortlisted
                                        </span>
                                    @elseif($recent->status === 'Selected')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                            Selected
                                        </span>
                                    @elseif($recent->status === 'Rejected')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-red-50 text-red-700 border border-red-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                            Rejected
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3.5 px-6 text-right">
                                    <a href="{{ route('company.application.show', $recent->id) }}"
                                       class="text-xs font-semibold text-blue-600 hover:underline">
                                        Review &rarr;
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="py-12 px-6 text-center">
                <div class="w-12 h-12 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                        <circle cx="9" cy="7" r="4" stroke-width="1.8"/>
                    </svg>
                </div>
                <p class="text-sm font-semibold text-slate-700">No applications received yet</p>
                <p class="text-xs text-slate-400 mt-1 max-w-sm mx-auto">
                    When candidates apply to your job postings, their details and resumes will appear here.
                </p>
            </div>
        @endif
    </div>

    <!-- Recruitment CTA Card -->
    <div class="bg-gradient-to-r from-slate-900 to-blue-950 rounded-2xl p-6 sm:p-8 text-white shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h3 class="text-lg font-bold text-white">
                Ready to expand your team?
            </h3>
            <p class="text-xs sm:text-sm text-slate-300 mt-1 max-w-xl">
                Publish a new opening and reach thousands of qualified student and graduate candidates.
            </p>
        </div>

        <a href="{{ route('company.job.create') }}"
           class="inline-flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-500 text-white font-semibold text-sm px-6 py-3 rounded-xl shadow-md transition shrink-0">
            Create Job Posting &rarr;
        </a>
    </div>

</div>
@endsection
