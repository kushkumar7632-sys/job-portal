@extends('layouts.admin')

@section('title', 'Student Management')
@section('header', 'Student Management')

@section('content')
<div class="space-y-6">

    @php
        $totalStudents = \App\Models\Student::count();
        $activeApplicantsCount = \App\Models\Student::has('applications')->count();
        $totalApplicationsSubmitted = \App\Models\Application::count();
    @endphp

    <!-- Statistics Overview Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
        <!-- Total Students -->
        <a href="{{ route('admin.students') }}"
           class="bg-white rounded-2xl border border-slate-200 p-5 shadow-xs hover:border-indigo-300 transition-colors flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Total Students</p>
                <p class="text-2xl font-extrabold text-slate-900 mt-1">{{ number_format($totalStudents) }}</p>
                <p class="text-xs text-slate-400 mt-0.5">Registered candidate accounts</p>
            </div>
            <div class="w-11 h-11 rounded-xl bg-slate-100 text-slate-600 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                    <circle cx="9" cy="7" r="4" stroke-width="2"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M22 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/>
                </svg>
            </div>
        </a>

        <!-- Active Applicants -->
        <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Active Applicants</p>
                <p class="text-2xl font-extrabold text-indigo-600 mt-1">{{ number_format($activeApplicantsCount) }}</p>
                <p class="text-xs text-slate-400 mt-0.5">Candidates with job submissions</p>
            </div>
            <div class="w-11 h-11 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>

        <!-- Total Applications Submitted -->
        <a href="{{ route('admin.applications') }}"
           class="bg-white rounded-2xl border border-slate-200 p-5 shadow-xs hover:border-amber-300 transition-colors flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Total Applications</p>
                <p class="text-2xl font-extrabold text-amber-600 mt-1">{{ number_format($totalApplicationsSubmitted) }}</p>
                <p class="text-xs text-slate-400 mt-0.5">Submissions across all jobs</p>
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
        <form method="GET" action="{{ route('admin.students') }}" class="flex flex-col md:flex-row gap-3">
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
                       placeholder="Search by student name, email, or phone..."
                       class="w-full pl-10 pr-4 py-2 text-xs sm:text-sm rounded-xl border border-slate-200 focus:outline-hidden focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-slate-50/50">
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center gap-2">
                <button type="submit"
                        class="px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold bg-indigo-600 hover:bg-indigo-700 text-white shadow-xs transition-colors shrink-0">
                    Search Students
                </button>

                @if(request()->filled('search'))
                    <a href="{{ route('admin.students') }}"
                       class="px-3 py-2 rounded-xl text-xs sm:text-sm font-semibold text-slate-600 hover:text-slate-900 bg-slate-100 hover:bg-slate-200 transition-colors shrink-0">
                        Clear
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Students Table Container -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h3 class="text-sm sm:text-base font-bold text-slate-900">
                    Registered Students
                </h3>
                <p class="text-xs text-slate-500 mt-0.5">
                    Showing {{ $students->firstItem() ?? 0 }} to {{ $students->lastItem() ?? 0 }} of {{ $students->total() }} candidates
                </p>
            </div>
        </div>

        @if($students->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs sm:text-sm">
                    <thead>
                        <tr class="bg-slate-50/75 border-b border-slate-100 text-[11px] font-semibold text-slate-500 uppercase tracking-wider">
                            <th class="px-5 py-3.5">Candidate</th>
                            <th class="px-5 py-3.5">Email</th>
                            <th class="px-5 py-3.5">Phone</th>
                            <th class="px-5 py-3.5">Applications</th>
                            <th class="px-5 py-3.5">Registered</th>
                            <th class="px-5 py-3.5 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($students as $student)
                            <tr class="hover:bg-slate-50/60 transition-colors">
                                <!-- Student Name + Avatar -->
                                <td class="px-5 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold text-xs shrink-0 border border-indigo-100">
                                            {{ strtoupper(substr($student->name, 0, 1)) }}
                                        </div>
                                        <div class="min-w-0">
                                            <a href="{{ route('admin.students.show', $student->id) }}"
                                               class="font-bold text-slate-900 hover:text-indigo-600 truncate block">
                                                {{ $student->name }}
                                            </a>
                                            <span class="text-[11px] text-slate-400 block truncate">
                                                ID: #{{ $student->id }}
                                            </span>
                                        </div>
                                    </div>
                                </td>

                                <!-- Email -->
                                <td class="px-5 py-4 text-slate-600 whitespace-nowrap">
                                    {{ $student->email }}
                                </td>

                                <!-- Phone -->
                                <td class="px-5 py-4 text-slate-600 whitespace-nowrap">
                                    {{ $student->phone ?? 'Not provided' }}
                                </td>

                                <!-- Applications Count Badge -->
                                <td class="px-5 py-4 whitespace-nowrap">
                                    @if(($student->applications_count ?? 0) > 0)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-700 border border-indigo-200">
                                            {{ $student->applications_count }} Applications
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-500">
                                            0 Applications
                                        </span>
                                    @endif
                                </td>

                                <!-- Registered Date -->
                                <td class="px-5 py-4 text-xs text-slate-500 whitespace-nowrap">
                                    {{ $student->created_at ? $student->created_at->format('M d, Y') : 'N/A' }}
                                </td>

                                <!-- Actions -->
                                <td class="px-5 py-4 text-right whitespace-nowrap">
                                    <div class="inline-flex items-center gap-1.5">
                                        <!-- View Details -->
                                        <a href="{{ route('admin.students.show', $student->id) }}"
                                           class="px-2.5 py-1.5 rounded-lg text-xs font-semibold bg-slate-100 hover:bg-slate-200 text-slate-700 transition-colors">
                                            View
                                        </a>

                                        <!-- Delete Form -->
                                        <form action="{{ route('admin.students.delete', $student->id) }}"
                                              method="POST"
                                              onsubmit="return confirm('Are you sure you want to delete {{ addslashes($student->name) }}? If this candidate has active job applications, deletion will be blocked.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="px-2.5 py-1.5 rounded-lg text-xs font-semibold bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200 transition-colors">
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

            <!-- Pagination Bar -->
            @if($students->hasPages())
                <div class="p-4 border-t border-slate-100 bg-slate-50/50">
                    {{ $students->links() }}
                </div>
            @endif
        @else
            <!-- Empty State -->
            <div class="py-16 px-6 text-center">
                <div class="w-14 h-14 rounded-2xl bg-slate-100 text-slate-400 mx-auto flex items-center justify-center mb-3">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                        <circle cx="9" cy="7" r="4" stroke-width="2"/>
                    </svg>
                </div>
                @if(request()->filled('search'))
                    <h4 class="text-sm font-bold text-slate-900">No matching students found</h4>
                    <p class="text-xs text-slate-500 mt-1 max-w-sm mx-auto">
                        No candidate accounts matched "{{ request('search') }}". Try adjusting your search query.
                    </p>
                    <div class="mt-4">
                        <a href="{{ route('admin.students') }}"
                           class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-semibold bg-indigo-600 text-white hover:bg-indigo-700 transition-colors shadow-xs">
                            Clear Search
                        </a>
                    </div>
                @else
                    <h4 class="text-sm font-bold text-slate-900">No students registered yet</h4>
                    <p class="text-xs text-slate-500 mt-1 max-w-sm mx-auto">
                        When candidates register on JobPortal, their accounts and application history will appear here.
                    </p>
                @endif
            </div>
        @endif
    </div>

</div>
@endsection
