<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Find Jobs | JobPortal</title>

    @vite('resources/css/app.css')
</head>

@php
    $studentName = session('student_name', 'Student');
    $studentInitial = strtoupper(substr($studentName, 0, 1));
@endphp

<body class="min-h-screen bg-[#f5f7fa] text-slate-800 antialiased">

<div class="flex min-h-screen">

    <!-- SIDEBAR -->
    <aside class="fixed inset-y-0 left-0 z-40 hidden w-[260px] flex-col bg-[#080d20] text-white lg:flex">

        <!-- Logo -->
        <div class="flex h-[84px] items-center border-b border-white/10 px-7">

            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-[#5140ef] text-lg font-bold">
                J
            </div>

            <span class="ml-3 text-xl font-semibold tracking-tight">
                JobPortal
            </span>

        </div>


        <!-- Navigation -->
        <div class="flex-1 px-5 py-8">

            <p class="mb-4 px-3 text-[11px] font-semibold uppercase tracking-[0.15em] text-slate-500">
                Workspace
            </p>


            <nav class="space-y-2">

                <!-- Dashboard -->
                <a href="{{ route('student.dashboard') }}"
                   class="flex items-center gap-3 rounded-lg px-4 py-3 text-sm font-medium text-slate-400 transition hover:bg-white/5 hover:text-white">

                    <svg class="h-5 w-5" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor" stroke-width="1.7">

                        <path d="m3 10 9-7 9 7v10a1 1 0 0 1-1 1h-6v-7h-4v7H4a1 1 0 0 1-1-1z"/>

                    </svg>

                    Dashboard

                </a>


                <!-- Find Jobs -->
                <a href="{{ route('student.jobs') }}"
                   class="flex items-center gap-3 rounded-lg bg-[#5140ef] px-4 py-3 text-sm font-semibold text-white shadow-lg shadow-indigo-950/20">

                    <svg class="h-5 w-5" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor" stroke-width="1.7">

                        <circle cx="11" cy="11" r="7"/>
                        <path d="m16 16 4 4"/>

                    </svg>

                    Find Jobs

                </a>


                <!-- My Applications -->
                <a href="{{ url('/student/applications') }}"
                   class="flex items-center gap-3 rounded-lg px-4 py-3 text-sm font-medium text-slate-400 transition hover:bg-white/5 hover:text-white">

                    <svg class="h-5 w-5" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor" stroke-width="1.7">

                        <rect x="5" y="3" width="14" height="18" rx="2"/>
                        <path d="M9 8h6M9 12h6M9 16h4"/>

                    </svg>

                    My Applications

                </a>

            </nav>


            <div class="my-7 border-t border-white/10"></div>


            <p class="mb-4 px-3 text-[11px] font-semibold uppercase tracking-[0.15em] text-slate-500">
                Account
            </p>


            <div class="rounded-lg px-4 py-3">

                <div class="flex items-center gap-3">

                    <div class="flex h-9 w-9 items-center justify-center rounded-full bg-white/10 text-sm font-semibold text-slate-300">
                        {{ $studentInitial }}
                    </div>

                    <div class="min-w-0">

                        <p class="truncate text-sm font-semibold text-white">
                            {{ $studentName }}
                        </p>

                        <p class="text-xs text-slate-500">
                            Student Account
                        </p>

                    </div>

                </div>

            </div>

        </div>


        <!-- Sidebar Footer -->
        <div class="border-t border-white/10 px-7 py-5">

            <p class="text-xs text-slate-500">
                JobPortal Student Workspace
            </p>

        </div>

    </aside>



    <!-- MAIN AREA -->
    <div class="flex min-h-screen w-full flex-col lg:ml-[260px]">


        <!-- TOP NAVBAR -->
        <header class="sticky top-0 z-30 flex h-[76px] items-center justify-between border-b border-slate-200 bg-white px-5 sm:px-8 lg:px-10">

            <div>

                <h2 class="text-lg font-semibold text-[#172b40]">
                    Find Jobs
                </h2>

                <p class="hidden text-xs text-slate-400 sm:block">
                    Discover opportunities for your career
                </p>

            </div>


            <div class="flex items-center gap-4">

                <div class="hidden text-right sm:block">

                    <p class="text-sm font-semibold text-slate-800">
                        {{ $studentName }}
                    </p>

                    <p class="text-xs text-slate-400">
                        Student
                    </p>

                </div>


                <div class="flex h-10 w-10 items-center justify-center rounded-full border border-slate-200 bg-[#edf1ff] font-semibold text-[#5140ef]">

                    {{ $studentInitial }}

                </div>


                <a href="{{ route('student.dashboard') }}"
                   class="hidden rounded-md border border-slate-200 px-4 py-2 text-sm font-medium text-slate-600 transition hover:bg-slate-50 md:inline-flex">

                    Dashboard

                </a>

            </div>

        </header>



        <!-- PAGE CONTENT -->
        <main class="flex-1 px-5 py-8 sm:px-8 lg:px-10 lg:py-10">


            <!-- PAGE HEADING -->
            <section class="mb-8 flex flex-col justify-between gap-5 md:flex-row md:items-end">

                <div>

                    <p class="text-xs font-semibold uppercase tracking-[0.15em] text-[#5140ef]">
                        CAREER OPPORTUNITIES
                    </p>

                    <h1 class="mt-2 text-2xl font-bold tracking-tight text-[#172b40] sm:text-3xl">
                        Find your next opportunity
                    </h1>

                    <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-500">
                        Explore available positions and discover opportunities that match your skills and career goals.
                    </p>

                </div>


                <!-- JOB COUNT -->
                @if($jobs->count() > 0)

                    <div class="inline-flex items-center gap-3 self-start border border-slate-200 bg-white px-4 py-3">

                        <span class="h-2 w-2 rounded-full bg-emerald-500"></span>

                        <span class="text-sm font-medium text-slate-600">

                            {{ $jobs->count() }} Jobs Available

                        </span>

                    </div>

                @endif

            </section>



            <!-- JOB LISTINGS -->
            @if($jobs->count() > 0)

                <section>

                    <div class="mb-5 flex items-center justify-between border-b border-slate-200 pb-4">

                        <h2 class="text-base font-semibold text-[#172b40]">
                            Available Positions
                        </h2>

                        <p class="text-xs text-slate-400">
                            Latest opportunities
                        </p>

                    </div>


                    <!-- JOB GRID -->
                    <div class="grid grid-cols-1 gap-5 xl:grid-cols-2 2xl:grid-cols-3">


                        @foreach($jobs as $job)


                            <!-- JOB CARD -->
                            <article class="group flex flex-col border border-slate-200 bg-white transition duration-200 hover:border-slate-300 hover:shadow-[0_5px_20px_rgba(15,23,42,0.06)]">


                                <!-- CARD HEADER -->
                                <div class="p-5 sm:p-6">


                                    <div class="flex items-start justify-between gap-3">


                                        <div class="flex min-w-0 items-start gap-3">

                                            <div class="flex h-12 w-12 shrink-0 items-center justify-center border border-[#e3e8f0] bg-[#f4f6fb] text-lg font-bold text-[#344f75]">

                                                {{ strtoupper(substr($job->job_title, 0, 1)) }}

                                            </div>


                                            <div class="min-w-0">

                                                <h3 class="break-words text-lg font-semibold leading-6 text-[#172b40] transition group-hover:text-[#5140ef]">

                                                    {{ $job->job_title }}

                                                </h3>

                                                <p class="mt-1 text-xs text-slate-400">
                                                    Job Opportunity
                                                </p>

                                            </div>

                                        </div>


                                        <!-- JOB TYPE -->
                                        <span class="shrink-0 border border-[#dce4f3] bg-[#f3f6fc] px-2.5 py-1 text-[11px] font-semibold text-[#45648a]">

                                            {{ $job->job_type }}

                                        </span>

                                    </div>



                                    <!-- DIVIDER -->
                                    <div class="my-5 border-t border-slate-100"></div>



                                    <!-- JOB DETAILS -->
                                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">


                                        <!-- LOCATION -->
                                        <div class="flex items-start gap-3">

                                            <div class="flex h-9 w-9 shrink-0 items-center justify-center bg-slate-50 text-slate-500">

                                                <svg class="h-[18px] w-[18px]"
                                                     viewBox="0 0 24 24"
                                                     fill="none"
                                                     stroke="currentColor"
                                                     stroke-width="1.7">

                                                    <path d="M20 10c0 5-8 11-8 11S4 15 4 10a8 8 0 1 1 16 0Z"/>
                                                    <circle cx="12" cy="10" r="2.5"/>

                                                </svg>

                                            </div>


                                            <div class="min-w-0">

                                                <p class="text-[11px] text-slate-400">
                                                    Location
                                                </p>

                                                <p class="mt-1 break-words text-sm font-medium text-slate-700">
                                                    {{ $job->location }}
                                                </p>

                                            </div>

                                        </div>



                                        <!-- SALARY -->
                                        <div class="flex items-start gap-3">

                                            <div class="flex h-9 w-9 shrink-0 items-center justify-center bg-slate-50 text-slate-500">

                                                <svg class="h-[18px] w-[18px]"
                                                     viewBox="0 0 24 24"
                                                     fill="none"
                                                     stroke="currentColor"
                                                     stroke-width="1.7">

                                                    <path d="M12 3v18M17 7.5c0-1.7-1.9-3-5-3s-5 1.3-5 3 1.5 2.5 5 3 5 1.3 5 3-1.9 3-5 3-5-1.3-5-3"/>

                                                </svg>

                                            </div>


                                            <div class="min-w-0">

                                                <p class="text-[11px] text-slate-400">
                                                    Salary
                                                </p>

                                                <p class="mt-1 break-words text-sm font-medium text-slate-700">
                                                    {{ $job->salary }}
                                                </p>

                                            </div>

                                        </div>



                                        <!-- EXPERIENCE -->
                                        <div class="flex items-start gap-3">

                                            <div class="flex h-9 w-9 shrink-0 items-center justify-center bg-slate-50 text-slate-500">

                                                <svg class="h-[18px] w-[18px]"
                                                     viewBox="0 0 24 24"
                                                     fill="none"
                                                     stroke="currentColor"
                                                     stroke-width="1.7">

                                                    <circle cx="12" cy="12" r="9"/>
                                                    <path d="M12 7v5l3 2"/>

                                                </svg>

                                            </div>


                                            <div>

                                                <p class="text-[11px] text-slate-400">
                                                    Experience
                                                </p>

                                                <p class="mt-1 text-sm font-medium text-slate-700">
                                                    {{ $job->experience }}
                                                </p>

                                            </div>

                                        </div>



                                        <!-- VACANCY -->
                                        <div class="flex items-start gap-3">

                                            <div class="flex h-9 w-9 shrink-0 items-center justify-center bg-slate-50 text-slate-500">

                                                <svg class="h-[18px] w-[18px]"
                                                     viewBox="0 0 24 24"
                                                     fill="none"
                                                     stroke="currentColor"
                                                     stroke-width="1.7">

                                                    <circle cx="9" cy="8" r="3"/>
                                                    <path d="M3 20v-1a6 6 0 0 1 12 0v1M16 5a3 3 0 0 1 0 6M18 14a5 5 0 0 1 3 5v1"/>

                                                </svg>

                                            </div>


                                            <div>

                                                <p class="text-[11px] text-slate-400">
                                                    Open Positions
                                                </p>

                                                <p class="mt-1 text-sm font-medium text-slate-700">
                                                    {{ $job->vacancy }} Vacancies
                                                </p>

                                            </div>

                                        </div>


                                    </div>


                                </div>



                                <!-- CARD FOOTER -->
                                <div class="mt-auto flex flex-col justify-between gap-4 border-t border-slate-100 bg-[#fafbfc] px-5 py-4 sm:flex-row sm:items-center sm:px-6">


                                    <!-- DEADLINE -->
                                    <div>

                                        <p class="text-[11px] text-slate-400">
                                            Application Deadline
                                        </p>

                                        <p class="mt-1 text-sm font-semibold text-slate-700">

                                            {{ $job->deadline }}

                                        </p>

                                    </div>



                                    <!-- VIEW DETAILS -->
                                    <a href="{{ route('student.job.details', $job->id) }}"
                                       class="inline-flex h-10 items-center justify-center gap-2 bg-[#5140ef] px-5 text-sm font-semibold text-white transition hover:bg-[#4032d1]">

                                        View Details

                                        <svg class="h-4 w-4"
                                             viewBox="0 0 24 24"
                                             fill="none"
                                             stroke="currentColor"
                                             stroke-width="1.8">

                                            <path d="M5 12h14M13 6l6 6-6 6"/>

                                        </svg>

                                    </a>


                                </div>


                            </article>


                        @endforeach


                    </div>

                </section>



            @else


                <!-- EMPTY STATE -->
                <section class="flex min-h-[420px] flex-col items-center justify-center border border-slate-200 bg-white px-6 py-16 text-center">


                    <div class="flex h-16 w-16 items-center justify-center border border-slate-200 bg-slate-50 text-slate-500">

                        <svg class="h-8 w-8"
                             viewBox="0 0 24 24"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="1.5">

                            <rect x="3" y="7" width="18" height="13" rx="1.5"/>
                            <path d="M8 7V4h8v3M3 12h18"/>

                        </svg>

                    </div>


                    <h2 class="mt-6 text-xl font-semibold text-[#172b40]">
                        No Jobs Available
                    </h2>


                    <p class="mt-2 max-w-md text-sm leading-6 text-slate-500">
                        There are currently no job openings available. Please check again later for new opportunities.
                    </p>


                    <a href="{{ route('student.dashboard') }}"
                       class="mt-6 inline-flex h-10 items-center justify-center bg-[#5140ef] px-5 text-sm font-semibold text-white transition hover:bg-[#4032d1]">

                        Back to Dashboard

                    </a>


                </section>


            @endif


        </main>



        <!-- FOOTER -->
        <footer class="border-t border-slate-200 bg-white px-5 py-5 sm:px-8 lg:px-10">

            <div class="flex flex-col justify-between gap-2 text-xs text-slate-400 sm:flex-row sm:items-center">

                <p>
                    &copy; {{ date('Y') }} JobPortal. All rights reserved.
                </p>

                <p>
                    Student Workspace
                </p>

            </div>

        </footer>


    </div>

</div>


<!-- MOBILE NAVIGATION -->
<div class="fixed bottom-0 left-0 right-0 z-50 border-t border-slate-200 bg-white lg:hidden">

    <div class="grid grid-cols-3">

        <a href="{{ route('student.dashboard') }}"
           class="flex flex-col items-center gap-1 py-3 text-xs text-slate-500">

            <svg class="h-5 w-5" viewBox="0 0 24 24"
                 fill="none" stroke="currentColor" stroke-width="1.7">

                <path d="m3 10 9-7 9 7v10a1 1 0 0 1-1 1h-6v-7h-4v7H4a1 1 0 0 1-1-1z"/>

            </svg>

            Dashboard

        </a>


        <a href="{{ route('student.jobs') }}"
           class="flex flex-col items-center gap-1 border-t-2 border-[#5140ef] py-3 text-xs font-semibold text-[#5140ef]">

            <svg class="h-5 w-5" viewBox="0 0 24 24"
                 fill="none" stroke="currentColor" stroke-width="1.7">

                <circle cx="11" cy="11" r="7"/>
                <path d="m16 16 4 4"/>

            </svg>

            Find Jobs

        </a>


        <a href="{{ url('/student/applications') }}"
           class="flex flex-col items-center gap-1 py-3 text-xs text-slate-500">

            <svg class="h-5 w-5" viewBox="0 0 24 24"
                 fill="none" stroke="currentColor" stroke-width="1.7">

                <rect x="5" y="3" width="14" height="18" rx="2"/>
                <path d="M9 8h6M9 12h6M9 16h4"/>

            </svg>

            Applications

        </a>

    </div>

</div>


</body>
</html>