@extends('layouts.admin')

@section('title', 'Job Management')
@section('header', 'Job Management')

@section('content')
<div class="space-y-6">

    <!-- Statistics Overview Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <!-- Total Jobs -->
        <a href="{{ route('admin.jobs') }}"
           class="bg-white rounded-2xl border border-slate-200 p-5 shadow-xs hover:border-indigo-300 transition-colors flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Total Jobs</p>
                <p class="text-2xl font-extrabold text-slate-900 mt-1">{{ number_format($totalJobsCount) }}</p>
                <p class="text-xs text-slate-400 mt-0.5">All posted vacancies</p>
            </div>
            <div class="w-11 h-11 rounded-xl bg-slate-100 text-slate-600 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <rect x="2" y="7" width="20" height="14" rx="2" ry="2" stroke-width="2"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>
                </svg>
            </div>
        </a>

        <!-- Active Jobs -->
        <a href="{{ route('admin.jobs', ['status' => 'active']) }}"
           class="bg-white rounded-2xl border border-slate-200 p-5 shadow-xs hover:border-emerald-300 transition-colors flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Active Jobs</p>
                <p class="text-2xl font-extrabold text-emerald-600 mt-1">{{ number_format($activeJobsCount) }}</p>
                <p class="text-xs text-slate-400 mt-0.5">Open & accepting candidates</p>
            </div>
            <div class="w-11 h-11 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </a>

        <!-- Expired Jobs -->
        <a href="{{ route('admin.jobs', ['status' => 'expired']) }}"
           class="bg-white rounded-2xl border border-slate-200 p-5 shadow-xs hover:border-rose-300 transition-colors flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Expired Jobs</p>
                <p class="text-2xl font-extrabold text-rose-600 mt-1">{{ number_format($expiredJobsCount) }}</p>
                <p class="text-xs text-slate-400 mt-0.5">Deadline date passed</p>
            </div>
            <div class="w-11 h-11 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10" stroke-width="2"/>
                    <polyline points="12 6 12 12 16 14" stroke-width="2"/>
                </svg>
            </div>
        </a>

        <!-- Total Applications -->
        <a href="{{ route('admin.applications') }}"
           class="bg-white rounded-2xl border border-slate-200 p-5 shadow-xs hover:border-amber-300 transition-colors flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Applications</p>
                <p class="text-2xl font-extrabold text-amber-600 mt-1">{{ number_format($totalApplicationsCount) }}</p>
                <p class="text-xs text-slate-400 mt-0.5">Total candidate submissions</p>
            </div>
            <div class="w-11 h-11 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                    <polyline points="14 2 14 8 20 8" stroke-width="2"/>
                    <line x1="16" y1="13" x2="8" y2="13" stroke-width="2"/>
                </svg>
            </div>
        </a>
    </div>

    <!-- Search & Filter Card -->
    <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-xs">
        <form method="GET" action="{{ route('admin.jobs') }}" class="space-y-4">
            <div class="flex flex-col md:flex-row gap-3">
                <!-- Search Input -->
                <div class="flex-1 relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <input type="text"
                           name="search"
                           value="{{ request('search') }}"
                           placeholder="Search by job title, company name, or location..."
                           class="w-full pl-10 pr-4 py-2 text-xs sm:text-sm rounded-xl border border-slate-200 focus:outline-hidden focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-slate-50/50">
                </div>

                <!-- Status Select Filter -->
                <div class="w-full md:w-48">
                    <select name="status"
                            class="w-full px-3 py-2 text-xs sm:text-sm rounded-xl border border-slate-200 focus:outline-hidden focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-slate-50/50 text-slate-700">
                        <option value="">All Statuses</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active Only</option>
                        <option value="expired" {{ request('status') === 'expired' ? 'selected' : '' }}>Expired Only</option>
                        <option value="closed" {{ request('status') === 'closed' ? 'selected' : '' }}>Closed Only</option>
                    </select>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center gap-2">
                    <button type="submit"
                            class="px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold bg-indigo-600 hover:bg-indigo-700 text-white shadow-xs transition-colors shrink-0">
                        Apply Filter
                    </button>

                    @if(request()->filled('search') || request()->filled('status'))
                        <a href="{{ route('admin.jobs') }}"
                           class="px-3 py-2 rounded-xl text-xs sm:text-sm font-semibold text-slate-600 hover:text-slate-900 bg-slate-100 hover:bg-slate-200 transition-colors shrink-0">
                            Clear
                        </a>
                    @endif
                </div>
            </div>

            <!-- Quick Status Filter Pills -->
            <div class="flex items-center gap-2 pt-2 border-t border-slate-100 text-xs overflow-x-auto">
                <span class="text-slate-400 font-medium shrink-0">Quick Filter:</span>
                <a href="{{ route('admin.jobs', array_merge(request()->except('status', 'page'), ['status' => ''])) }}"
                   class="px-2.5 py-1 rounded-lg font-medium transition-colors shrink-0 {{ empty(request('status')) ? 'bg-slate-900 text-white font-semibold' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                    All ({{ $totalJobsCount }})
                </a>
                <a href="{{ route('admin.jobs', array_merge(request()->except('status', 'page'), ['status' => 'active'])) }}"
                   class="px-2.5 py-1 rounded-lg font-medium transition-colors shrink-0 {{ request('status') === 'active' ? 'bg-emerald-600 text-white font-semibold' : 'bg-emerald-50 text-emerald-700 hover:bg-emerald-100 border border-emerald-200' }}">
                    Active ({{ $activeJobsCount }})
                </a>
                <a href="{{ route('admin.jobs', array_merge(request()->except('status', 'page'), ['status' => 'expired'])) }}"
                   class="px-2.5 py-1 rounded-lg font-medium transition-colors shrink-0 {{ request('status') === 'expired' ? 'bg-rose-600 text-white font-semibold' : 'bg-rose-50 text-rose-700 hover:bg-rose-100 border border-rose-200' }}">
                    Expired ({{ $expiredJobsCount }})
                </a>
                <a href="{{ route('admin.jobs', array_merge(request()->except('status', 'page'), ['status' => 'closed'])) }}"
                   class="px-2.5 py-1 rounded-lg font-medium transition-colors shrink-0 {{ request('status') === 'closed' ? 'bg-slate-700 text-white font-semibold' : 'bg-slate-100 text-slate-700 hover:bg-slate-200 border border-slate-200' }}">
                    Closed ({{ $closedJobsCount }})
                </a>
            </div>
        </form>
    </div>

    <!-- Jobs Table Container -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h3 class="text-sm sm:text-base font-bold text-slate-900">
                    Job Listings
                </h3>
                <p class="text-xs text-slate-500 mt-0.5">
                    Showing {{ $jobs->firstItem() ?? 0 }} to {{ $jobs->lastItem() ?? 0 }} of {{ $jobs->total() }} job postings
                </p>
            </div>
        </div>

        @if($jobs->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs sm:text-sm">
                    <thead>
                        <tr class="bg-slate-50/75 border-b border-slate-100 text-[11px] font-semibold text-slate-500 uppercase tracking-wider">
                            <th class="px-5 py-3.5">Job Title</th>
                            <th class="px-5 py-3.5">Company</th>
                            <th class="px-5 py-3.5">Location</th>
                            <th class="px-5 py-3.5">Type</th>
                            <th class="px-5 py-3.5">Applications</th>
                            <th class="px-5 py-3.5">Deadline</th>
                            <th class="px-5 py-3.5">Status</th>
                            <th class="px-5 py-3.5 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($jobs as $job)
                            @php
                                $isPastDeadline = \Carbon\Carbon::parse($job->deadline)->lt(now()->startOfDay());
                            @endphp
                            <tr class="hover:bg-slate-50/60 transition-colors">
                                <!-- Job Title -->
                                <td class="px-5 py-4">
                                    <div class="min-w-0">
                                        <a href="{{ route('admin.jobs.show', $job->id) }}"
                                           class="font-bold text-slate-900 hover:text-indigo-600 transition-colors truncate block">
                                            {{ $job->job_title }}
                                        </a>
                                        <span class="text-[11px] text-slate-400 block truncate">
                                            ID: #{{ $job->id }} &bull; Posted {{ $job->created_at ? $job->created_at->format('M d, Y') : 'N/A' }}
                                        </span>
                                    </div>
                                </td>

                                <!-- Company -->
                                <td class="px-5 py-4">
                                    @if($job->company)
                                        <div class="flex items-center gap-2.5">
                                            <div class="w-7 h-7 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold text-[11px] shrink-0 border border-indigo-100">
                                                {{ strtoupper(substr($job->company->company_name, 0, 1)) }}
                                            </div>
                                            <a href="{{ route('admin.companies.show', $job->company->id) }}"
                                               class="font-semibold text-slate-800 hover:text-indigo-600 truncate transition-colors">
                                                {{ $job->company->company_name }}
                                            </a>
                                        </div>
                                    @else
                                        <span class="text-slate-400 italic">No Company</span>
                                    @endif
                                </td>

                                <!-- Location -->
                                <td class="px-5 py-4 text-slate-600 whitespace-nowrap">
                                    {{ $job->location }}
                                </td>

                                <!-- Type -->
                                <td class="px-5 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[11px] font-medium bg-slate-100 text-slate-700">
                                        {{ $job->job_type }}
                                    </span>
                                </td>

                                <!-- Applications Count -->
                                <td class="px-5 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $job->applications_count > 0 ? 'bg-indigo-50 text-indigo-700 border border-indigo-200' : 'bg-slate-100 text-slate-600' }}">
                                        {{ $job->applications_count }} {{ Str::plural('applicant', $job->applications_count) }}
                                    </span>
                                </td>

                                <!-- Deadline -->
                                <td class="px-5 py-4 whitespace-nowrap text-slate-600">
                                    {{ \Carbon\Carbon::parse($job->deadline)->format('M d, Y') }}
                                </td>

                                <!-- Status Badge -->
                                <td class="px-5 py-4 whitespace-nowrap">
                                    @if(!$job->status)
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-slate-100 text-slate-700 border border-slate-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-slate-500"></span>
                                            Closed
                                        </span>
                                    @elseif($isPastDeadline)
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-rose-50 text-rose-700 border border-rose-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                            Expired
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                            Active
                                        </span>
                                    @endif
                                </td>

                                <!-- Actions -->
                                <td class="px-5 py-4 whitespace-nowrap text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <!-- View Details -->
                                        <a href="{{ route('admin.jobs.show', $job->id) }}"
                                           class="px-2.5 py-1.5 rounded-lg text-xs font-semibold bg-slate-100 text-slate-700 hover:bg-slate-200 transition-colors">
                                            View Details
                                        </a>

                                        <!-- Delete Job -->
                                        <form action="{{ route('admin.jobs.delete', $job->id) }}"
                                              method="POST"
                                              onsubmit="return confirm('Are you sure you want to delete this job posting? If this job has any candidate applications, deletion will be blocked.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="px-2.5 py-1.5 rounded-lg text-xs font-semibold bg-rose-50 text-rose-700 border border-rose-200 hover:bg-rose-100 transition-colors">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination Footer -->
            <div class="p-5 border-t border-slate-100">
                {{ $jobs->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-12 px-4">
                <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <rect x="2" y="7" width="20" height="14" rx="2" ry="2" stroke-width="2"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>
                    </svg>
                </div>
                <h4 class="text-sm font-bold text-slate-800">No Jobs Found</h4>
                <p class="text-xs text-slate-500 mt-1 max-w-sm mx-auto">
                    @if(request()->filled('search') || request()->filled('status'))
                        No job postings matched your current search and filter criteria. Try adjusting your keywords or clearing filters.
                    @else
                        There are no job postings registered in the system yet.
                    @endif
                </p>
                @if(request()->filled('search') || request()->filled('status'))
                    <a href="{{ route('admin.jobs') }}"
                       class="inline-flex items-center gap-1.5 mt-4 px-3.5 py-2 rounded-xl text-xs font-semibold bg-indigo-50 text-indigo-600 hover:bg-indigo-100 transition-colors">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        <span>Reset Filters</span>
                    </a>
                @endif
            </div>
        @endif
    </div>

</div>
@endsection
