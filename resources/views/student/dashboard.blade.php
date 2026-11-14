@extends('layouts.student')

@section('title', 'Student Dashboard')
@section('header', 'Dashboard')
@section('subheader', 'Your career workspace')

@section('content')
@php
    $studentName = $student->name ?? session('student_name', 'Student');
    $initial = strtoupper(substr($studentName, 0, 1));
@endphp

                <!-- WELCOME -->
                <section class="mb-9">

                    <div class="flex flex-col md:flex-row
                                md:items-center md:justify-between gap-5">

                        <div>

                            <p class="text-sm font-medium text-indigo-600 mb-2">
                                STUDENT WORKSPACE
                            </p>

                            <h1 class="text-2xl md:text-3xl
                                       font-bold text-slate-900">

                                Welcome back, {{ $studentName }}

                            </h1>

                            <p class="text-slate-500 mt-2 text-sm">
                                Manage your applications and discover
                                opportunities for your career.
                            </p>

                        </div>

                        <a href="{{ route('student.jobs') }}"
                           class="inline-flex items-center justify-center
                                  bg-indigo-600 text-white px-5 py-3
                                  rounded-lg text-sm font-semibold
                                  hover:bg-indigo-700 transition">

                            Explore Opportunities

                            <span class="ml-2">→</span>

                        </a>

                    </div>

                </section>


                <!-- APPLICATION STATISTICS -->
                <section class="mb-8">

                    <div class="mb-4 flex items-center justify-between">
                        <h2 class="text-xs font-semibold uppercase tracking-widest text-slate-500">
                            Application Overview
                        </h2>
                        <a href="{{ route('student.applications') }}"
                           class="text-xs font-semibold text-indigo-600 hover:text-indigo-800 transition">
                            View All Applications →
                        </a>
                    </div>

                    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">

                        <!-- TOTAL -->
                        <a href="{{ route('student.applications') }}"
                           class="bg-white border border-slate-200 p-5 rounded-xl transition hover:border-indigo-300 hover:shadow-sm block">
                            <p class="text-xs font-medium text-slate-500 uppercase tracking-wider">Total Applied</p>
                            <div class="mt-2 flex items-baseline justify-between">
                                <span class="text-2xl lg:text-3xl font-bold text-slate-900">{{ $totalApplications }}</span>
                                <span class="text-xs font-semibold text-indigo-600">All</span>
                            </div>
                        </a>

                        <!-- PENDING -->
                        <div class="bg-white border border-slate-200 p-5 rounded-xl">
                            <p class="text-xs font-medium text-amber-700 uppercase tracking-wider flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                                Pending
                            </p>
                            <div class="mt-2 flex items-baseline justify-between">
                                <span class="text-2xl lg:text-3xl font-bold text-slate-900">{{ $pendingApplications }}</span>
                                <span class="text-xs font-medium text-slate-400">In review</span>
                            </div>
                        </div>

                        <!-- SHORTLISTED -->
                        <div class="bg-white border border-slate-200 p-5 rounded-xl">
                            <p class="text-xs font-medium text-blue-700 uppercase tracking-wider flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                                Shortlisted
                            </p>
                            <div class="mt-2 flex items-baseline justify-between">
                                <span class="text-2xl lg:text-3xl font-bold text-slate-900">{{ $shortlistedApplications }}</span>
                                <span class="text-xs font-medium text-slate-400">Screened</span>
                            </div>
                        </div>

                        <!-- SELECTED -->
                        <div class="bg-white border border-slate-200 p-5 rounded-xl">
                            <p class="text-xs font-medium text-emerald-700 uppercase tracking-wider flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                Selected
                            </p>
                            <div class="mt-2 flex items-baseline justify-between">
                                <span class="text-2xl lg:text-3xl font-bold text-slate-900">{{ $selectedApplications }}</span>
                                <span class="text-xs font-semibold text-emerald-600">Offered</span>
                            </div>
                        </div>

                        <!-- REJECTED -->
                        <div class="bg-white border border-slate-200 p-5 rounded-xl">
                            <p class="text-xs font-medium text-red-700 uppercase tracking-wider flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-red-500"></span>
                                Rejected
                            </p>
                            <div class="mt-2 flex items-baseline justify-between">
                                <span class="text-2xl lg:text-3xl font-bold text-slate-900">{{ $rejectedApplications }}</span>
                                <span class="text-xs font-medium text-slate-400">Closed</span>
                            </div>
                        </div>

                    </div>

                </section>


                <!-- ACCOUNT & RESUME CARDS -->
                <section class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-10" id="account-overview">

                    <!-- PROFILE -->
                    <div class="bg-white border border-slate-200 p-6 rounded-xl flex items-start justify-between">
                        <div>
                            <div class="flex items-center gap-2">
                                <a href="#account-overview" class="text-xs font-semibold uppercase tracking-wider text-slate-400 hover:text-indigo-600">Your Account</a>
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[11px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                    Active
                                </span>
                            </div>
                            <h3 class="text-xl font-bold mt-2 text-slate-900">
                                {{ $student->name }}
                            </h3>
                            <p class="text-sm text-slate-500 mt-1">
                                {{ $student->email }}
                            </p>
                            <p class="text-xs text-slate-400 mt-2">
                                Phone: {{ $student->phone }} • Registered {{ $student->created_at ? $student->created_at->format('M Y') : 'N/A' }}
                            </p>
                            <div class="mt-4 pt-3 border-t border-slate-100">
                                <a href="{{ route('student.profile') }}"
                                   class="inline-flex items-center gap-1 text-xs font-semibold text-indigo-600 hover:text-indigo-800 transition">
                                    Edit Profile & Password →
                                </a>
                            </div>
                        </div>

                        <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center font-bold text-lg shrink-0">
                            {{ $initial }}
                        </div>
                    </div>


                    <!-- RESUME -->
                    <div class="bg-white border border-slate-200 p-6 rounded-xl flex items-start justify-between">
                        <div>
                            <span class="text-xs font-semibold uppercase tracking-wider text-slate-400">Career Documents</span>
                            <h3 class="text-xl font-bold mt-2 text-slate-900">
                                Manage Resume
                            </h3>

                            @if($latestApplicationWithResume)
                                <p class="text-xs font-semibold text-emerald-600 mt-1 flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path d="M5 13l4 4L19 7" stroke-width="2" stroke-linecap="round"/>
                                    </svg>
                                    Resume active on applications
                                </p>
                                <div class="mt-3 flex items-center gap-3 text-xs">
                                    <a href="{{ route('applications.resume.download', $latestApplicationWithResume->id) }}"
                                       target="_blank"
                                       class="font-semibold text-indigo-600 hover:underline">
                                        View Latest Resume ↗
                                    </a>
                                    <span class="text-slate-300">|</span>
                                    <a href="{{ route('student.applications') }}"
                                       class="font-semibold text-slate-600 hover:text-indigo-600">
                                        All Applications →
                                    </a>
                                </div>
                            @else
                                <p class="text-xs text-slate-500 mt-1">
                                    Resumes are attached when submitting job applications.
                                </p>
                                <div class="mt-3">
                                    <a href="{{ route('student.jobs') }}"
                                       class="text-xs font-semibold text-indigo-600 hover:underline">
                                        Browse jobs to apply & upload →
                                    </a>
                                </div>
                            @endif
                        </div>

                        <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M7 3h7l5 5v13H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2Z" stroke-width="1.8"/>
                                <path d="M14 3v5h5M9 13h6M9 17h6" stroke-width="1.8"/>
                            </svg>
                        </div>
                    </div>

                </section>


                <!-- RECENT APPLICATIONS SECTION -->
                <section class="mb-10">

                    <div class="flex items-center justify-between mb-5">
                        <div>
                            <h2 class="text-lg font-bold text-slate-900">
                                Recent Applications
                            </h2>
                            <p class="text-sm text-slate-500 mt-0.5">
                                Your latest job submissions and review statuses.
                            </p>
                        </div>
                        @if($totalApplications > 0)
                            <a href="{{ route('student.applications') }}"
                               class="text-sm font-semibold text-indigo-600 hover:text-indigo-800 transition">
                                View All ({{ $totalApplications }}) →
                            </a>
                        @endif
                    </div>

                    @if($recentApplications->count() > 0)
                        <div class="space-y-4">
                            @foreach($recentApplications as $app)
                                <div class="bg-white border border-slate-200 rounded-xl p-5 md:p-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4 transition hover:border-slate-300 hover:shadow-sm">
                                    <div class="flex items-start gap-4 min-w-0">
                                        <div class="w-12 h-12 rounded-lg bg-indigo-50 border border-indigo-100 text-indigo-700 flex items-center justify-center font-bold text-lg shrink-0">
                                            {{ strtoupper(substr($app->job->job_title ?? 'J', 0, 1)) }}
                                        </div>
                                        <div class="min-w-0">
                                            <h3 class="text-base font-bold text-slate-900 truncate">
                                                {{ $app->job->job_title ?? 'Untitled Position' }}
                                            </h3>
                                            <p class="text-sm text-slate-600 font-medium mt-0.5">
                                                {{ $app->job->company->company_name ?? 'Company' }} • <span class="text-slate-400 font-normal">{{ $app->job->location ?? 'Location' }}</span>
                                            </p>
                                            <p class="text-xs text-slate-400 mt-1">
                                                Applied on {{ $app->created_at->format('d M Y') }}
                                            </p>
                                        </div>
                                    </div>

                                    <div class="flex flex-wrap items-center gap-4 shrink-0">
                                        <!-- STATUS BADGE -->
                                        @if($app->status === 'Pending')
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                                Pending Review
                                            </span>
                                        @elseif($app->status === 'Shortlisted')
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-200">
                                                <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                                                Shortlisted
                                            </span>
                                        @elseif($app->status === 'Selected')
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                                Selected
                                            </span>
                                        @elseif($app->status === 'Rejected')
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold bg-red-50 text-red-700 border border-red-200">
                                                <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                                Rejected
                                            </span>
                                        @endif

                                        <!-- ACTIONS -->
                                        <div class="flex items-center gap-3 text-sm">
                                            <a href="{{ route('student.job.details', $app->job_id) }}"
                                               class="font-semibold text-indigo-600 hover:text-indigo-800 transition">
                                                View Job →
                                            </a>
                                            @if($app->resume)
                                                <a href="{{ route('applications.resume.download', $app->id) }}"
                                                   target="_blank"
                                                   class="font-medium text-slate-500 hover:text-indigo-600 transition text-xs">
                                                    Resume ↗
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <!-- GRACEFUL EMPTY STATE -->
                        <div class="bg-white border border-slate-200 rounded-xl p-8 text-center">
                            <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-full flex items-center justify-center mx-auto mb-3">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <rect x="4" y="3" width="16" height="18" rx="2" stroke-width="1.8"/>
                                    <path d="M8 8h8M8 12h8M8 16h5" stroke-width="1.8"/>
                                </svg>
                            </div>
                            <h3 class="text-base font-bold text-slate-900">No applications submitted yet</h3>
                            <p class="text-sm text-slate-500 mt-1 max-w-md mx-auto">
                                You haven't applied for any positions yet. Explore open job listings to kickstart your career.
                            </p>
                            <a href="{{ route('student.jobs') }}"
                               class="inline-flex items-center gap-2 mt-4 bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-indigo-700 transition">
                                Browse Available Jobs →
                            </a>
                        </div>
                    @endif

                </section>


                <!-- QUICK ACTIONS -->
                <section class="mb-10">

                    <div class="mb-5">

                        <h2 class="text-lg font-bold text-slate-900">
                            Manage Your Career
                        </h2>

                        <p class="text-sm text-slate-500 mt-1">
                            Everything you need for your job search.
                        </p>

                    </div>


                    <div class="grid grid-cols-1 md:grid-cols-2
                                xl:grid-cols-3 gap-5">


                        <!-- FIND JOBS -->
                        <div class="bg-white border border-slate-200
                                    rounded-xl p-6">

                            <div class="w-10 h-10 bg-indigo-50
                                        text-indigo-600 rounded-lg
                                        flex items-center justify-center mb-5">

                                <svg class="w-6 h-6" fill="none"
                                     stroke="currentColor" viewBox="0 0 24 24">

                                    <circle cx="11" cy="11" r="7"
                                            stroke-width="1.8"/>

                                    <path d="m16 16 4 4"
                                          stroke-width="1.8"/>

                                </svg>

                            </div>

                            <h3 class="font-bold text-slate-900 text-base">
                                Discover Jobs
                            </h3>

                            <p class="text-sm text-slate-500 leading-6 mt-2 mb-5">

                                Explore available opportunities and
                                find positions that match your skills.

                            </p>

                            <a href="{{ route('student.jobs') }}"
                               class="text-sm font-semibold text-indigo-600
                                      hover:text-indigo-800">

                                Browse Jobs →

                            </a>

                        </div>


                        <!-- RESUME -->
                        <div class="bg-white border border-slate-200
                                    rounded-xl p-6">

                            <div class="w-10 h-10 bg-emerald-50
                                        text-emerald-600 rounded-lg
                                        flex items-center justify-center mb-5">

                                <svg class="w-6 h-6" fill="none"
                                     stroke="currentColor" viewBox="0 0 24 24">

                                    <path d="M7 3h7l5 5v13H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2Z"
                                          stroke-width="1.8"/>

                                    <path d="M14 3v5h5M9 13h6M9 17h6"
                                          stroke-width="1.8"/>

                                </svg>

                            </div>

                            <h3 class="font-bold text-slate-900 text-base">
                                Resume Management
                            </h3>

                            <p class="text-sm text-slate-500 leading-6 mt-2 mb-5">

                                Keep your professional documents ready
                                for your future job applications.

                            </p>

                            <a href="{{ route('student.applications') }}"
                               class="text-sm font-semibold text-emerald-600 hover:text-emerald-800 transition">
                                Manage Resumes →
                            </a>

                        </div>


                        <!-- APPLICATIONS -->
                        <div class="bg-white border border-slate-200
                                    rounded-xl p-6">

                            <div class="w-10 h-10 bg-amber-50
                                        text-amber-600 rounded-lg
                                        flex items-center justify-center mb-5">

                                <svg class="w-6 h-6" fill="none"
                                     stroke="currentColor" viewBox="0 0 24 24">

                                    <rect x="4" y="3" width="16" height="18"
                                          rx="2" stroke-width="1.8"/>

                                    <path d="M8 8h8M8 12h8M8 16h5"
                                          stroke-width="1.8"/>

                                </svg>

                            </div>

                            <h3 class="font-bold text-slate-900 text-base">
                                Application Tracking
                            </h3>

                            <p class="text-sm text-slate-500 leading-6 mt-2 mb-5">

                                Review your submitted applications and
                                track their progress.

                            </p>

                            <a href="{{ route('student.applications') }}"
                               class="text-sm font-semibold text-indigo-600
                                      hover:text-indigo-800">

                                View Applications →

                            </a>

                        </div>

                    </div>

                </section>


                <!-- BOTTOM CTA -->
                <section class="bg-white border border-slate-200
                                rounded-xl p-6 md:p-8">

                    <div class="flex flex-col md:flex-row
                                md:items-center md:justify-between gap-5">

                        <div>

                            <h2 class="text-lg font-bold text-slate-900">

                                Ready for your next opportunity?

                            </h2>

                            <p class="text-sm text-slate-500 mt-2">

                                Explore new jobs and take the next step
                                towards your professional career.

                            </p>

                        </div>

                        <a href="{{ route('student.jobs') }}"
                           class="inline-flex items-center justify-center
                                  bg-slate-900 text-white px-5 py-3
                                  rounded-lg text-sm font-semibold
                                  hover:bg-slate-800 transition">

                            Find Opportunities →

                        </a>

                    </div>

                </section>


@endsection