@extends('layouts.admin')

@section('title', 'Admin Dashboard')
@section('header', 'System Overview')

@section('content')
<div class="space-y-8">

    <!-- Welcome Header Banner -->
    <div class="bg-gradient-to-r from-[#111827] via-[#1f2937] to-[#111827] rounded-2xl p-6 sm:p-8 text-white shadow-md border border-white/10">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-500/20 text-indigo-300 text-xs font-semibold tracking-wide border border-indigo-400/30 mb-3">
                    <span class="w-2 h-2 rounded-full bg-indigo-400"></span>
                    Central Administration
                </div>
                <h2 class="text-2xl sm:text-3xl font-extrabold tracking-tight">
                    Welcome back, {{ Auth::guard('admin')->user()->name ?? 'Administrator' }}
                </h2>
                <p class="text-slate-300 text-sm mt-1 max-w-2xl">
                    Real-time operational dashboard for monitoring registered candidates, company verifications, active job postings, and student applications.
                </p>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('admin.companies') }}"
                   class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs sm:text-sm font-semibold shadow-xs transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>Pending Approvals ({{ $pendingCompanyCount }})</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Core Dynamic Metrics Grid -->
    <div>
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-base font-bold text-slate-900 tracking-tight">
                Platform Key Metrics
            </h3>
            <span class="text-xs text-slate-500 font-medium">Click any card to inspect management details</span>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5">

            <!-- 1. Total Students Card -->
            <a href="{{ route('admin.students') }}"
               class="group bg-white rounded-2xl border border-slate-200 p-6 shadow-xs hover:shadow-md hover:border-indigo-300 transition-all flex flex-col justify-between">
                <div>
                    <div class="flex items-start justify-between">
                        <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                                <circle cx="9" cy="7" r="4" stroke-width="2"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M22 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/>
                            </svg>
                        </div>
                        <span class="text-xs font-semibold px-2 py-1 rounded-md bg-slate-100 text-slate-600">
                            Candidates
                        </span>
                    </div>

                    <div class="mt-4">
                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">
                            Total Students
                        </p>
                        <p class="text-3xl font-extrabold text-slate-900 mt-1">
                            {{ number_format($studentCount) }}
                        </p>
                    </div>
                </div>

                <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between text-xs font-semibold text-indigo-600 group-hover:text-indigo-700">
                    <span>Manage Students</span>
                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </div>
            </a>

            <!-- 2. Total Companies Card -->
            <a href="{{ route('admin.companies') }}"
               class="group bg-white rounded-2xl border border-slate-200 p-6 shadow-xs hover:shadow-md hover:border-emerald-300 transition-all flex flex-col justify-between">
                <div>
                    <div class="flex items-start justify-between">
                        <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center group-hover:bg-emerald-600 group-hover:text-white transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <rect x="4" y="2" width="16" height="20" rx="2" stroke-width="2"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 22v-4h6v4M8 6h.01M16 6h.01M8 10h.01M16 10h.01M8 14h.01M16 14h.01"/>
                            </svg>
                        </div>
                        <div class="flex items-center gap-1.5">
                            @if($pendingCompanyCount > 0)
                                <span class="text-xs font-semibold px-2 py-0.5 rounded-full bg-amber-50 text-amber-700 border border-amber-200">
                                    {{ $pendingCompanyCount }} Pending
                                </span>
                            @else
                                <span class="text-xs font-semibold px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200">
                                    All Verified
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="mt-4">
                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">
                            Total Companies
                        </p>
                        <p class="text-3xl font-extrabold text-slate-900 mt-1">
                            {{ number_format($companyCount) }}
                        </p>
                    </div>

                    <!-- Sub-metrics -->
                    <div class="mt-3 flex items-center gap-2 text-xs">
                        <span class="inline-flex items-center gap-1 font-medium text-emerald-700">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                            {{ $approvedCompanyCount }} Approved
                        </span>
                        <span class="text-slate-300">•</span>
                        <span class="inline-flex items-center gap-1 font-medium text-amber-700">
                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                            {{ $pendingCompanyCount }} Pending
                        </span>
                    </div>
                </div>

                <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between text-xs font-semibold text-emerald-600 group-hover:text-emerald-700">
                    <span>Manage Companies</span>
                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </div>
            </a>

            <!-- 3. Total Jobs Card -->
            <a href="{{ route('admin.jobs') }}"
               class="group bg-white rounded-2xl border border-slate-200 p-6 shadow-xs hover:shadow-md hover:border-purple-300 transition-all flex flex-col justify-between">
                <div>
                    <div class="flex items-start justify-between">
                        <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center group-hover:bg-purple-600 group-hover:text-white transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <rect x="2" y="7" width="20" height="14" rx="2" stroke-width="2"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>
                            </svg>
                        </div>
                        <span class="text-xs font-semibold px-2 py-0.5 rounded-full bg-purple-50 text-purple-700 border border-purple-200">
                            {{ $activeJobCount }} Active
                        </span>
                    </div>

                    <div class="mt-4">
                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">
                            Total Jobs Posted
                        </p>
                        <p class="text-3xl font-extrabold text-slate-900 mt-1">
                            {{ number_format($jobCount) }}
                        </p>
                    </div>

                    <!-- Sub-metrics -->
                    <div class="mt-3 flex items-center gap-2 text-xs">
                        <span class="inline-flex items-center gap-1 font-medium text-emerald-700">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                            {{ $activeJobCount }} Open
                        </span>
                        <span class="text-slate-300">•</span>
                        <span class="inline-flex items-center gap-1 font-medium text-slate-500">
                            <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                            {{ $closedJobCount }} Closed / Expired
                        </span>
                    </div>
                </div>

                <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between text-xs font-semibold text-purple-600 group-hover:text-purple-700">
                    <span>Manage Job Listings</span>
                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </div>
            </a>

            <!-- 4. Total Applications Card -->
            <a href="{{ route('admin.applications') }}"
               class="group bg-white rounded-2xl border border-slate-200 p-6 shadow-xs hover:shadow-md hover:border-amber-300 transition-all flex flex-col justify-between">
                <div>
                    <div class="flex items-start justify-between">
                        <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center group-hover:bg-amber-600 group-hover:text-white transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                <polyline points="14 2 14 8 20 8" stroke-width="2"/>
                                <line x1="16" y1="13" x2="8" y2="13" stroke-width="2"/>
                                <line x1="16" y1="17" x2="8" y2="17" stroke-width="2"/>
                            </svg>
                        </div>
                        <span class="text-xs font-semibold px-2 py-0.5 rounded-full bg-slate-100 text-slate-700">
                            Submissions
                        </span>
                    </div>

                    <div class="mt-4">
                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">
                            Total Applications
                        </p>
                        <p class="text-3xl font-extrabold text-slate-900 mt-1">
                            {{ number_format($applicationCount) }}
                        </p>
                    </div>

                    <!-- Application Breakdown Badges -->
                    <div class="mt-3 grid grid-cols-2 gap-1 text-[11px]">
                        <span class="text-amber-700 font-medium">Pending: {{ $pendingApplicationCount }}</span>
                        <span class="text-blue-700 font-medium">Shortlisted: {{ $shortlistedApplicationCount }}</span>
                        <span class="text-emerald-700 font-medium">Selected: {{ $selectedApplicationCount }}</span>
                        <span class="text-rose-700 font-medium">Rejected: {{ $rejectedApplicationCount }}</span>
                    </div>
                </div>

                <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between text-xs font-semibold text-amber-600 group-hover:text-amber-700">
                    <span>Manage Applications</span>
                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </div>
            </a>

        </div>
    </div>

    <!-- Section: Pending Company Approvals -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-base font-bold text-slate-900">
                        Pending Company Registrations
                    </h3>
                    <p class="text-xs text-slate-500 mt-0.5">
                        Companies awaiting administrative verification and approval
                    </p>
                </div>
            </div>

            <a href="{{ route('admin.companies') }}"
               class="text-xs font-semibold text-indigo-600 hover:text-indigo-700 hover:underline">
                View All Companies →
            </a>
        </div>

        @if($recentPendingCompanies->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs sm:text-sm">
                    <thead>
                        <tr class="bg-slate-50/75 border-b border-slate-100 text-[11px] font-semibold text-slate-500 uppercase tracking-wider">
                            <th class="px-6 py-3.5">Company & Owner</th>
                            <th class="px-6 py-3.5">Contact Details</th>
                            <th class="px-6 py-3.5">Industry</th>
                            <th class="px-6 py-3.5">Registered</th>
                            <th class="px-6 py-3.5 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($recentPendingCompanies as $company)
                            <tr class="hover:bg-slate-50/60 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="font-bold text-slate-900">
                                        {{ $company->company_name }}
                                    </div>
                                    <div class="text-xs text-slate-500 mt-0.5">
                                        Owner: {{ $company->owner_name ?? 'N/A' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-slate-800 font-medium">
                                        {{ $company->email }}
                                    </div>
                                    <div class="text-xs text-slate-400 mt-0.5">
                                        {{ $company->phone ?? 'No phone' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-700">
                                        {{ $company->industry ?? 'General' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-xs text-slate-500">
                                    {{ $company->created_at ? $company->created_at->format('M d, Y') : 'N/A' }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="inline-flex items-center gap-2">
                                        <form action="{{ route('admin.companies.approve', $company->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                    class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-semibold bg-emerald-600 hover:bg-emerald-700 text-white shadow-xs transition-colors">
                                                Approve
                                            </button>
                                        </form>

                                        <a href="{{ route('admin.companies') }}"
                                           class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-semibold bg-slate-100 hover:bg-slate-200 text-slate-700 transition-colors">
                                            Review
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="py-12 px-6 text-center">
                <div class="w-12 h-12 rounded-full bg-emerald-50 text-emerald-600 mx-auto flex items-center justify-center mb-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h4 class="text-sm font-bold text-slate-900">All Companies Verified</h4>
                <p class="text-xs text-slate-500 mt-1 max-w-sm mx-auto">
                    There are currently no company registrations pending approval. New company registrations will appear here for review.
                </p>
            </div>
        @endif
    </div>

    <!-- Section: Recent Job Postings & Recent Applications (2 Column Layout) -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

        <!-- Column 1: Recent Job Postings -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden flex flex-col justify-between">
            <div>
                <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-lg bg-purple-50 text-purple-600 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <rect x="2" y="7" width="20" height="14" rx="2" stroke-width="2"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-slate-900">Recent Job Postings</h3>
                            <p class="text-xs text-slate-500">Latest employment opportunities added</p>
                        </div>
                    </div>

                    <a href="{{ route('admin.jobs') }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-700 hover:underline">
                        View All →
                    </a>
                </div>

                @if($recentJobs->count() > 0)
                    <div class="divide-y divide-slate-100">
                        @foreach($recentJobs as $job)
                            <div class="p-4 sm:p-5 hover:bg-slate-50/60 transition-colors flex items-center justify-between gap-4">
                                <div class="min-w-0 flex-1">
                                    <div class="flex items-center gap-2">
                                        <h4 class="text-sm font-bold text-slate-900 truncate">
                                            {{ $job->job_title }}
                                        </h4>
                                        @if($job->status && $job->deadline >= now()->toDateString())
                                            <span class="px-2 py-0.5 rounded-full text-[10px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                                Active
                                            </span>
                                        @else
                                            <span class="px-2 py-0.5 rounded-full text-[10px] font-semibold bg-slate-100 text-slate-600 border border-slate-200">
                                                Closed
                                            </span>
                                        @endif
                                    </div>
                                    <p class="text-xs text-slate-500 mt-1">
                                        {{ $job->company->company_name ?? 'Company Deleted' }} &bull; {{ $job->location }} &bull; {{ $job->job_type }}
                                    </p>
                                    <p class="text-[11px] text-slate-400 mt-0.5">
                                        Deadline: {{ \Carbon\Carbon::parse($job->deadline)->format('M d, Y') }}
                                    </p>
                                </div>

                                <a href="{{ route('admin.jobs.show', $job->id) }}"
                                   class="shrink-0 px-3 py-1.5 rounded-lg text-xs font-semibold bg-slate-100 hover:bg-slate-200 text-slate-700 transition-colors">
                                    View
                                </a>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="py-12 px-6 text-center">
                        <div class="w-12 h-12 rounded-full bg-slate-100 text-slate-400 mx-auto flex items-center justify-center mb-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <rect x="2" y="7" width="20" height="14" rx="2" stroke-width="2"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>
                            </svg>
                        </div>
                        <h4 class="text-sm font-bold text-slate-900">No Job Postings Yet</h4>
                        <p class="text-xs text-slate-500 mt-1">
                            Companies have not posted any job listings.
                        </p>
                    </div>
                @endif
            </div>

            <div class="p-4 bg-slate-50/75 border-t border-slate-100 text-right">
                <a href="{{ route('admin.jobs') }}" class="text-xs font-semibold text-slate-600 hover:text-indigo-600">
                    Open Job Management Console &rarr;
                </a>
            </div>
        </div>

        <!-- Column 2: Recent Applications -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden flex flex-col justify-between">
            <div>
                <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                <polyline points="14 2 14 8 20 8" stroke-width="2"/>
                                <line x1="16" y1="13" x2="8" y2="13" stroke-width="2"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-slate-900">Recent Applications</h3>
                            <p class="text-xs text-slate-500">Candidate submissions for active listings</p>
                        </div>
                    </div>

                    <a href="{{ route('admin.applications') }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-700 hover:underline">
                        View All →
                    </a>
                </div>

                @if($recentApplications->count() > 0)
                    <div class="divide-y divide-slate-100">
                        @foreach($recentApplications as $app)
                            <div class="p-4 sm:p-5 hover:bg-slate-50/60 transition-colors flex items-center justify-between gap-4">
                                <div class="min-w-0 flex-1">
                                    <div class="flex items-center gap-2">
                                        <h4 class="text-sm font-bold text-slate-900 truncate">
                                            {{ $app->student->name ?? 'Candidate' }}
                                        </h4>
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-semibold
                                            @if($app->status === 'Pending') bg-amber-50 text-amber-700 border border-amber-200
                                            @elseif($app->status === 'Shortlisted') bg-blue-50 text-blue-700 border border-blue-200
                                            @elseif($app->status === 'Selected') bg-emerald-50 text-emerald-700 border border-emerald-200
                                            @else bg-rose-50 text-rose-700 border border-rose-200
                                            @endif">
                                            {{ $app->status }}
                                        </span>
                                    </div>
                                    <p class="text-xs text-slate-600 mt-1 truncate">
                                        For: <span class="font-medium text-slate-800">{{ $app->job->job_title ?? 'Job Deleted' }}</span>
                                        @if($app->job && $app->job->company)
                                            ({{ $app->job->company->company_name }})
                                        @endif
                                    </p>
                                    <p class="text-[11px] text-slate-400 mt-0.5">
                                        Submitted {{ $app->created_at ? $app->created_at->diffForHumans() : 'Recently' }}
                                    </p>
                                </div>

                                <a href="{{ route('admin.applications.show', $app->id) }}"
                                   class="shrink-0 px-3 py-1.5 rounded-lg text-xs font-semibold bg-slate-100 hover:bg-slate-200 text-slate-700 transition-colors">
                                    View
                                </a>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="py-12 px-6 text-center">
                        <div class="w-12 h-12 rounded-full bg-slate-100 text-slate-400 mx-auto flex items-center justify-center mb-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h7l5 5v11a2 2 0 01-2 2zM14 3v5h5"/>
                            </svg>
                        </div>
                        <h4 class="text-sm font-bold text-slate-900">No Applications Submitted</h4>
                        <p class="text-xs text-slate-500 mt-1">
                            No students have submitted applications yet.
                        </p>
                    </div>
                @endif
            </div>

            <div class="p-4 bg-slate-50/75 border-t border-slate-100 text-right">
                <a href="{{ route('admin.applications') }}" class="text-xs font-semibold text-slate-600 hover:text-indigo-600">
                    Open Applications Console &rarr;
                </a>
            </div>
        </div>

    </div>

</div>
@endsection
