@extends('layouts.company')

@section('title', isset($selectedJob) ? 'Applicants for ' . $selectedJob->job_title : 'Candidate Applications')
@section('header', isset($selectedJob) ? 'Applicants: ' . $selectedJob->job_title : 'Candidate Applications')
@section('subheader', isset($selectedJob) ? 'Review applicants submitted for this job opening' : 'Review candidates and manage hiring decisions')

@section('content')
<div class="space-y-6">

    <!-- Breadcrumb & Context Navigation -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <nav class="flex items-center gap-2 text-xs font-medium text-slate-400">
            <a href="{{ route('company.dashboard') }}" class="hover:text-blue-600 transition">Dashboard</a>
            <span>/</span>
            @if(isset($selectedJob))
                <a href="{{ route('company.applications') }}" class="hover:text-blue-600 transition">Applications</a>
                <span>/</span>
                <span class="text-blue-600 font-semibold">{{ $selectedJob->job_title }}</span>
            @else
                <span class="text-blue-600 font-semibold">Candidate Applications</span>
            @endif
        </nav>

        @if(isset($selectedJob))
            <a href="{{ route('company.applications') }}"
               class="text-xs font-semibold text-blue-600 hover:underline">
                &larr; View All Company Applicants
            </a>
        @endif
    </div>

    <!-- Active Job Focus Banner (when filtering by specific job) -->
    @if(isset($selectedJob))
        <div class="bg-blue-50/70 border border-blue-200/80 rounded-xl p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3 shadow-xs">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-blue-600 text-white flex items-center justify-center font-bold text-sm shrink-0">
                    {{ strtoupper(substr($selectedJob->job_title, 0, 1)) }}
                </div>
                <div>
                    <h3 class="text-sm font-bold text-slate-900">
                        {{ $selectedJob->job_title }}
                    </h3>
                    <p class="text-xs text-slate-500 mt-0.5">
                        {{ $selectedJob->location }} &bull; {{ $selectedJob->job_type }} &bull; {{ $selectedJob->vacancy }} Openings
                    </p>
                </div>
            </div>

            <div class="flex items-center gap-2">
                <a href="{{ route('job.edit', $selectedJob->id) }}"
                   class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 rounded-lg text-xs font-medium transition">
                    Edit Opening
                </a>
            </div>
        </div>
    @endif

    <!-- Search & Filter Toolbar -->
    <section class="bg-white border border-slate-200 rounded-2xl p-5 sm:p-6 shadow-xs">
        <form action="{{ isset($selectedJob) ? route('company.job.applications', $selectedJob->id) : route('company.applications') }}" method="GET" class="space-y-4">

            <div class="grid grid-cols-1 md:grid-cols-12 gap-4">

                <!-- Candidate Search -->
                <div class="{{ isset($selectedJob) ? 'md:col-span-8' : 'md:col-span-5' }}">
                    <label for="search" class="block text-xs font-semibold uppercase tracking-wider text-slate-500 mb-1.5">
                        Candidate Search
                    </label>
                    <div class="relative">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="11" cy="11" r="7"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="m16 16 4 4"/>
                            </svg>
                        </div>
                        <input type="text"
                               id="search"
                               name="search"
                               value="{{ request('search') }}"
                               placeholder="Search candidate name or email..."
                               class="w-full rounded-lg border border-slate-300 bg-white py-2.5 pl-10 pr-4 text-sm text-slate-800 placeholder-slate-400 outline-none transition focus:border-blue-600 focus:ring-2 focus:ring-blue-100">
                    </div>
                </div>

                <!-- Job Filter (Only shown when not already on a job-specific view) -->
                @if(!isset($selectedJob))
                    <div class="md:col-span-4">
                        <label for="job_id" class="block text-xs font-semibold uppercase tracking-wider text-slate-500 mb-1.5">
                            Job Position
                        </label>
                        <select id="job_id"
                                name="job_id"
                                class="w-full rounded-lg border border-slate-300 bg-white py-2.5 px-3.5 text-sm text-slate-800 outline-none transition focus:border-blue-600 focus:ring-2 focus:ring-blue-100">
                            <option value="">All Job Positions</option>
                            @foreach($jobs as $job)
                                <option value="{{ $job->id }}" {{ (string) request('job_id') === (string) $job->id ? 'selected' : '' }}>
                                    {{ $job->job_title }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                @endif

                <!-- Status Filter -->
                <div class="{{ isset($selectedJob) ? 'md:col-span-4' : 'md:col-span-3' }}">
                    <label for="status" class="block text-xs font-semibold uppercase tracking-wider text-slate-500 mb-1.5">
                        Hiring Status
                    </label>
                    <select id="status"
                            name="status"
                            class="w-full rounded-lg border border-slate-300 bg-white py-2.5 px-3.5 text-sm text-slate-800 outline-none transition focus:border-blue-600 focus:ring-2 focus:ring-blue-100">
                        <option value="">All Statuses</option>
                        <option value="Pending" {{ request('status') === 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option value="Shortlisted" {{ request('status') === 'Shortlisted' ? 'selected' : '' }}>Shortlisted</option>
                        <option value="Selected" {{ request('status') === 'Selected' ? 'selected' : '' }}>Selected</option>
                        <option value="Rejected" {{ request('status') === 'Rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>

            </div>

            <!-- Toolbar Footer Actions -->
            <div class="flex items-center justify-between pt-3 border-t border-slate-100 flex-wrap gap-3">
                <span class="text-xs text-slate-400 font-medium">
                    Showing {{ $applications->total() }} total {{ Str::plural('application', $applications->total()) }}
                </span>

                <div class="flex items-center gap-3">
                    @if(request()->hasAny(['search', 'status', 'job_id']) && (request('search') || request('status') || request('job_id')))
                        <a href="{{ isset($selectedJob) ? route('company.job.applications', $selectedJob->id) : route('company.applications') }}"
                           class="inline-flex items-center gap-1.5 px-3.5 py-2 border border-slate-300 rounded-lg text-xs font-semibold text-slate-600 hover:bg-slate-50 transition">
                            Clear Filters
                        </a>
                    @endif

                    <button type="submit"
                            class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg text-sm font-semibold transition shadow-sm">
                        Filter Applications
                    </button>
                </div>
            </div>

        </form>
    </section>

    <!-- Candidate Applications Table -->
    @if($applications->count() > 0)
        <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-xs">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse min-w-[900px]">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-100 text-xs font-bold uppercase tracking-wider text-slate-500">
                            <th class="py-4 px-6">Candidate</th>
                            <th class="py-4 px-6">Applied Position</th>
                            <th class="py-4 px-6">Submission Date</th>
                            <th class="py-4 px-6">Status</th>
                            <th class="py-4 px-6">Resume</th>
                            <th class="py-4 px-6 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm">
                        @foreach($applications as $application)
                            <tr class="hover:bg-slate-50/70 transition">

                                <!-- Candidate Name & Contact -->
                                <td class="py-4 px-6">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-blue-50 border border-blue-100 text-blue-700 flex items-center justify-center font-bold text-sm shrink-0">
                                            {{ strtoupper(substr($application->student->name ?? 'C', 0, 1)) }}
                                        </div>
                                        <div class="min-w-0">
                                            <a href="{{ route('company.application.show', $application->id) }}"
                                               class="font-semibold text-slate-900 hover:text-blue-600 transition block truncate text-sm">
                                                {{ $application->student->name ?? 'Candidate' }}
                                            </a>
                                            <p class="text-xs text-slate-400 truncate">
                                                {{ $application->student->email ?? 'N/A' }}
                                            </p>
                                            @if(!empty($application->student->phone))
                                                <p class="text-[11px] text-slate-400 mt-0.5">
                                                    {{ $application->student->phone }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                </td>

                                <!-- Applied Position -->
                                <td class="py-4 px-6">
                                    <p class="font-medium text-slate-800 text-sm">
                                        {{ $application->job->job_title ?? 'Job Title' }}
                                    </p>
                                    <span class="inline-block mt-0.5 text-xs text-slate-400">
                                        {{ $application->job->job_type ?? '' }}
                                    </span>
                                </td>

                                <!-- Applied Date -->
                                <td class="py-4 px-6 text-xs text-slate-500">
                                    {{ $application->created_at ? $application->created_at->format('M d, Y') : 'N/A' }}
                                    <p class="text-[11px] text-slate-400 mt-0.5">
                                        {{ $application->created_at ? $application->created_at->diffForHumans() : '' }}
                                    </p>
                                </td>

                                <!-- Status Badge -->
                                <td class="py-4 px-6">
                                    @if($application->status === 'Pending')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                            Pending Review
                                        </span>
                                    @elseif($application->status === 'Shortlisted')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                                            Shortlisted
                                        </span>
                                    @elseif($application->status === 'Selected')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                            Selected
                                        </span>
                                    @elseif($application->status === 'Rejected')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-red-50 text-red-700 border border-red-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                            Rejected
                                        </span>
                                    @endif
                                </td>

                                <!-- Resume Link -->
                                <td class="py-4 px-6">
                                    @if($application->resume)
                                        <a href="{{ route('applications.resume.download', $application->id) }}"
                                           target="_blank"
                                           class="inline-flex items-center gap-1.5 text-xs font-semibold text-blue-600 hover:text-blue-800 bg-blue-50 border border-blue-100 px-3 py-1.5 rounded-lg transition">
                                            <svg class="w-3.5 h-3.5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                            </svg>
                                            Download Resume
                                        </a>
                                    @else
                                        <span class="text-xs text-slate-400">
                                            No resume
                                        </span>
                                    @endif
                                </td>

                                <!-- Action -->
                                <td class="py-4 px-6 text-right">
                                    <a href="{{ route('company.application.show', $application->id) }}"
                                       class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg border border-slate-300 text-xs font-semibold text-slate-700 hover:bg-slate-50 transition">
                                        Review
                                        <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </a>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
                {{ $applications->links() }}
            </div>
        </div>
    @else
        <!-- Empty State -->
        <div class="bg-white border border-slate-200 rounded-2xl p-12 text-center shadow-xs">
            <div class="w-16 h-16 bg-slate-100 text-slate-400 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
            </div>
            <h3 class="text-lg font-bold text-slate-800">
                No Candidate Applications Found
            </h3>
            <p class="text-xs text-slate-500 mt-1 max-w-md mx-auto">
                @if(request()->hasAny(['search', 'status', 'job_id']) && (request('search') || request('status') || request('job_id')))
                    No applications matched your active search or filter criteria. Try clearing the filters.
                @else
                    No candidates have applied to your job postings yet. When students submit applications, they will appear here.
                @endif
            </p>

            @if(request()->hasAny(['search', 'status', 'job_id']) && (request('search') || request('status') || request('job_id')))
                <div class="mt-5">
                    <a href="{{ isset($selectedJob) ? route('company.job.applications', $selectedJob->id) : route('company.applications') }}"
                       class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold px-4 py-2 rounded-lg transition">
                        Clear Active Filters
                    </a>
                </div>
            @endif
        </div>
    @endif

</div>
@endsection
