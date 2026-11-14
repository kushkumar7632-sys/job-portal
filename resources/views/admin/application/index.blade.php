@extends('layouts.admin')

@section('title', 'Application Management')
@section('header', 'Application Management')

@section('content')
<div class="space-y-6">

    <!-- Statistics Overview Cards -->
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
        <!-- Total Applications -->
        <a href="{{ route('admin.applications') }}"
           class="bg-white rounded-2xl border border-slate-200 p-4 shadow-xs hover:border-indigo-300 transition-colors flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Total</p>
                <div class="w-8 h-8 rounded-lg bg-slate-100 text-slate-600 flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                        <polyline points="14 2 14 8 20 8" stroke-width="2"/>
                        <line x1="16" y1="13" x2="8" y2="13" stroke-width="2"/>
                    </svg>
                </div>
            </div>
            <p class="text-2xl font-extrabold text-slate-900 mt-2">{{ number_format($totalApplicationsCount) }}</p>
            <p class="text-[11px] text-slate-400 mt-0.5">All Submissions</p>
        </a>

        <!-- Pending -->
        <a href="{{ route('admin.applications', ['status' => 'Pending']) }}"
           class="bg-white rounded-2xl border border-slate-200 p-4 shadow-xs hover:border-amber-300 transition-colors flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Pending</p>
                <div class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10" stroke-width="2"/>
                        <polyline points="12 6 12 12 16 14" stroke-width="2"/>
                    </svg>
                </div>
            </div>
            <p class="text-2xl font-extrabold text-amber-600 mt-2">{{ number_format($pendingCount) }}</p>
            <p class="text-[11px] text-slate-400 mt-0.5">Awaiting Review</p>
        </a>

        <!-- Shortlisted -->
        <a href="{{ route('admin.applications', ['status' => 'Shortlisted']) }}"
           class="bg-white rounded-2xl border border-slate-200 p-4 shadow-xs hover:border-blue-300 transition-colors flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Shortlisted</p>
                <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                    </svg>
                </div>
            </div>
            <p class="text-2xl font-extrabold text-blue-600 mt-2">{{ number_format($shortlistedCount) }}</p>
            <p class="text-[11px] text-slate-400 mt-0.5">In Consideration</p>
        </a>

        <!-- Selected -->
        <a href="{{ route('admin.applications', ['status' => 'Selected']) }}"
           class="bg-white rounded-2xl border border-slate-200 p-4 shadow-xs hover:border-emerald-300 transition-colors flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Selected</p>
                <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
            <p class="text-2xl font-extrabold text-emerald-600 mt-2">{{ number_format($selectedCount) }}</p>
            <p class="text-[11px] text-slate-400 mt-0.5">Offer Extended</p>
        </a>

        <!-- Rejected -->
        <a href="{{ route('admin.applications', ['status' => 'Rejected']) }}"
           class="bg-white rounded-2xl border border-slate-200 p-4 shadow-xs hover:border-rose-300 transition-colors flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Rejected</p>
                <div class="w-8 h-8 rounded-lg bg-rose-50 text-rose-600 flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10" stroke-width="2"/>
                        <line x1="15" y1="9" x2="9" y2="15" stroke-width="2"/>
                        <line x1="9" y1="9" x2="15" y2="15" stroke-width="2"/>
                    </svg>
                </div>
            </div>
            <p class="text-2xl font-extrabold text-rose-600 mt-2">{{ number_format($rejectedCount) }}</p>
            <p class="text-[11px] text-slate-400 mt-0.5">Not Selected</p>
        </a>
    </div>

    <!-- Search & Filter Card -->
    <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-xs">
        <form method="GET" action="{{ route('admin.applications') }}" class="space-y-4">
            <div class="flex flex-col md:flex-row gap-3">
                <!-- Search Input -->
                <div class="flex-1 relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <label for="search-input" class="sr-only">Search Applications</label>
                    <input type="text"
                           id="search-input"
                           name="search"
                           value="{{ request('search') }}"
                           placeholder="Search by student name, email, job title, or company..."
                           class="w-full pl-10 pr-4 py-2 text-xs sm:text-sm rounded-xl border border-slate-200 focus:outline-hidden focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-slate-50/50">
                </div>

                <!-- Status Select Filter -->
                <div class="w-full md:w-48">
                    <label for="status-select" class="sr-only">Filter by Status</label>
                    <select id="status-select"
                            name="status"
                            class="w-full px-3 py-2 text-xs sm:text-sm rounded-xl border border-slate-200 focus:outline-hidden focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-slate-50/50 text-slate-700">
                        <option value="">All Statuses</option>
                        <option value="Pending" {{ strcasecmp(request('status'), 'Pending') === 0 ? 'selected' : '' }}>Pending</option>
                        <option value="Shortlisted" {{ strcasecmp(request('status'), 'Shortlisted') === 0 ? 'selected' : '' }}>Shortlisted</option>
                        <option value="Selected" {{ strcasecmp(request('status'), 'Selected') === 0 ? 'selected' : '' }}>Selected</option>
                        <option value="Rejected" {{ strcasecmp(request('status'), 'Rejected') === 0 ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center gap-2">
                    <button type="submit"
                            class="px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold bg-indigo-600 hover:bg-indigo-700 text-white shadow-xs transition-colors shrink-0">
                        Apply Filter
                    </button>

                    @if(request()->filled('search') || request()->filled('status'))
                        <a href="{{ route('admin.applications') }}"
                           class="px-3 py-2 rounded-xl text-xs sm:text-sm font-semibold text-slate-600 hover:text-slate-900 bg-slate-100 hover:bg-slate-200 transition-colors shrink-0">
                            Clear
                        </a>
                    @endif
                </div>
            </div>

            <!-- Quick Status Filter Pills -->
            <div class="flex items-center gap-2 pt-2 border-t border-slate-100 text-xs overflow-x-auto">
                <span class="text-slate-400 font-medium shrink-0">Quick Filter:</span>
                <a href="{{ route('admin.applications', array_merge(request()->except('status', 'page'), ['status' => ''])) }}"
                   class="px-2.5 py-1 rounded-lg font-medium transition-colors shrink-0 {{ empty(request('status')) ? 'bg-slate-900 text-white font-semibold' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                    All ({{ $totalApplicationsCount }})
                </a>
                <a href="{{ route('admin.applications', array_merge(request()->except('status', 'page'), ['status' => 'Pending'])) }}"
                   class="px-2.5 py-1 rounded-lg font-medium transition-colors shrink-0 {{ strcasecmp(request('status'), 'Pending') === 0 ? 'bg-amber-600 text-white font-semibold' : 'bg-amber-50 text-amber-700 hover:bg-amber-100 border border-amber-200' }}">
                    Pending ({{ $pendingCount }})
                </a>
                <a href="{{ route('admin.applications', array_merge(request()->except('status', 'page'), ['status' => 'Shortlisted'])) }}"
                   class="px-2.5 py-1 rounded-lg font-medium transition-colors shrink-0 {{ strcasecmp(request('status'), 'Shortlisted') === 0 ? 'bg-blue-600 text-white font-semibold' : 'bg-blue-50 text-blue-700 hover:bg-blue-100 border border-blue-200' }}">
                    Shortlisted ({{ $shortlistedCount }})
                </a>
                <a href="{{ route('admin.applications', array_merge(request()->except('status', 'page'), ['status' => 'Selected'])) }}"
                   class="px-2.5 py-1 rounded-lg font-medium transition-colors shrink-0 {{ strcasecmp(request('status'), 'Selected') === 0 ? 'bg-emerald-600 text-white font-semibold' : 'bg-emerald-50 text-emerald-700 hover:bg-emerald-100 border border-emerald-200' }}">
                    Selected ({{ $selectedCount }})
                </a>
                <a href="{{ route('admin.applications', array_merge(request()->except('status', 'page'), ['status' => 'Rejected'])) }}"
                   class="px-2.5 py-1 rounded-lg font-medium transition-colors shrink-0 {{ strcasecmp(request('status'), 'Rejected') === 0 ? 'bg-rose-600 text-white font-semibold' : 'bg-rose-50 text-rose-700 hover:bg-rose-100 border border-rose-200' }}">
                    Rejected ({{ $rejectedCount }})
                </a>
            </div>
        </form>
    </div>

    <!-- Applications Table Container -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h3 class="text-sm sm:text-base font-bold text-slate-900">
                    Application Records
                </h3>
                <p class="text-xs text-slate-500 mt-0.5">
                    Showing {{ $applications->firstItem() ?? 0 }} to {{ $applications->lastItem() ?? 0 }} of {{ $applications->total() }} applications
                </p>
            </div>
        </div>

        @if($applications->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs sm:text-sm">
                    <thead>
                        <tr class="bg-slate-50/75 border-b border-slate-100 text-[11px] font-semibold text-slate-500 uppercase tracking-wider">
                            <th class="px-5 py-3.5">Candidate</th>
                            <th class="px-5 py-3.5">Job Title</th>
                            <th class="px-5 py-3.5">Company</th>
                            <th class="px-5 py-3.5">Status</th>
                            <th class="px-5 py-3.5">Applied Date</th>
                            <th class="px-5 py-3.5">Resume</th>
                            <th class="px-5 py-3.5 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($applications as $application)
                            <tr class="hover:bg-slate-50/60 transition-colors">
                                <!-- Candidate -->
                                <td class="px-5 py-4">
                                    @if($application->student)
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold text-xs shrink-0 border border-indigo-100">
                                                {{ strtoupper(substr($application->student->name, 0, 1)) }}
                                            </div>
                                            <div class="min-w-0">
                                                <a href="{{ route('admin.students.show', $application->student->id) }}"
                                                   class="font-bold text-slate-900 hover:text-indigo-600 truncate block transition-colors">
                                                    {{ $application->student->name }}
                                                </a>
                                                <span class="text-[11px] text-slate-400 block truncate">
                                                    {{ $application->student->email }}
                                                </span>
                                            </div>
                                        </div>
                                    @else
                                        <span class="text-slate-400 italic">Candidate Unavailable</span>
                                    @endif
                                </td>

                                <!-- Job Title -->
                                <td class="px-5 py-4">
                                    @if($application->job)
                                        <a href="{{ route('admin.jobs.show', $application->job->id) }}"
                                           class="font-semibold text-slate-900 hover:text-indigo-600 truncate block transition-colors">
                                            {{ $application->job->job_title }}
                                        </a>
                                        <span class="text-[11px] text-slate-400 block truncate">
                                            {{ $application->job->location }}
                                        </span>
                                    @else
                                        <span class="text-slate-400 italic">Job Unavailable</span>
                                    @endif
                                </td>

                                <!-- Company -->
                                <td class="px-5 py-4">
                                    @if($application->job && $application->job->company)
                                        <a href="{{ route('admin.companies.show', $application->job->company->id) }}"
                                           class="font-medium text-slate-800 hover:text-indigo-600 truncate block transition-colors">
                                            {{ $application->job->company->company_name }}
                                        </a>
                                    @else
                                        <span class="text-slate-400 italic">Company Unavailable</span>
                                    @endif
                                </td>

                                <!-- Status Badge -->
                                <td class="px-5 py-4 whitespace-nowrap">
                                    @if($application->status === 'Pending')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                            Pending
                                        </span>
                                    @elseif($application->status === 'Shortlisted')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                                            Shortlisted
                                        </span>
                                    @elseif($application->status === 'Selected')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                            Selected
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-rose-50 text-rose-700 border border-rose-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                            Rejected
                                        </span>
                                    @endif
                                </td>

                                <!-- Applied Date -->
                                <td class="px-5 py-4 whitespace-nowrap text-slate-600">
                                    {{ $application->created_at ? $application->created_at->format('M d, Y') : 'N/A' }}
                                </td>

                                <!-- Resume -->
                                <td class="px-5 py-4 whitespace-nowrap">
                                    @if($application->resume)
                                        <a href="{{ route('applications.resume.download', $application->id) }}"
                                           target="_blank"
                                           class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-semibold bg-indigo-50 text-indigo-700 hover:bg-indigo-100 border border-indigo-200 transition-colors">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                            <span>Resume</span>
                                        </a>
                                    @else
                                        <span class="text-xs text-slate-400 italic">No Resume</span>
                                    @endif
                                </td>

                                <!-- Actions -->
                                <td class="px-5 py-4 whitespace-nowrap text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <!-- View Details -->
                                        <a href="{{ route('admin.applications.show', $application->id) }}"
                                           class="px-2.5 py-1.5 rounded-lg text-xs font-semibold bg-slate-100 text-slate-700 hover:bg-slate-200 transition-colors">
                                            View
                                        </a>

                                        <!-- Delete Application -->
                                        <form action="{{ route('admin.applications.delete', $application->id) }}"
                                              method="POST"
                                              onsubmit="return confirm('Are you sure you want to delete this application record? This action cannot be undone.');">
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
                {{ $applications->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-12 px-4">
                <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                        <polyline points="14 2 14 8 20 8" stroke-width="2"/>
                        <line x1="16" y1="13" x2="8" y2="13" stroke-width="2"/>
                    </svg>
                </div>
                <h4 class="text-sm font-bold text-slate-800">No Applications Found</h4>
                <p class="text-xs text-slate-500 mt-1 max-w-sm mx-auto">
                    @if(request()->filled('search') || request()->filled('status'))
                        No application records matched your current search and filter criteria. Try adjusting your query or resetting filters.
                    @else
                        There are no student application records registered in the system yet.
                    @endif
                </p>
                @if(request()->filled('search') || request()->filled('status'))
                    <a href="{{ route('admin.applications') }}"
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
