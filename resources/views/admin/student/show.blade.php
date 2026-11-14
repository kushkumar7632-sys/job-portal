@extends('layouts.admin')

@section('title', 'Student Details - ' . $student->name)
@section('header', 'Student Details')

@section('content')
<div class="space-y-6">

    <!-- Top Navigation / Action Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <a href="{{ route('admin.students') }}"
           class="inline-flex items-center gap-2 text-xs font-semibold text-slate-600 hover:text-indigo-600 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            <span>Back to Student Management</span>
        </a>

        <div class="flex items-center gap-2">
            <form action="{{ route('admin.students.delete', $student->id) }}"
                  method="POST"
                  onsubmit="return confirm('Are you sure you want to delete {{ addslashes($student->name) }}? If this candidate has active job applications, deletion will be blocked.');">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="px-3 py-1.5 rounded-lg text-xs font-semibold bg-rose-50 text-rose-700 border border-rose-200 hover:bg-rose-100 transition-colors">
                    Delete Candidate
                </button>
            </form>
        </div>
    </div>

    <!-- Candidate Profile Card -->
    <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-xs">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pb-6 border-b border-slate-100">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold text-xl border border-indigo-100 shrink-0">
                    {{ strtoupper(substr($student->name, 0, 1)) }}
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <h2 class="text-xl font-bold text-slate-900">
                            {{ $student->name }}
                        </h2>
                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[11px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                            Active Account
                        </span>
                    </div>
                    <p class="text-xs text-slate-500 mt-1">
                        Candidate ID: <span class="font-medium text-slate-800">#{{ $student->id }}</span>
                    </p>
                </div>
            </div>

            <!-- Quick Metrics Counter -->
            <div class="flex items-center gap-4">
                <div class="text-right">
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Applications</p>
                    <p class="text-xl font-extrabold text-indigo-600 mt-0.5">{{ number_format($student->applications_count) }}</p>
                </div>
            </div>
        </div>

        <!-- Detailed Profile Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 pt-6 text-xs sm:text-sm">
            <div>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Email Address</p>
                <p class="font-semibold text-slate-900 mt-1 break-all">{{ $student->email }}</p>
            </div>
            <div>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Phone Number</p>
                <p class="font-semibold text-slate-900 mt-1">{{ $student->phone ?? 'Not provided' }}</p>
            </div>
            <div>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Registration Date</p>
                <p class="font-semibold text-slate-900 mt-1">
                    {{ $student->created_at ? $student->created_at->format('M d, Y, h:i A') : 'N/A' }}
                </p>
            </div>
        </div>
    </div>

    <!-- Application History Section -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h3 class="text-sm sm:text-base font-bold text-slate-900">
                    Application History
                </h3>
                <p class="text-xs text-slate-500 mt-0.5">
                    Showing all jobs applied to by {{ $student->name }} ({{ $applications->total() }} total)
                </p>
            </div>
        </div>

        @if($applications->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs sm:text-sm">
                    <thead>
                        <tr class="bg-slate-50/75 border-b border-slate-100 text-[11px] font-semibold text-slate-500 uppercase tracking-wider">
                            <th class="px-5 py-3.5">Job Title</th>
                            <th class="px-5 py-3.5">Company</th>
                            <th class="px-5 py-3.5">Application Status</th>
                            <th class="px-5 py-3.5">Applied Date</th>
                            <th class="px-5 py-3.5 text-right">Resume</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($applications as $application)
                            <tr class="hover:bg-slate-50/60 transition-colors">
                                <!-- Job Title -->
                                <td class="px-5 py-4 font-bold text-slate-900">
                                    {{ $application->job->job_title ?? 'Job Unavailable' }}
                                </td>

                                <!-- Company Name -->
                                <td class="px-5 py-4 text-slate-700 whitespace-nowrap">
                                    {{ $application->job->company->company_name ?? 'N/A' }}
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
                                    {{ $application->created_at ? $application->created_at->format('M d, Y') : 'N/A' }}
                                </td>

                                <!-- Resume Link -->
                                <td class="px-5 py-4 text-right whitespace-nowrap">
                                    @if($application->resume)
                                        <a href="{{ route('applications.resume.download', $application->id) }}"
                                           target="_blank"
                                           class="inline-flex items-center gap-1.5 px-2.5 py-1.5 rounded-lg text-xs font-semibold bg-indigo-50 hover:bg-indigo-100 text-indigo-700 border border-indigo-200 transition-colors">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                            <span>View Resume</span>
                                        </a>
                                    @else
                                        <span class="text-xs text-slate-400">No Resume</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination Bar -->
            @if($applications->hasPages())
                <div class="p-4 border-t border-slate-100 bg-slate-50/50">
                    {{ $applications->links() }}
                </div>
            @endif
        @else
            <!-- Empty State -->
            <div class="py-16 px-6 text-center">
                <div class="w-14 h-14 rounded-2xl bg-slate-100 text-slate-400 mx-auto flex items-center justify-center mb-3">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h7l5 5v11a2 2 0 01-2 2zM14 3v5h5"/>
                    </svg>
                </div>
                <h4 class="text-sm font-bold text-slate-900">No Applications Submitted Yet</h4>
                <p class="text-xs text-slate-500 mt-1 max-w-sm mx-auto">
                    This candidate has not applied to any job postings on JobPortal.
                </p>
            </div>
        @endif
    </div>

</div>
@endsection
