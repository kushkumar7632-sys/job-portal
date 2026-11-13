<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Student Dashboard</title>
    <link rel="icon" type="image/svg+xml"
      href="{{ asset('jobportal.svg') }}?v=4">

    @vite('resources/css/app.css')
</head>

@php
    $studentName = session('student_name', 'Student');
    $initial = strtoupper(substr($studentName, 0, 1));
@endphp

<body class="bg-slate-50 text-slate-800 antialiased">

    <div class="min-h-screen flex">

        <!-- SIDEBAR -->
        <aside class="hidden lg:flex w-64 bg-slate-950 text-white flex-col shrink-0">

            <div class="h-20 flex items-center px-7 border-b border-slate-800">

                <div class="w-9 h-9 bg-indigo-600 flex items-center justify-center rounded-lg font-bold text-lg">
                    J
                </div>

                <span class="ml-3 text-xl font-bold tracking-tight">
                    JobPortal
                </span>

            </div>

            <div class="px-5 py-7">

                <p class="text-xs font-semibold uppercase tracking-widest text-slate-500 mb-4">
                    Workspace
                </p>

                <nav class="space-y-1">

                    <a href="{{ route('student.jobs') }}"
                       class="flex items-center gap-3 px-4 py-3 rounded-lg
                              bg-indigo-600 text-white font-medium">

                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                             viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  stroke-width="1.8"
                                  d="M3 10.5L12 3l9 7.5V21H3V10.5Z"/>
                        </svg>

                        Dashboard
                    </a>

                    <a href="{{ route('student.jobs') }}"
                       class="flex items-center gap-3 px-4 py-3 rounded-lg
                              text-slate-400 hover:text-white hover:bg-slate-800 transition">

                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                             viewBox="0 0 24 24">
                            <circle cx="11" cy="11" r="7"
                                    stroke-width="1.8"/>
                            <path d="m16 16 4 4"
                                  stroke-width="1.8"
                                  stroke-linecap="round"/>
                        </svg>

                        Find Jobs
                    </a>

                    <a href="{{ route('student.applications') }}"
                       class="flex items-center gap-3 px-4 py-3 rounded-lg
                              text-slate-400 hover:text-white hover:bg-slate-800 transition">

                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                             viewBox="0 0 24 24">
                            <rect x="4" y="3" width="16" height="18" rx="2"
                                  stroke-width="1.8"/>
                            <path d="M8 8h8M8 12h8M8 16h5"
                                  stroke-width="1.8"
                                  stroke-linecap="round"/>
                        </svg>

                        My Applications
                    </a>

                </nav>

                <div class="border-t border-slate-800 my-7"></div>

                <p class="text-xs font-semibold uppercase tracking-widest text-slate-500 mb-4">
                    Account
                </p>

                <div class="px-4 py-3 text-slate-400 flex items-center gap-3">

                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                         viewBox="0 0 24 24">
                        <circle cx="12" cy="8" r="4" stroke-width="1.8"/>
                        <path d="M4 21c0-4.4 3.6-7 8-7s8 2.6 8 7"
                              stroke-width="1.8"/>
                    </svg>

                    <span>Student Account</span>

                </div>

            </div>

            <!-- SIDEBAR FOOTER -->
            <div class="mt-auto p-5 border-t border-slate-800">

                <div class="flex items-center gap-3">

                    <div class="w-10 h-10 rounded-full bg-indigo-600
                                flex items-center justify-center font-bold">
                        {{ $initial }}
                    </div>

                    <div class="min-w-0">
                        <p class="text-sm font-semibold truncate">
                            {{ $studentName }}
                        </p>

                        <p class="text-xs text-slate-500">
                            Student Account
                        </p>
                    </div>

                </div>

            </div>

        </aside>


        <!-- MAIN CONTENT -->
        <div class="flex-1 min-w-0">

            <!-- TOPBAR -->
            <header class="h-20 bg-white border-b border-slate-200
                           flex items-center justify-between px-5 md:px-8">

                <div>

                    <h2 class="text-lg font-semibold text-slate-900">
                        Dashboard
                    </h2>

                    <p class="text-xs text-slate-500 mt-1">
                        Your career workspace
                    </p>

                </div>

                <div class="flex items-center gap-4">

                    <div class="hidden sm:block text-right">

                        <p class="text-sm font-semibold text-slate-800">
                            {{ $studentName }}
                        </p>

                        <p class="text-xs text-slate-500">
                            Student
                        </p>

                    </div>

                    <div class="w-10 h-10 rounded-full bg-indigo-50
                                border border-indigo-100 text-indigo-700
                                flex items-center justify-center font-bold">

                        {{ $initial }}

                    </div>

                    <a href="{{ route('student.logout') }}"
                       class="text-sm font-medium text-red-600
                              border border-red-200 px-3 py-2 rounded-lg
                              hover:bg-red-50 transition">

                        Logout

                    </a>

                </div>

            </header>


            <!-- DASHBOARD BODY -->
            <main class="max-w-7xl mx-auto p-5 md:p-8">

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


                <!-- STATISTICS -->
                <section class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3
                                gap-5 mb-10">

                    <!-- PROFILE -->
                    <div class="bg-white border border-slate-200
                                p-5 rounded-xl">

                        <div class="flex justify-between items-center">

                            <div>

                                <p class="text-sm text-slate-500">
                                    Your Account
                                </p>

                                <h3 class="text-lg font-bold mt-2 text-slate-900">
                                    Student Profile
                                </h3>

                            </div>

                            <div class="w-11 h-11 bg-indigo-50 text-indigo-600
                                        rounded-lg flex items-center justify-center">

                                <svg class="w-6 h-6" fill="none"
                                     stroke="currentColor" viewBox="0 0 24 24">

                                    <circle cx="12" cy="8" r="4"
                                            stroke-width="1.8"/>

                                    <path d="M4 21c0-4 3.5-7 8-7s8 3 8 7"
                                          stroke-width="1.8"/>

                                </svg>

                            </div>

                        </div>

                    </div>


                    <!-- RESUME -->
                    <div class="bg-white border border-slate-200
                                p-5 rounded-xl">

                        <div class="flex justify-between items-center">

                            <div>

                                <p class="text-sm text-slate-500">
                                    Career Documents
                                </p>

                                <h3 class="text-lg font-bold mt-2 text-slate-900">
                                    Manage Resume
                                </h3>

                            </div>

                            <div class="w-11 h-11 bg-emerald-50 text-emerald-600
                                        rounded-lg flex items-center justify-center">

                                <svg class="w-6 h-6" fill="none"
                                     stroke="currentColor" viewBox="0 0 24 24">

                                    <path d="M7 3h7l5 5v13H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2Z"
                                          stroke-width="1.8"/>

                                    <path d="M14 3v5h5M9 13h6M9 17h6"
                                          stroke-width="1.8"/>

                                </svg>

                            </div>

                        </div>

                    </div>


                    <!-- APPLICATIONS -->
                    <a href="{{ route('student.applications') }}"
                       class="bg-white border border-slate-200
                              p-5 rounded-xl hover:border-indigo-300
                              transition">

                        <div class="flex justify-between items-center">

                            <div>

                                <p class="text-sm text-slate-500">
                                    Job Search Activity
                                </p>

                                <h3 class="text-lg font-bold mt-2 text-slate-900">
                                    My Applications
                                </h3>

                            </div>

                            <div class="w-11 h-11 bg-amber-50 text-amber-600
                                        rounded-lg flex items-center justify-center">

                                <svg class="w-6 h-6" fill="none"
                                     stroke="currentColor" viewBox="0 0 24 24">

                                    <rect x="4" y="3" width="16" height="18"
                                          rx="2" stroke-width="1.8"/>

                                    <path d="M8 8h8M8 12h8M8 16h5"
                                          stroke-width="1.8"/>

                                </svg>

                            </div>

                        </div>

                    </a>

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

                            <span class="text-sm font-medium text-slate-400">
                                Resume feature
                            </span>

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


            </main>


            <!-- FOOTER -->
            <footer class="border-t border-slate-200 bg-white">

                <div class="px-5 md:px-8 py-5
                            flex flex-col sm:flex-row
                            justify-between items-center gap-2">

                    <p class="text-xs text-slate-500">

                        © {{ date('Y') }} JobPortal.
                        All rights reserved.

                    </p>

                    <p class="text-xs text-slate-400">

                        Your career, your next opportunity.

                    </p>

                </div>

            </footer>

        </div>

    </div>

</body>
</html>