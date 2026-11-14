@extends('layouts.student')

@section('title', 'My Applications')
@section('header', 'My Applications')
@section('subheader', 'Review the positions you have applied for and track application status')

@section('content')

        <!-- PAGE HEADING -->
        <section class="mb-8 flex flex-col justify-between gap-5 border-b border-slate-200 pb-8 md:flex-row md:items-end">

            <div>

                <nav class="mb-4 flex items-center gap-2 text-xs font-medium text-slate-400">

                    <a href="{{ route('student.dashboard') }}" class="hover:text-[#24496b]">
                        Dashboard
                    </a>

                    <span>/</span>

                    <span class="text-slate-600">
                        My Applications
                    </span>

                </nav>


                <p class="text-xs font-semibold uppercase tracking-[0.15em] text-[#607b95]">
                    YOUR JOB SEARCH
                </p>


                <h1 class="mt-2 text-3xl font-semibold tracking-tight text-[#172b40] lg:text-4xl">
                    My Applications
                </h1>


                <p class="mt-3 text-sm leading-6 text-slate-500">
                    Review the positions you have applied for and follow the latest status of each application.
                </p>

            </div>


            <a href="{{ route('student.jobs') }}"
               class="inline-flex h-11 items-center justify-center gap-3 self-start rounded-md bg-[#24496b] px-5 text-sm font-semibold text-white transition hover:bg-[#193a59] md:self-auto">

                Browse Jobs

                <svg class="h-4 w-4" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="1.8">

                    <path d="M5 12h14M13 6l6 6-6 6"/>

                </svg>

            </a>

        </section>


        <!-- APPLICATION LIST -->
        @if($applications->count() > 0)

            <section class="w-full space-y-5">

                @foreach($applications as $application)

                    <article class="w-full border border-slate-200 bg-white transition hover:border-slate-300 hover:shadow-sm">

                        <div class="p-6 md:p-7 xl:p-8">

                            <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">


                                <!-- JOB DETAILS -->
                                <div class="flex min-w-0 items-start gap-5">

                                    <div class="hidden h-14 w-14 shrink-0 items-center justify-center rounded-md border border-slate-200 bg-slate-50 text-xl font-semibold text-[#315675] sm:flex">

                                        {{ strtoupper(substr($application->job->job_title, 0, 1)) }}

                                    </div>


                                    <div class="min-w-0">

                                        <p class="mb-2 text-[11px] font-semibold uppercase tracking-wider text-slate-400">
                                            APPLIED POSITION
                                        </p>


                                        <h2 class="break-words text-xl font-semibold text-[#1d3044] lg:text-2xl">
                                            {{ $application->job->job_title }}
                                        </h2>


                                        <!-- JOB INFORMATION -->
                                        <div class="mt-4 flex flex-wrap gap-x-7 gap-y-3 text-sm text-slate-500">


                                            <!-- LOCATION -->
                                            <span class="inline-flex items-center gap-2">

                                                <svg class="h-[18px] w-[18px] text-slate-400"
                                                     viewBox="0 0 24 24"
                                                     fill="none"
                                                     stroke="currentColor"
                                                     stroke-width="1.7">

                                                    <path d="M20 10c0 5-8 11-8 11S4 15 4 10a8 8 0 1 1 16 0Z"/>

                                                    <circle cx="12" cy="10" r="2.5"/>

                                                </svg>

                                                {{ $application->job->location }}

                                            </span>


                                            <!-- JOB TYPE -->
                                            <span class="inline-flex items-center gap-2">

                                                <svg class="h-[18px] w-[18px] text-slate-400"
                                                     viewBox="0 0 24 24"
                                                     fill="none"
                                                     stroke="currentColor"
                                                     stroke-width="1.7">

                                                    <rect x="3" y="7" width="18" height="13" rx="1.5"/>

                                                    <path d="M8 7V4h8v3M3 12h18"/>

                                                </svg>

                                                {{ $application->job->job_type }}

                                            </span>


                                            <!-- SALARY -->
                                            <span class="inline-flex items-center gap-2">

                                                <svg class="h-[18px] w-[18px] text-slate-400"
                                                     viewBox="0 0 24 24"
                                                     fill="none"
                                                     stroke="currentColor"
                                                     stroke-width="1.7">

                                                    <path d="M12 3v18M17 7.5c0-1.7-1.9-3-5-3s-5 1.3-5 3 1.5 2.5 5 3 5 1.3 5 3-1.9 3-5 3-5-1.3-5-3"/>

                                                </svg>

                                                {{ $application->job->salary }}

                                            </span>

                                        </div>


                                        <!-- APPLICATION DATE -->
                                        <p class="mt-5 text-xs text-slate-400">

                                            Applied on

                                            <span class="ml-1 font-semibold text-slate-600">

                                                {{ $application->created_at->format('d M Y') }}

                                            </span>

                                        </p>

                                    </div>

                                </div>


                                <!-- STATUS AND ACTIONS -->
                                <div class="flex shrink-0 flex-col gap-4 border-t border-slate-100 pt-5 lg:min-w-[230px] lg:items-end lg:border-0 lg:pt-0">


                                    <!-- STATUS -->
                                    <div>

                                        @if($application->status === 'Pending')

                                            <span class="inline-flex items-center gap-2 border border-[#f1dfb7] bg-[#fffaf0] px-4 py-2 text-xs font-semibold text-[#91651c]">

                                                <span class="h-2 w-2 rounded-full bg-[#c58b2c]"></span>

                                                Pending

                                            </span>


                                        @elseif($application->status === 'Shortlisted')

                                            <span class="inline-flex items-center gap-2 border border-[#cbdced] bg-[#f2f7fc] px-4 py-2 text-xs font-semibold text-[#315f89]">

                                                <span class="h-2 w-2 rounded-full bg-[#4d80ad]"></span>

                                                Shortlisted

                                            </span>


                                        @elseif($application->status === 'Selected')

                                            <span class="inline-flex items-center gap-2 border border-[#cce5d8] bg-[#f2faf5] px-4 py-2 text-xs font-semibold text-[#28734b]">

                                                <span class="h-2 w-2 rounded-full bg-[#399765]"></span>

                                                Selected

                                            </span>


                                        @elseif($application->status === 'Rejected')

                                            <span class="inline-flex items-center gap-2 border border-[#efd0d0] bg-[#fff6f6] px-4 py-2 text-xs font-semibold text-[#a34444]">

                                                <span class="h-2 w-2 rounded-full bg-[#bd5b5b]"></span>

                                                Rejected

                                            </span>

                                        @endif

                                    </div>


                                    <!-- ACTION LINKS -->
                                    <div class="flex flex-wrap items-center gap-5 text-sm">

                                        <a href="{{ route('student.job.details', $application->job_id) }}"
                                           class="font-semibold text-[#315f86] transition hover:text-[#193d5e]">

                                            View Job Details

                                        </a>


                                        @if($application->resume)

                                            <span class="inline-flex items-center gap-2 font-medium text-[#367653]">

                                                <svg class="h-4 w-4"
                                                     viewBox="0 0 24 24"
                                                     fill="none"
                                                     stroke="currentColor"
                                                     stroke-width="1.8">

                                                    <path d="m5 12 4 4L19 6"/>

                                                </svg>

                                                Resume Uploaded

                                            </span>

                                            <a href="{{ route('applications.resume.download', $application->id) }}"
                                               target="_blank"
                                               class="font-semibold text-[#315f86] transition hover:text-[#193d5e]">

                                                View Resume →

                                            </a>

                                        @else

                                            <a href="{{ route('student.resume.upload', $application->job_id) }}"
                                               class="font-semibold text-[#9a6a25] hover:text-[#754c16]">

                                                Upload Resume

                                            </a>

                                        @endif

                                    </div>

                                </div>

                            </div>

                        </div>


                        <!-- STATUS MESSAGE -->
                        @if($application->status === 'Selected')

                            <div class="border-t border-[#dcebe1] bg-[#f5faf6] px-6 py-4 md:px-8">

                                <p class="text-sm font-medium text-[#34734f]">

                                    Your application has been selected for this position.

                                </p>

                            </div>


                        @elseif($application->status === 'Shortlisted')

                            <div class="border-t border-[#dce6f0] bg-[#f5f8fc] px-6 py-4 md:px-8">

                                <p class="text-sm font-medium text-[#416b91]">

                                    Your application has been shortlisted. Please check your application status for further updates.

                                </p>

                            </div>

                        @endif

                    </article>

                @endforeach

            </section>


        @else


            <!-- EMPTY STATE -->
            <section class="flex min-h-[420px] w-full flex-col items-center justify-center border border-slate-200 bg-white px-6 py-16 text-center">


                <div class="flex h-16 w-16 items-center justify-center rounded-full border border-slate-200 bg-slate-50 text-slate-500">

                    <svg class="h-8 w-8"
                         viewBox="0 0 24 24"
                         fill="none"
                         stroke="currentColor"
                         stroke-width="1.5">

                        <rect x="5" y="3.5" width="14" height="17" rx="1.5"/>

                        <path d="M8.5 8h7M8.5 12h7M8.5 16h4"/>

                    </svg>

                </div>


                <p class="mt-6 text-xs font-semibold uppercase tracking-widest text-slate-400">

                    APPLICATION ACTIVITY

                </p>


                <h2 class="mt-3 text-2xl font-semibold text-[#1d3044]">

                    You haven't applied for any jobs yet

                </h2>


                <p class="mt-3 max-w-lg text-sm leading-6 text-slate-500">

                    When you apply for a position, it will appear here so you can review the details and track its status.

                </p>


                <a href="{{ route('student.jobs') }}"
                   class="mt-7 inline-flex h-11 items-center justify-center gap-3 rounded-md bg-[#24496b] px-6 text-sm font-semibold text-white transition hover:bg-[#193a59]">

                    Browse Available Jobs

                    <svg class="h-4 w-4"
                         viewBox="0 0 24 24"
                         fill="none"
                         stroke="currentColor"
                         stroke-width="1.8">

                        <path d="M5 12h14M13 6l6 6-6 6"/>

                    </svg>

                </a>

            </section>

        @endif

@endsection