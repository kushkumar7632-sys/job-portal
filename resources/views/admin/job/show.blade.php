@extends('layouts.admin')

@section('title', 'Job Details - ' . $job->job_title)
@section('header', 'Job Details')

@section('content')
<div class="space-y-6">

    <!-- Top Navigation / Action Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <a href="{{ route('admin.jobs') }}"
           class="inline-flex items-center gap-2 text-xs font-semibold text-slate-600 hover:text-indigo-600 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            <span>Back to Job Management</span>
        </a>

        <div class="flex items-center gap-2">
            <form action="{{ route('admin.jobs.delete', $job->id) }}"
                  method="POST"
                  onsubmit="return confirm('Are you sure you want to delete this job posting? If this job has any candidate applications, deletion will be blocked.');">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="px-3 py-1.5 rounded-lg text-xs font-semibold bg-rose-50 text-rose-700 border border-rose-200 hover:bg-rose-100 transition-colors">
                    Delete Job Posting
                </button>
            </form>
        </div>
    </div>

    <!-- Job Header / Overview Card -->
    <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-xs">
        @php
            $isPastDeadline = \Carbon\Carbon::parse($job->deadline)->lt(now()->startOfDay());
        @endphp

        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pb-6 border-b border-slate-100">
            <div class="flex items-start gap-4">
                <div class="w-14 h-14 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0 border border-indigo-100">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <rect x="2" y="7" width="20" height="14" rx="2" ry="2" stroke-width="2"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>
                    </svg>
                </div>
                <div>
                    <div class="flex flex-wrap items-center gap-2">
                        <h2 class="text-xl font-bold text-slate-900">
                            {{ $job->job_title }}
                        </h2>

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

                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[11px] font-medium bg-slate-100 text-slate-700">
                            {{ $job->job_type }}
                        </span>
                    </div>

                    <p class="text-xs text-slate-500 mt-1">
                        Job ID: <span class="font-medium text-slate-800">#{{ $job->id }}</span> &bull; Posted {{ $job->created_at ? $job->created_at->format('M d, Y, h:i A') : 'N/A' }}
                    </p>
                </div>
            </div>

            <!-- Quick Metrics Counter -->
            <div class="flex items-center gap-6">
                <div class="text-right">
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Applications</p>
                    <p class="text-xl font-extrabold text-indigo-600 mt-0.5">{{ number_format($job->applications_count) }}</p>
                </div>
                <div class="h-8 w-px bg-slate-200 hidden sm:block"></div>
                <div class="text-right">
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Vacancies</p>
                    <p class="text-xl font-extrabold text-slate-900 mt-0.5">{{ $job->vacancy ?? 'N/A' }}</p>
                </div>
            </div>
        </div>

        <!-- Job Key Details Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 pt-6 text-xs sm:text-sm">
            <div>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Location</p>
                <p class="font-semibold text-slate-900 mt-1">{{ $job->location }}</p>
            </div>
            <div>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Salary Offering</p>
                <p class="font-semibold text-slate-900 mt-1">{{ $job->salary ?? 'Not specified' }}</p>
            </div>
            <div>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Experience Level</p>
                <p class="font-semibold text-slate-900 mt-1">{{ $job->experience ?? 'Not specified' }}</p>
            </div>
            <div>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Application Deadline</p>
                <p class="font-semibold {{ $isPastDeadline ? 'text-rose-600' : 'text-slate-900' }} mt-1">
                    {{ \Carbon\Carbon::parse($job->deadline)->format('M d, Y') }}
                    @if($isPastDeadline)
                        <span class="text-xs font-normal text-rose-500">(Passed)</span>
                    @endif
                </p>
            </div>
        </div>
    </div>

    <!-- Company Information Card -->
    <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-xs">
        <div class="flex items-center justify-between pb-4 border-b border-slate-100">
            <h3 class="text-sm sm:text-base font-bold text-slate-900">
                Employer Details
            </h3>
            @if($job->company)
                <a href="{{ route('admin.companies.show', $job->company->id) }}"
                   class="inline-flex items-center gap-1.5 text-xs font-semibold text-indigo-600 hover:text-indigo-700 transition-colors">
                    <span>View Company Profile</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                </a>
            @endif
        </div>

        @if($job->company)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 pt-5 text-xs sm:text-sm">
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Company Name</p>
                    <p class="font-bold text-slate-900 mt-1">{{ $job->company->company_name }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Primary Contact</p>
                    <p class="font-semibold text-slate-900 mt-1">{{ $job->company->owner_name ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Email Address</p>
                    <p class="font-semibold text-slate-900 mt-1 break-all">{{ $job->company->email }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Industry</p>
                    <p class="font-semibold text-slate-900 mt-1">{{ $job->company->industry ?? 'Not specified' }}</p>
                </div>
            </div>
        @else
            <p class="text-xs text-slate-400 italic pt-4">No associated company profile found for this job posting.</p>
        @endif
    </div>

    <!-- Job Description Card -->
    <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-xs">
        <h3 class="text-sm sm:text-base font-bold text-slate-900 pb-3 border-b border-slate-100">
            Job Description & Requirements
        </h3>
        <div class="pt-4 text-xs sm:text-sm text-slate-700 leading-relaxed whitespace-pre-line">
            {{ $job->description }}
        </div>
    </div>

    <!-- Candidate Applications Section -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h3 class="text-sm sm:text-base font-bold text-slate-900">
                    Candidate Applications
                </h3>
                <p class="text-xs text-slate-500 mt-0.5">
                    Showing candidates who applied specifically for this job posting ({{ $applications->total() }} total)
                </p>
            </div>
        </div>

        @if($applications->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs sm:text-sm">
                    <thead>
                        <tr class="bg-slate-50/75 border-b border-slate-100 text-[11px] font-semibold text-slate-500 uppercase tracking-wider">
                            <th class="px-5 py-3.5">Candidate</th>
                            <th class="px-5 py-3.5">Email</th>
                            <th class="px-5 py-3.5">Phone</th>
                            <th class="px-5 py-3.5">Status</th>
                            <th class="px-5 py-3.5">Applied Date</th>
                            <th class="px-5 py-3.5 text-right">Resume</th>
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
                                                   class="font-bold text-slate-900 hover:text-indigo-600 truncate block">
                                                    {{ $application->student->name }}
                                                </a>
                                                <span class="text-[11px] text-slate-400 block truncate">
                                                    ID: #{{ $application->student->id }}
                                                </span>
                                            </div>
                                        </div>
                                    @else
                                        <span class="text-slate-400 italic">Candidate Unavailable</span>
                                    @endif
                                </td>

                                <!-- Email -->
                                <td class="px-5 py-4 text-slate-600 whitespace-nowrap">
                                    {{ $application->student->email ?? 'N/A' }}
                                </td>

                                <!-- Phone -->
                                <td class="px-5 py-4 text-slate-600 whitespace-nowrap">
                                    {{ $application->student->phone ?? 'Not provided' }}
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
                                <td class="px-5 py-4 text-slate-600 whitespace-nowrap">
                                    {{ $application->created_at ? $application->created_at->format('M d, Y, h:i A') : 'N/A' }}
                                </td>

                                <!-- Resume Download -->
                                <td class="px-5 py-4 whitespace-nowrap text-right">
                                    @if($application->resume)
                                        <a href="{{ route('applications.resume.download', $application->id) }}"
                                           target="_blank"
                                           class="inline-flex items-center gap-1.5 px-2.5 py-1.5 rounded-lg text-xs font-semibold bg-indigo-50 text-indigo-700 hover:bg-indigo-100 border border-indigo-200 transition-colors">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                            <span>Download</span>
                                        </a>
                                    @else
                                        <span class="text-xs text-slate-400 italic">No Resume</span>
                                    @endif
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <h4 class="text-sm font-bold text-slate-800">No Candidate Applications Yet</h4>
                <p class="text-xs text-slate-500 mt-1 max-w-sm mx-auto">
                    No candidates have submitted applications for this job posting yet.
                </p>
            </div>
        @endif
    </div>

</div>
@endsection
