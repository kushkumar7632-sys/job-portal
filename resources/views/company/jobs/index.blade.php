@extends('layouts.company')

@section('title', 'Manage Jobs')
@section('header', 'Manage Jobs')
@section('subheader', 'Review, filter, and manage your active and closed job postings')

@section('content')
<div class="space-y-8">

    <!-- Top Action Bar & Breadcrumbs -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <nav class="flex items-center gap-2 text-xs font-medium text-slate-400">
            <a href="{{ route('company.dashboard') }}" class="hover:text-blue-600 transition">Dashboard</a>
            <span>/</span>
            <span class="text-blue-600 font-semibold">Manage Jobs</span>
        </nav>

        <a href="{{ route('company.job.create') }}"
           class="inline-flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-5 py-2.5 rounded-lg shadow-sm transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Post New Job
        </a>
    </div>

    <!-- Statistics Cards -->
    <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">

        <!-- Total Jobs -->
        <div class="bg-white border border-slate-200 rounded-xl p-6 shadow-xs hover:border-slate-300 transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">
                        Total Jobs Posted
                    </p>
                    <h3 class="text-3xl font-bold text-slate-900 mt-3">
                        {{ $totalJobs ?? $jobs->total() }}
                    </h3>
                    <p class="text-xs text-slate-400 mt-1.5">
                        All company job openings
                    </p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 6h16M4 10h16M4 14h10M4 18h10"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Active Jobs -->
        <div class="bg-white border border-slate-200 rounded-xl p-6 shadow-xs hover:border-slate-300 transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">
                        Active Listings
                    </p>
                    <h3 class="text-3xl font-bold text-emerald-600 mt-3">
                        {{ $activeJobs ?? $jobs->where('status', true)->count() }}
                    </h3>
                    <p class="text-xs text-slate-400 mt-1.5">
                        Accepting candidate applications
                    </p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12l2 2 4-4m5-3v5a9 9 0 11-18 0V7l9-4 9 4z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Vacancies -->
        <div class="bg-white border border-slate-200 rounded-xl p-6 shadow-xs hover:border-slate-300 transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">
                        Total Vacancies
                    </p>
                    <h3 class="text-3xl font-bold text-indigo-600 mt-3">
                        {{ $totalVacancies ?? $jobs->sum('vacancy') }}
                    </h3>
                    <p class="text-xs text-slate-400 mt-1.5">
                        Available positions across listings
                    </p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2m12-13a4 4 0 11-8 0 4 4 0 018 0zm2 4a4 4 0 014 4v2"/>
                    </svg>
                </div>
            </div>
        </div>

    </section>

    <!-- Jobs Table & Filters -->
    <section class="bg-white border border-slate-200 rounded-2xl shadow-xs overflow-hidden">

        <!-- Header Toolbar -->
        <div class="px-6 py-5 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h3 class="text-lg font-bold text-slate-900">
                    Posted Job Listings
                </h3>
                <p class="text-xs text-slate-400 mt-0.5">
                    Filter and manage your recruitment pipeline
                </p>
            </div>

            <!-- Search Form -->
            <form action="{{ route('company.jobs') }}" method="GET" class="flex items-center gap-2 flex-wrap">
                <div class="relative">
                    <input type="text"
                           name="search"
                           value="{{ request('search') }}"
                           placeholder="Search job title or location..."
                           class="pl-9 pr-3 py-2 text-xs rounded-lg border border-slate-300 bg-white text-slate-800 outline-none transition focus:border-blue-600 focus:ring-2 focus:ring-blue-100 w-56 sm:w-64">
                    <svg class="w-4 h-4 text-slate-400 absolute left-2.5 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <circle cx="11" cy="11" r="7" stroke-width="1.8"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="m16 16 4 4"/>
                    </svg>
                </div>

                <button type="submit"
                        class="text-xs bg-slate-900 hover:bg-slate-800 text-white px-4 py-2 rounded-lg font-semibold transition">
                    Search
                </button>

                @if(request('search'))
                    <a href="{{ route('company.jobs') }}"
                       class="text-xs text-slate-500 hover:text-slate-800 py-2 px-1 font-medium transition">
                        Reset
                    </a>
                @endif
            </form>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse min-w-[900px]">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100 text-xs font-bold uppercase tracking-wider text-slate-500">
                        <th class="py-4 px-6">Job Details</th>
                        <th class="py-4 px-6">Location</th>
                        <th class="py-4 px-6">Salary</th>
                        <th class="py-4 px-6">Vacancies</th>
                        <th class="py-4 px-6">Deadline</th>
                        <th class="py-4 px-6 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @forelse($jobs as $job)
                        <tr class="hover:bg-slate-50/70 transition">

                            <!-- Job Title & Badges -->
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-700 flex items-center justify-center text-sm font-bold shrink-0">
                                        {{ strtoupper(substr($job->job_title, 0, 1)) }}
                                    </div>
                                    <div class="min-w-0">
                                        <h4 class="font-bold text-slate-900 text-sm">
                                            {{ $job->job_title }}
                                        </h4>
                                        <div class="flex items-center gap-2 mt-1 flex-wrap">
                                            @if($job->status)
                                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[11px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                                    Active
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[11px] font-semibold bg-slate-100 text-slate-600 border border-slate-200">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                                                    Closed
                                                </span>
                                            @endif

                                            <span class="text-xs text-slate-400">&bull;</span>

                                            <span class="text-xs font-medium text-slate-500">
                                                {{ $job->job_type }}
                                            </span>

                                            <span class="text-xs text-slate-400">&bull;</span>

                                            <a href="{{ route('company.job.applications', $job->id) }}"
                                               class="inline-flex items-center px-2 py-0.5 rounded-md text-[11px] font-semibold bg-blue-50 text-blue-700 hover:bg-blue-100 border border-blue-200 transition">
                                                {{ $job->applications_count ?? $job->applications()->count() }} Applicants
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <!-- Location -->
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-1.5 text-slate-600 text-xs">
                                    <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M20 10c0 5-8 11-8 11S4 15 4 10a8 8 0 1116 0z"/>
                                        <circle cx="12" cy="10" r="2.5" stroke-width="1.8"/>
                                    </svg>
                                    <span>{{ $job->location }}</span>
                                </div>
                            </td>

                            <!-- Salary -->
                            <td class="py-4 px-6">
                                <span class="text-xs font-semibold text-slate-800">
                                    {{ $job->salary }}
                                </span>
                            </td>

                            <!-- Vacancy -->
                            <td class="py-4 px-6">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-semibold bg-slate-100 text-slate-700">
                                    {{ $job->vacancy }} Openings
                                </span>
                            </td>

                            <!-- Deadline -->
                            <td class="py-4 px-6 text-xs text-slate-500 font-medium">
                                {{ $job->deadline }}
                            </td>

                            <!-- Actions -->
                            <td class="py-4 px-6 text-right">
                                <div class="flex justify-end items-center gap-2">

                                    <!-- View Applicants -->
                                    <a href="{{ route('company.job.applications', $job->id) }}"
                                       title="View Job Applicants"
                                       class="inline-flex items-center gap-1.5 bg-blue-50 text-blue-700 border border-blue-200 px-3 py-1.5 rounded-lg text-xs font-semibold hover:bg-blue-100 transition">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2m12-13a4 4 0 11-8 0 4 4 0 018 0zm2 4a4 4 0 014 4v2"/>
                                        </svg>
                                        Applicants
                                    </a>

                                    <!-- Edit -->
                                    <a href="{{ route('job.edit', $job->id) }}"
                                       title="Edit Job"
                                       class="inline-flex items-center gap-1.5 bg-amber-50 text-amber-700 border border-amber-200 px-3 py-1.5 rounded-lg text-xs font-semibold hover:bg-amber-100 transition">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16.862 4.487l1.687-1.688a2.121 2.121 0 013 3l-1.688 1.688M16.862 4.487L7.5 13.85l-1 4 4-1 9.362-9.363"/>
                                        </svg>
                                        Edit
                                    </a>

                                    <!-- Delete -->
                                    <form action="{{ route('job.delete', $job->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('Are you sure you want to delete this job posting? All associated applications will also be affected.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                title="Delete Job"
                                                class="inline-flex items-center gap-1.5 bg-red-50 text-red-600 border border-red-200 px-3 py-1.5 rounded-lg text-xs font-semibold hover:bg-red-100 transition">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 7h16m-10 4v6m4-6v6M5 7l1 14h12l1-14M9 7V4h6v3"/>
                                            </svg>
                                            Delete
                                        </button>
                                    </form>

                                </div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-16 text-center">
                                <div class="w-16 h-16 mx-auto rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mb-4">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 7h16M4 12h16M4 17h10"/>
                                    </svg>
                                </div>
                                <h4 class="text-base font-bold text-slate-800">
                                    No Job Listings Found
                                </h4>
                                <p class="text-xs text-slate-500 mt-1 max-w-sm mx-auto">
                                    @if(request('search'))
                                        No jobs matched your search criteria. Try a different query or reset filters.
                                    @else
                                        You haven't posted any jobs yet. Create your first opening to start receiving applications.
                                    @endif
                                </p>
                                <div class="mt-5">
                                    @if(request('search'))
                                        <a href="{{ route('company.jobs') }}"
                                           class="inline-flex items-center gap-2 text-xs font-semibold text-blue-600 hover:underline">
                                            Reset Search
                                        </a>
                                    @else
                                        <a href="{{ route('company.job.create') }}"
                                           class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold px-4 py-2 rounded-lg transition">
                                            Post Your First Job &rarr;
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination & Footer -->
        @if($jobs->count() > 0)
            <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 text-xs text-slate-500">
                    <p>
                        Showing
                        <span class="font-bold text-slate-800">{{ $jobs->firstItem() ?? 1 }}</span>
                        to
                        <span class="font-bold text-slate-800">{{ $jobs->lastItem() ?? $jobs->count() }}</span>
                        of
                        <span class="font-bold text-slate-800">{{ $jobs->total() }}</span>
                        job listings
                    </p>

                    <a href="{{ route('company.job.create') }}"
                       class="text-blue-600 hover:underline font-semibold">
                        Post Another Job &rarr;
                    </a>
                </div>

                @if($jobs->hasPages())
                    <div class="mt-4 pt-4 border-t border-slate-200">
                        {{ $jobs->links() }}
                    </div>
                @endif
            </div>
        @endif

    </section>

</div>
@endsection
