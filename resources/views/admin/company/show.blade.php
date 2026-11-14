@extends('layouts.admin')

@section('title', 'Company Details - ' . $company->company_name)
@section('header', 'Company Details')

@section('content')
<div class="space-y-6">

    <!-- Top Action / Back Navigation Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <a href="{{ route('admin.companies') }}"
           class="inline-flex items-center gap-2 text-xs font-semibold text-slate-600 hover:text-indigo-600 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            <span>Back to Company Management</span>
        </a>

        <div class="flex items-center gap-2">
            @if($company->is_approved)
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                    Approved
                </span>
                <form action="{{ route('admin.companies.reject', $company->id) }}"
                      method="POST"
                      onsubmit="return confirm('Are you sure you want to reject {{ addslashes($company->company_name) }}? Their employer session will be revoked and job postings hidden.');">
                    @csrf
                    @method('PATCH')
                    <button type="submit"
                            class="px-3 py-1.5 rounded-lg text-xs font-semibold bg-rose-50 text-rose-700 border border-rose-200 hover:bg-rose-100 transition-colors">
                        Reject Company
                    </button>
                </form>
            @else
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                    Pending Approval
                </span>
                <form action="{{ route('admin.companies.approve', $company->id) }}"
                      method="POST"
                      onsubmit="return confirm('Are you sure you want to approve {{ addslashes($company->company_name) }}?');">
                    @csrf
                    @method('PATCH')
                    <button type="submit"
                            class="px-3 py-1.5 rounded-lg text-xs font-semibold bg-emerald-600 text-white hover:bg-emerald-700 transition-colors shadow-xs">
                        Approve Company
                    </button>
                </form>
            @endif
        </div>
    </div>

    <!-- Company Overview Card -->
    <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-xs">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pb-6 border-b border-slate-100">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold text-xl border border-indigo-100 shrink-0">
                    {{ strtoupper(substr($company->company_name, 0, 1)) }}
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <h2 class="text-xl font-bold text-slate-900">
                            {{ $company->company_name }}
                        </h2>
                        @if($company->is_approved)
                            <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[11px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                Verified
                            </span>
                        @else
                            <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[11px] font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                                Unverified
                            </span>
                        @endif
                    </div>
                    <p class="text-xs text-slate-500 mt-1">
                        Owner: <span class="font-medium text-slate-800">{{ $company->owner_name }}</span> &bull; Industry: <span class="font-medium text-slate-800">{{ $company->industry }}</span>
                    </p>
                </div>
            </div>

            <!-- Quick Metrics Counter -->
            <div class="flex items-center gap-5">
                <div class="text-right">
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Jobs</p>
                    <p class="text-xl font-extrabold text-slate-900 mt-0.5">{{ number_format($totalJobsCount) }}</p>
                </div>
                <div class="h-8 w-px bg-slate-200"></div>
                <div class="text-right">
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Applications</p>
                    <p class="text-xl font-extrabold text-indigo-600 mt-0.5">{{ number_format($totalApplicationsCount) }}</p>
                </div>
            </div>
        </div>

        <!-- Detailed Profile Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 pt-6 text-xs sm:text-sm">
            <div>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Email Address</p>
                <p class="font-semibold text-slate-900 mt-1 break-all">{{ $company->email }}</p>
            </div>
            <div>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Phone Number</p>
                <p class="font-semibold text-slate-900 mt-1">{{ $company->phone ?? 'Not provided' }}</p>
            </div>
            <div>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Website</p>
                <p class="font-semibold text-slate-900 mt-1">
                    @if($company->website)
                        <a href="{{ Str::startsWith($company->website, 'http') ? $company->website : 'https://' . $company->website }}" target="_blank" class="text-indigo-600 hover:underline">
                            {{ $company->website }}
                        </a>
                    @else
                        Not provided
                    @endif
                </p>
            </div>
            <div>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Registration Date</p>
                <p class="font-semibold text-slate-900 mt-1">
                    {{ $company->created_at ? $company->created_at->format('M d, Y') : 'N/A' }}
                </p>
            </div>
            <div class="sm:col-span-2 lg:col-span-4">
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Company Address</p>
                <p class="font-semibold text-slate-900 mt-1">{{ $company->address ?? 'Not provided' }}</p>
            </div>
        </div>
    </div>

    <!-- Company Job Postings Table Section -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h3 class="text-sm sm:text-base font-bold text-slate-900">
                    Job Postings by {{ $company->company_name }}
                </h3>
                <p class="text-xs text-slate-500 mt-0.5">
                    Showing jobs created exclusively by this employer ({{ $jobs->total() }} total)
                </p>
            </div>
        </div>

        @if($jobs->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs sm:text-sm">
                    <thead>
                        <tr class="bg-slate-50/75 border-b border-slate-100 text-[11px] font-semibold text-slate-500 uppercase tracking-wider">
                            <th class="px-5 py-3.5">Job Title</th>
                            <th class="px-5 py-3.5">Job Type</th>
                            <th class="px-5 py-3.5">Location</th>
                            <th class="px-5 py-3.5">Applications</th>
                            <th class="px-5 py-3.5">Deadline</th>
                            <th class="px-5 py-3.5">Status</th>
                            <th class="px-5 py-3.5 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($jobs as $job)
                            <tr class="hover:bg-slate-50/60 transition-colors">
                                <td class="px-5 py-4 font-bold text-slate-900">
                                    {{ $job->job_title }}
                                </td>
                                <td class="px-5 py-4 text-slate-600 whitespace-nowrap">
                                    {{ $job->job_type }}
                                </td>
                                <td class="px-5 py-4 text-slate-600 whitespace-nowrap">
                                    {{ $job->location }}
                                </td>
                                <td class="px-5 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-700">
                                        {{ $job->applications_count }} Applications
                                    </span>
                                </td>
                                <td class="px-5 py-4 text-slate-600 whitespace-nowrap">
                                    {{ $job->deadline ? \Carbon\Carbon::parse($job->deadline)->format('M d, Y') : 'N/A' }}
                                </td>
                                <td class="px-5 py-4 whitespace-nowrap">
                                    @if($job->status && $job->deadline >= now()->toDateString())
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                            Active
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-slate-100 text-slate-600 border border-slate-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                                            Closed / Expired
                                        </span>
                                    @endif
                                </td>
                                <td class="px-5 py-4 text-right whitespace-nowrap">
                                    <a href="{{ route('admin.jobs.show', $job->id) }}"
                                       class="px-2.5 py-1.5 rounded-lg text-xs font-semibold bg-slate-100 hover:bg-slate-200 text-slate-700 transition-colors">
                                        View Details
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($jobs->hasPages())
                <div class="p-4 border-t border-slate-100 bg-slate-50/50">
                    {{ $jobs->links() }}
                </div>
            @endif
        @else
            <div class="py-16 px-6 text-center">
                <div class="w-14 h-14 rounded-2xl bg-slate-100 text-slate-400 mx-auto flex items-center justify-center mb-3">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <rect x="2" y="7" width="20" height="14" rx="2" stroke-width="2"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>
                    </svg>
                </div>
                <h4 class="text-sm font-bold text-slate-900">No Job Postings Yet</h4>
                <p class="text-xs text-slate-500 mt-1 max-w-sm mx-auto">
                    This employer has not published any job opportunities on the platform.
                </p>
            </div>
        @endif
    </div>

</div>
@endsection
