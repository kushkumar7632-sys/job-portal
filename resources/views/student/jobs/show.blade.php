@extends('layouts.student')

@section('title', $job->job_title)
@section('header', 'Job Details')
@section('subheader', 'Explore role details and submit your application')

@section('content')
@php
    $isDeadlinePassed = \Carbon\Carbon::parse($job->deadline)->isPast() && !\Carbon\Carbon::parse($job->deadline)->isToday();
@endphp

            <!-- BREADCRUMB -->
            <nav class="mb-6 flex flex-wrap items-center gap-2 text-xs font-medium text-slate-400">
                <a href="{{ route('student.dashboard') }}" class="hover:text-[#5140ef]">
                    Dashboard
                </a>
                <span>/</span>
                <a href="{{ route('student.jobs') }}" class="hover:text-[#5140ef]">
                    Find Jobs
                </a>
                <span>/</span>
                <span class="text-slate-700">
                    {{ $job->job_title }}
                </span>
            </nav>

            <!-- BACK TO JOBS BUTTON -->
            <div class="mb-6">
                <a href="{{ route('student.jobs') }}"
                   class="inline-flex items-center gap-2 text-sm font-medium text-slate-500 transition hover:text-[#5140ef]">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M19 12H5M12 19l-7-7 7-7"/>
                    </svg>
                    Back to All Jobs
                </a>
            </div>

            <!-- JOB HERO BANNER CARD -->
            <section class="mb-8 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
                <div class="flex flex-col justify-between gap-6 md:flex-row md:items-center">

                    <div class="flex items-start gap-5">
                        <div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-2xl bg-indigo-50 text-2xl font-bold text-[#5140ef]">
                            {{ strtoupper(substr($job->job_title, 0, 1)) }}
                        </div>

                        <div>
                            <div class="flex flex-wrap items-center gap-3">
                                <h1 class="text-2xl font-bold tracking-tight text-[#172b40] sm:text-3xl">
                                    {{ $job->job_title }}
                                </h1>
                                <span class="rounded-md border border-[#dce4f3] bg-[#f3f6fc] px-3 py-1 text-xs font-semibold text-[#45648a]">
                                    {{ $job->job_type }}
                                </span>
                            </div>

                            <p class="mt-2 text-base font-semibold text-slate-700">
                                {{ $job->company->company_name ?? 'Company' }}
                            </p>

                            <div class="mt-3 flex flex-wrap items-center gap-4 text-xs font-medium text-slate-500">
                                <span class="inline-flex items-center gap-1.5">
                                    <svg class="h-4 w-4 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                        <path d="M20 10c0 5-8 11-8 11S4 15 4 10a8 8 0 1 1 16 0Z"/>
                                        <circle cx="12" cy="10" r="2.5"/>
                                    </svg>
                                    {{ $job->location }}
                                </span>

                                <span class="inline-flex items-center gap-1.5">
                                    <svg class="h-4 w-4 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                        <rect x="2" y="7" width="20" height="14" rx="2" ry="2"/>
                                        <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>
                                    </svg>
                                    {{ $job->experience }}
                                </span>

                                <span class="inline-flex items-center gap-1.5">
                                    <svg class="h-4 w-4 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                        <circle cx="12" cy="12" r="10"/>
                                        <path d="M12 6v6l4 2"/>
                                    </svg>
                                    Posted {{ $job->created_at->diffForHumans() }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- TOP APPLY ACTION -->
                    <div class="flex shrink-0 items-center">
                        @if($alreadyApplied)
                            <div class="flex flex-col gap-2 sm:items-end">
                                <span class="inline-flex items-center gap-2 rounded-lg border border-emerald-200 bg-emerald-50 px-5 py-2.5 text-sm font-semibold text-emerald-700">
                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="m5 12 4 4L19 6"/>
                                    </svg>
                                    Application Submitted
                                </span>

                                @if(!$application->resume)
                                    <a href="{{ route('student.resume.upload', $job->id) }}"
                                       class="inline-flex items-center gap-1 text-xs font-semibold text-amber-600 hover:underline">
                                        ⚠️ Upload your resume to complete application →
                                    </a>
                                @else
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('applications.resume.download', $application->id) }}"
                                           target="_blank"
                                           class="text-xs font-semibold text-indigo-600 hover:underline">
                                            View Resume ↗
                                        </a>
                                        <span class="text-slate-300">|</span>
                                        <a href="{{ route('student.applications') }}"
                                           class="text-xs font-semibold text-slate-500 hover:underline">
                                            My Applications →
                                        </a>
                                    </div>
                                @endif
                            </div>
                        @elseif($isDeadlinePassed)
                            <span class="inline-flex items-center gap-2 rounded-lg border border-red-200 bg-red-50 px-5 py-2.5 text-sm font-semibold text-red-700">
                                Applications Closed
                            </span>
                        @else
                            <form action="{{ route('student.job.apply', $job->id) }}" method="POST">
                                @csrf
                                <button type="submit"
                                        class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#5140ef] px-7 py-3.5 text-sm font-semibold text-white shadow-md shadow-indigo-950/20 transition hover:bg-[#4030d0]">
                                    Apply Now
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                    </svg>
                                </button>
                            </form>
                        @endif
                    </div>

                </div>
            </section>

            <!-- MAIN 2-COLUMN CONTENT GRID -->
            <div class="grid grid-cols-1 gap-8 xl:grid-cols-3">

                <!-- LEFT COLUMN: JOB DESCRIPTION & COMPANY INFO -->
                <div class="space-y-8 xl:col-span-2">

                    <!-- JOB DESCRIPTION -->
                    <section class="rounded-2xl border border-slate-200 bg-white p-6 sm:p-8 shadow-sm">
                        <h2 class="text-xl font-bold text-[#172b40]">
                            Job Description
                        </h2>
                        <div class="my-5 border-t border-slate-100"></div>

                        <div class="prose max-w-none text-sm leading-7 text-slate-600 whitespace-pre-line">
                            {{ $job->description }}
                        </div>
                    </section>

                    <!-- ABOUT THE COMPANY -->
                    <section class="rounded-2xl border border-slate-200 bg-white p-6 sm:p-8 shadow-sm">
                        <h2 class="text-xl font-bold text-[#172b40]">
                            About {{ $job->company->company_name ?? 'the Employer' }}
                        </h2>
                        <div class="my-5 border-t border-slate-100"></div>

                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 text-sm">
                            <div>
                                <p class="text-xs text-slate-400">Industry</p>
                                <p class="mt-1 font-semibold text-slate-800">
                                    {{ $job->company->industry ?? 'Not specified' }}
                                </p>
                            </div>

                            @if(!empty($job->company->website))
                                <div>
                                    <p class="text-xs text-slate-400">Website</p>
                                    <p class="mt-1">
                                        <a href="{{ $job->company->website }}" target="_blank" rel="noopener noreferrer"
                                           class="font-semibold text-indigo-600 hover:underline">
                                            {{ $job->company->website }} ↗
                                        </a>
                                    </p>
                                </div>
                            @endif

                            @if(!empty($job->company->address))
                                <div class="sm:col-span-2">
                                    <p class="text-xs text-slate-400">Office Location / Address</p>
                                    <p class="mt-1 font-semibold text-slate-800">
                                        {{ $job->company->address }}
                                    </p>
                                </div>
                            @endif
                        </div>
                    </section>

                </div>

                <!-- RIGHT COLUMN: JOB OVERVIEW & APPLY CARD -->
                <div class="space-y-6">

                    <!-- JOB OVERVIEW CARD -->
                    <div class="rounded-2xl border border-slate-200 bg-white p-6 sm:p-7 shadow-sm">
                        <h3 class="text-lg font-bold text-[#172b40]">
                            Job Overview
                        </h3>
                        <div class="my-5 border-t border-slate-100"></div>

                        <div class="space-y-5">

                            <!-- Salary -->
                            <div class="flex items-start gap-4">
                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-emerald-50 text-emerald-600">
                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                        <path d="M12 3v18M17 7.5c0-1.7-1.9-3-5-3s-5 1.3-5 3 1.5 2.5 5 3 5 1.3 5 3-1.9 3-5 3-5-1.3-5-3"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-slate-400">Offered Salary</p>
                                    <p class="mt-0.5 text-base font-bold text-slate-800">
                                        {{ $job->salary }}
                                    </p>
                                </div>
                            </div>

                            <!-- Experience -->
                            <div class="flex items-start gap-4">
                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-blue-50 text-blue-600">
                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                        <circle cx="12" cy="12" r="9"/>
                                        <path d="M12 7v5l3 2"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-slate-400">Experience</p>
                                    <p class="mt-0.5 text-sm font-semibold text-slate-800">
                                        {{ $job->experience }}
                                    </p>
                                </div>
                            </div>

                            <!-- Vacancy -->
                            <div class="flex items-start gap-4">
                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-purple-50 text-purple-600">
                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                        <circle cx="9" cy="8" r="3"/>
                                        <path d="M3 20v-1a6 6 0 0 1 12 0v1M16 5a3 3 0 0 1 0 6M18 14a5 5 0 0 1 3 5v1"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-slate-400">Total Openings</p>
                                    <p class="mt-0.5 text-sm font-semibold text-slate-800">
                                        {{ $job->vacancy }} Openings
                                    </p>
                                </div>
                            </div>

                            <!-- Job Type -->
                            <div class="flex items-start gap-4">
                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-indigo-50 text-indigo-600">
                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                        <rect x="2" y="7" width="20" height="14" rx="2" ry="2"/>
                                        <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-slate-400">Job Type</p>
                                    <p class="mt-0.5 text-sm font-semibold text-slate-800">
                                        {{ $job->job_type }}
                                    </p>
                                </div>
                            </div>

                            <!-- Location -->
                            <div class="flex items-start gap-4">
                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-amber-50 text-amber-600">
                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                        <path d="M20 10c0 5-8 11-8 11S4 15 4 10a8 8 0 1 1 16 0Z"/>
                                        <circle cx="12" cy="10" r="2.5"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-slate-400">Job Location</p>
                                    <p class="mt-0.5 text-sm font-semibold text-slate-800">
                                        {{ $job->location }}
                                    </p>
                                </div>
                            </div>

                            <!-- Deadline -->
                            <div class="flex items-start gap-4">
                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-rose-50 text-rose-600">
                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                                        <line x1="16" y1="2" x2="16" y2="6"/>
                                        <line x1="8" y1="2" x2="8" y2="6"/>
                                        <line x1="3" y1="10" x2="21" y2="10"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-slate-400">Application Deadline</p>
                                    <p class="mt-0.5 text-sm font-semibold {{ $isDeadlinePassed ? 'text-red-600 font-bold' : 'text-slate-800' }}">
                                        {{ \Carbon\Carbon::parse($job->deadline)->format('d M, Y') }}
                                        @if($isDeadlinePassed)
                                            <span class="text-xs text-red-500">(Expired)</span>
                                        @endif
                                    </p>
                                </div>
                            </div>

                        </div>

                        <!-- SIDEBAR APPLICATION ACTION -->
                        <div class="mt-8 border-t border-slate-100 pt-6">
                            @if($alreadyApplied)
                                <div class="rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-center">
                                    <p class="text-sm font-semibold text-emerald-800">
                                        ✓ Application Submitted
                                    </p>
                                    <p class="mt-1 text-xs text-emerald-600">
                                        Status: <span class="font-bold">{{ $application->status }}</span>
                                    </p>
                                    @if(!$application->resume)
                                        <a href="{{ route('student.resume.upload', $job->id) }}"
                                           class="mt-3 inline-block rounded-lg bg-amber-600 px-4 py-2 text-xs font-semibold text-white hover:bg-amber-700">
                                            Upload Resume Now
                                        </a>
                                    @else
                                        <div class="mt-3 flex items-center justify-center gap-2">
                                            <a href="{{ route('applications.resume.download', $application->id) }}"
                                               target="_blank"
                                               class="text-xs font-semibold text-indigo-600 hover:underline">
                                                View Resume ↗
                                            </a>
                                            <span class="text-slate-300">|</span>
                                            <a href="{{ route('student.applications') }}"
                                               class="text-xs font-semibold text-slate-500 hover:underline">
                                                My Applications →
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            @elseif($isDeadlinePassed)
                                <div class="rounded-xl border border-red-200 bg-red-50 p-4 text-center">
                                    <p class="text-sm font-semibold text-red-700">
                                        Deadline Expired
                                    </p>
                                    <p class="mt-1 text-xs text-red-600">
                                        This job opening is no longer accepting applications.
                                    </p>
                                </div>
                            @else
                                <form action="{{ route('student.job.apply', $job->id) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                            class="w-full flex items-center justify-center gap-2 rounded-xl bg-[#5140ef] py-3.5 px-6 text-sm font-semibold text-white shadow-md shadow-indigo-950/20 transition hover:bg-[#4030d0]">
                                        Apply for this Position
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                        </svg>
                                    </button>
                                </form>
                                <p class="mt-3 text-center text-xs text-slate-400">
                                    Applying will register your application and prompt you to submit your resume.
                                </p>
                            @endif
                        </div>

                    </div>

                </div>

            </div>

@endsection
