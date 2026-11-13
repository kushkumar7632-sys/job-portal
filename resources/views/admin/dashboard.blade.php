<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/svg+xml"
      href="{{ asset('jobportal.svg') }}?v=4">

    <title>Admin Dashboard</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-slate-50 text-slate-800 antialiased">

    <!-- NAVBAR -->
    <header class="sticky top-0 z-50 bg-white border-b border-slate-200">
        <div class="w-full px-5 sm:px-8 lg:px-12 h-20 flex items-center justify-between">

            <!-- LOGO -->
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 rounded-xl bg-blue-600 flex items-center justify-center text-white font-extrabold text-lg shadow-lg shadow-blue-200">
                    JP
                </div>

                <div>
                    <h1 class="text-xl font-extrabold tracking-tight text-slate-900">
                        JobPortal
                    </h1>
                    <p class="text-xs font-medium text-slate-400 mt-0.5">
                        Administration Panel
                    </p>
                </div>
            </div>


            <!-- ADMIN INFO -->
            <div class="flex items-center gap-3 sm:gap-5">

                <div class="hidden sm:block text-right">
                    <p class="text-sm font-bold text-slate-800">
                        Administrator
                    </p>

                    <p class="text-xs text-slate-400 mt-0.5">
                        System Admin
                    </p>
                </div>


                <!-- AVATAR -->
                <div class="w-11 h-11 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center font-bold border-2 border-white shadow-sm">
                    A
                </div>


                <!-- LOGOUT -->
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf

                    <button
                        type="submit"
                        class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl border border-slate-200 text-sm font-semibold text-slate-600 hover:bg-red-50 hover:text-red-600 hover:border-red-200 transition">

                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H6a2 2 0 01-2-2V7a2 2 0 012-2h5a2 2 0 012 2v1"/>
                        </svg>

                        <span class="hidden sm:inline">Logout</span>
                    </button>
                </form>

            </div>
        </div>
    </header>


    <!-- MAIN CONTENT -->
    <main class="w-full px-5 sm:px-8 lg:px-12 xl:px-16 py-9">


        <!-- WELCOME SECTION -->
        <section class="mb-9">

            <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-5">

                <div>
                    <p class="text-xs sm:text-sm font-bold uppercase tracking-widest text-blue-600 mb-3">
                        Administration
                    </p>

                    <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight text-slate-900">
                        Welcome back, Admin
                    </h2>

                    <p class="text-slate-500 mt-3 text-sm sm:text-base">
                        Manage and monitor your JobPortal platform.
                    </p>
                </div>

                <div class="text-sm text-slate-500">
                    <span class="inline-flex items-center gap-2 rounded-full bg-green-50 border border-green-100 px-4 py-2 text-green-700 font-medium">
                        <span class="w-2 h-2 rounded-full bg-green-500"></span>
                        Admin Panel Active
                    </span>
                </div>

            </div>

        </section>


        <!-- STATISTICS -->
        <section class="mb-10">

            <div class="flex items-center justify-between mb-5">
                <div>
                    <h3 class="text-xl font-bold text-slate-900">
                        Platform Overview
                    </h3>

                    <p class="text-sm text-slate-500 mt-1">
                        Key statistics of your JobPortal platform.
                    </p>
                </div>
            </div>


            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5">


                <!-- STUDENTS -->
                <div class="group bg-white rounded-2xl border border-slate-200 p-6 shadow-sm hover:shadow-lg hover:border-blue-200 transition">

                    <div class="flex items-start justify-between">

                        <div>
                            <p class="text-sm font-semibold text-slate-500">
                                Total Students
                            </p>

                            <h3 class="text-4xl font-extrabold text-slate-900 mt-4">
                                {{ $studentCount }}
                            </h3>
                        </div>

                        <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center group-hover:bg-blue-600 group-hover:text-white transition">

                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                      d="M17 20h5v-2a4 4 0 00-4-4h-1m-4 6H3v-2a4 4 0 014-4h6a4 4 0 014 4v2zM12 10a4 4 0 100-8 4 4 0 000 8z"/>
                            </svg>

                        </div>

                    </div>

                    <div class="mt-6 pt-4 border-t border-slate-100">
                        <p class="text-xs font-medium text-slate-400">
                            Registered candidates
                        </p>
                    </div>

                </div>


                <!-- COMPANIES -->
                <a href="{{ route('admin.companies') }}"
                   class="group bg-white rounded-2xl border border-slate-200 p-6 shadow-sm hover:shadow-lg hover:border-emerald-200 transition">

                    <div class="flex items-start justify-between">

                        <div>
                            <p class="text-sm font-semibold text-slate-500">
                                Total Companies
                            </p>

                            <h3 class="text-4xl font-extrabold text-slate-900 mt-4">
                                {{ $companyCount }}
                            </h3>
                        </div>

                        <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center group-hover:bg-emerald-600 group-hover:text-white transition">

                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                      d="M3 21h18M5 21V7l7-4 7 4v14M9 21v-4h6v4M9 10h1m4 0h1m-6 4h1m4 0h1"/>
                            </svg>

                        </div>

                    </div>

                    <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between">
                        <p class="text-xs font-semibold text-blue-600">
                            Manage Companies
                        </p>

                        <svg class="w-4 h-4 text-blue-600 group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M5 12h14m-7-7l7 7-7 7"/>
                        </svg>
                    </div>

                </a>


                <!-- JOBS -->
                <div class="group bg-white rounded-2xl border border-slate-200 p-6 shadow-sm hover:shadow-lg hover:border-purple-200 transition">

                    <div class="flex items-start justify-between">

                        <div>
                            <p class="text-sm font-semibold text-slate-500">
                                Total Jobs
                            </p>

                            <h3 class="text-4xl font-extrabold text-slate-900 mt-4">
                                {{ $jobCount }}
                            </h3>
                        </div>

                        <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center group-hover:bg-purple-600 group-hover:text-white transition">

                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                      d="M20 7h-4V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2H4a2 2 0 00-2 2v9a2 2 0 002 2h16a2 2 0 002-2V9a2 2 0 00-2-2zM8 7h8"/>
                            </svg>

                        </div>

                    </div>

                    <div class="mt-6 pt-4 border-t border-slate-100">
                        <p class="text-xs font-medium text-slate-400">
                            Jobs posted on platform
                        </p>
                    </div>

                </div>


                <!-- APPLICATIONS -->
                <div class="group bg-white rounded-2xl border border-slate-200 p-6 shadow-sm hover:shadow-lg hover:border-orange-200 transition">

                    <div class="flex items-start justify-between">

                        <div>
                            <p class="text-sm font-semibold text-slate-500">
                                Applications
                            </p>

                            <h3 class="text-4xl font-extrabold text-slate-900 mt-4">
                                {{ $applicationCount }}
                            </h3>
                        </div>

                        <div class="w-12 h-12 rounded-xl bg-orange-50 text-orange-600 flex items-center justify-center group-hover:bg-orange-600 group-hover:text-white transition">

                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                      d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h7l5 5v11a2 2 0 01-2 2zM14 3v5h5"/>
                            </svg>

                        </div>

                    </div>

                    <div class="mt-6 pt-4 border-t border-slate-100">
                        <p class="text-xs font-medium text-slate-400">
                            Total job applications
                        </p>
                    </div>

                </div>

            </div>

        </section>


        <!-- MANAGEMENT SECTION -->
        <section class="mt-10">

            <div class="mb-6">
                <h3 class="text-2xl font-bold text-slate-900">
                    Management
                </h3>

                <p class="text-sm text-slate-500 mt-2">
                    Manage the main sections of your JobPortal platform.
                </p>
            </div>


            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5">


                <!-- COMPANIES -->
                <a href="{{ route('admin.companies') }}"
                   class="group bg-white border border-slate-200 rounded-2xl p-6 shadow-sm hover:shadow-lg hover:border-blue-300 transition">

                    <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center mb-5 group-hover:bg-blue-600 group-hover:text-white transition">

                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                  d="M3 21h18M5 21V7l7-4 7 4v14M9 21v-4h6v4M9 10h1m4 0h1m-6 4h1m4 0h1"/>
                        </svg>

                    </div>

                    <h4 class="font-bold text-lg text-slate-900">
                        Companies
                    </h4>

                    <p class="text-sm text-slate-500 mt-2 leading-6">
                        View and manage registered companies.
                    </p>

                    <div class="mt-6 flex items-center justify-between text-sm font-semibold text-blue-600">
                        <span>Manage Companies</span>

                        <svg class="w-4 h-4 group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M5 12h14m-7-7l7 7-7 7"/>
                        </svg>
                    </div>

                </a>


                <!-- STUDENTS -->
                <div class="group bg-white border border-slate-200 rounded-2xl p-6 shadow-sm hover:shadow-lg transition">

                    <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center mb-5">

                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                  d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2m16-11a4 4 0 110-8 4 4 0 010 8zM9 11a4 4 0 100-8 4 4 0 000 8zm13 10v-2a4 4 0 00-3-3.87"/>
                        </svg>

                    </div>

                    <h4 class="font-bold text-lg text-slate-900">
                        Students
                    </h4>

                    <p class="text-sm text-slate-500 mt-2 leading-6">
                        Monitor registered students and candidates.
                    </p>

                    <div class="mt-6 pt-4 border-t border-slate-100 text-sm font-semibold text-slate-500">
                        {{ $studentCount }} Registered
                    </div>

                </div>


                <!-- JOBS -->
                <div class="group bg-white border border-slate-200 rounded-2xl p-6 shadow-sm hover:shadow-lg transition">

                    <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center mb-5">

                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                  d="M20 7h-4V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2H4a2 2 0 00-2 2v9a2 2 0 002 2h16a2 2 0 002-2V9a2 2 0 00-2-2zM8 7h8"/>
                        </svg>

                    </div>

                    <h4 class="font-bold text-lg text-slate-900">
                        Jobs
                    </h4>

                    <p class="text-sm text-slate-500 mt-2 leading-6">
                        Monitor jobs posted by companies.
                    </p>

                    <div class="mt-6 pt-4 border-t border-slate-100 text-sm font-semibold text-slate-500">
                        {{ $jobCount }} Jobs Posted
                    </div>

                </div>


                <!-- APPLICATIONS -->
                <div class="group bg-white border border-slate-200 rounded-2xl p-6 shadow-sm hover:shadow-lg transition">

                    <div class="w-12 h-12 rounded-xl bg-orange-50 text-orange-600 flex items-center justify-center mb-5">

                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                  d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h7l5 5v11a2 2 0 01-2 2zM14 3v5h5"/>
                        </svg>

                    </div>

                    <h4 class="font-bold text-lg text-slate-900">
                        Applications
                    </h4>

                    <p class="text-sm text-slate-500 mt-2 leading-6">
                        Monitor applications submitted by students.
                    </p>

                    <div class="mt-6 pt-4 border-t border-slate-100 text-sm font-semibold text-slate-500">
                        {{ $applicationCount }} Applications
                    </div>

                </div>

            </div>

        </section>


        <!-- FOOTER -->
        <footer class="mt-12 pt-6 border-t border-slate-200 text-center text-xs text-slate-400">

            © {{ date('Y') }} JobPortal Admin Panel. All rights reserved.

        </footer>

    </main>

</body>
</html>