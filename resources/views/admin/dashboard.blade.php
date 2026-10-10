<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Admin Dashboard | JobPortal</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-50 min-h-screen text-slate-800">

    <!-- ================= NAVBAR ================= -->
    <header class="sticky top-0 z-50 bg-white border-b border-slate-200">

        <div class="flex items-center justify-between px-5 md:px-8 h-16">

            <!-- Logo -->
            <div class="flex items-center gap-3">

                <div
                    class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center text-white font-bold text-lg">
                    JP
                </div>

                <div>
                    <h1 class="font-bold text-lg leading-none">
                        JobPortal
                    </h1>

                    <p class="text-xs text-slate-500 mt-1">
                        Admin Panel
                    </p>
                </div>

            </div>


            <!-- Admin Info -->
            <div class="flex items-center gap-4">

                <div class="hidden sm:block text-right">

                    <p class="text-sm font-semibold text-slate-700">
                        Administrator
                    </p>

                    <p class="text-xs text-slate-400">
                        System Admin
                    </p>

                </div>


                <!-- Avatar -->
                <div
                    class="w-10 h-10 rounded-full bg-blue-100 text-blue-700
                           flex items-center justify-center font-bold">

                    A

                </div>


                <!-- Logout -->
                <form action="{{ route('admin.logout') }}" method="POST">

                    @csrf

                    <button
                        type="submit"
                        class="flex items-center gap-2 px-4 py-2
                               rounded-lg border border-slate-200
                               text-sm font-medium text-slate-600
                               hover:bg-red-50 hover:text-red-600
                               hover:border-red-200 transition">

                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="w-4 h-4"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor">

                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H6a2 2 0 01-2-2V7a2 2 0 012-2h5a2 2 0 012 2v1" />

                        </svg>

                        Logout

                    </button>

                </form>

            </div>

        </div>

    </header>


    <!-- ================= MAIN ================= -->

    <main class="max-w-7xl mx-auto px-5 md:px-8 py-8">


        <!-- Welcome -->

        <div class="mb-8">

            <p class="text-sm font-semibold text-blue-600 mb-1">
                ADMINISTRATION
            </p>

            <h2 class="text-3xl md:text-4xl font-bold text-slate-900">
                Welcome back, Admin 👋
            </h2>

            <p class="text-slate-500 mt-2">
                Manage and monitor your JobPortal platform.
            </p>

        </div>


        <!-- ================= STAT CARDS ================= -->

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">


            <!-- Students -->

            <div
                class="bg-white rounded-2xl border border-slate-200
                       p-6 shadow-sm hover:shadow-md transition">

                <div class="flex items-start justify-between">

                    <div>

                        <p class="text-sm font-medium text-slate-500">
                            Total Students
                        </p>

                        <p class="text-3xl font-bold text-slate-900 mt-3">
                            {{ $studentCount }}
                        </p>

                    </div>

                    <div
                        class="w-11 h-11 rounded-xl bg-blue-50
                               text-blue-600 flex items-center justify-center">

                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="w-6 h-6"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor">

                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M17 20h5v-2a4 4 0 00-4-4h-1m-4 6H3v-2a4 4 0 014-4h6a4 4 0 014 4v2zM12 10a4 4 0 100-8 4 4 0 000 8z" />

                        </svg>

                    </div>

                </div>

                <p class="text-xs text-slate-400 mt-5">
                    Registered candidates
                </p>

            </div>



            <!-- Companies -->

            <a href="{{ route('admin.companies') }}"
                class="bg-white rounded-2xl border border-slate-200
                       p-6 shadow-sm hover:shadow-md
                       hover:border-blue-200 transition group">

                <div class="flex items-start justify-between">

                    <div>

                        <p class="text-sm font-medium text-slate-500">
                            Total Companies
                        </p>

                        <p class="text-3xl font-bold text-slate-900 mt-3">
                            {{ $companyCount }}
                        </p>

                    </div>

                    <div
                        class="w-11 h-11 rounded-xl bg-emerald-50
                               text-emerald-600 flex items-center justify-center">

                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="w-6 h-6"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor">

                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M3 21h18M5 21V7l7-4 7 4v14M9 21v-4h6v4M9 10h1m4 0h1m-6 4h1m4 0h1" />

                        </svg>

                    </div>

                </div>

                <div class="flex items-center gap-1 mt-5
                            text-sm text-blue-600">

                    <span>
                        Manage Companies
                    </span>

                    <span class="group-hover:translate-x-1 transition">
                        →
                    </span>

                </div>

            </a>



            <!-- Jobs -->

            <div
                class="bg-white rounded-2xl border border-slate-200
                       p-6 shadow-sm hover:shadow-md transition">

                <div class="flex items-start justify-between">

                    <div>

                        <p class="text-sm font-medium text-slate-500">
                            Total Jobs
                        </p>

                        <p class="text-3xl font-bold text-slate-900 mt-3">
                            {{ $jobCount }}
                        </p>

                    </div>

                    <div
                        class="w-11 h-11 rounded-xl bg-purple-50
                               text-purple-600 flex items-center justify-center">

                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="w-6 h-6"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor">

                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M20 7h-4V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2H4a2 2 0 00-2 2v9a2 2 0 002 2h16a2 2 0 002-2V9a2 2 0 00-2-2zM8 7h8" />

                        </svg>

                    </div>

                </div>

                <p class="text-xs text-slate-400 mt-5">
                    Jobs posted on platform
                </p>

            </div>



            <!-- Applications -->

            <div
                class="bg-white rounded-2xl border border-slate-200
                       p-6 shadow-sm hover:shadow-md transition">

                <div class="flex items-start justify-between">

                    <div>

                        <p class="text-sm font-medium text-slate-500">
                            Applications
                        </p>

                        <p class="text-3xl font-bold text-slate-900 mt-3">
                            {{ $applicationCount }}
                        </p>

                    </div>

                    <div
                        class="w-11 h-11 rounded-xl bg-orange-50
                               text-orange-600 flex items-center justify-center">

                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="w-6 h-6"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor">

                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h7l5 5v11a2 2 0 01-2 2zM14 3v5h5" />

                        </svg>

                    </div>

                </div>

                <p class="text-xs text-slate-400 mt-5">
                    Total job applications
                </p>

            </div>

        </div>


        <!-- ================= MANAGEMENT ================= -->

        <div class="mt-8">

            <div class="mb-5">

                <h3 class="text-xl font-bold text-slate-900">
                    Management
                </h3>

                <p class="text-sm text-slate-500 mt-1">
                    Manage the main sections of your JobPortal.
                </p>

            </div>


            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">


                <!-- Companies -->

                <a href="{{ route('admin.companies') }}"
                    class="bg-white border border-slate-200 rounded-2xl
                           p-6 shadow-sm hover:shadow-md
                           hover:border-blue-300 transition group">

                    <div
                        class="w-12 h-12 rounded-xl bg-blue-50
                               text-blue-600 flex items-center justify-center
                               mb-5">

                        🏢

                    </div>

                    <h4 class="font-bold text-slate-900">
                        Companies
                    </h4>

                    <p class="text-sm text-slate-500 mt-2">
                        View and manage registered companies.
                    </p>

                    <div
                        class="mt-5 text-sm font-semibold text-blue-600
                               group-hover:translate-x-1 transition">

                        Manage Companies →

                    </div>

                </a>



                <!-- Students -->

                <div
                    class="bg-white border border-slate-200 rounded-2xl
                           p-6 shadow-sm hover:shadow-md transition">

                    <div
                        class="w-12 h-12 rounded-xl bg-emerald-50
                               text-emerald-600 flex items-center justify-center
                               mb-5">

                        👨‍🎓

                    </div>

                    <h4 class="font-bold text-slate-900">
                        Students
                    </h4>

                    <p class="text-sm text-slate-500 mt-2">
                        Monitor registered students and candidates.
                    </p>

                    <div class="mt-5 text-sm font-semibold text-slate-400">
                        {{ $studentCount }} Registered
                    </div>

                </div>



                <!-- Jobs -->

                <div
                    class="bg-white border border-slate-200 rounded-2xl
                           p-6 shadow-sm hover:shadow-md transition">

                    <div
                        class="w-12 h-12 rounded-xl bg-purple-50
                               text-purple-600 flex items-center justify-center
                               mb-5">

                        💼

                    </div>

                    <h4 class="font-bold text-slate-900">
                        Jobs
                    </h4>

                    <p class="text-sm text-slate-500 mt-2">
                        Monitor jobs posted by companies.
                    </p>

                    <div class="mt-5 text-sm font-semibold text-slate-400">
                        {{ $jobCount }} Jobs Posted
                    </div>

                </div>



                <!-- Applications -->

                <div
                    class="bg-white border border-slate-200 rounded-2xl
                           p-6 shadow-sm hover:shadow-md transition">

                    <div
                        class="w-12 h-12 rounded-xl bg-orange-50
                               text-orange-600 flex items-center justify-center
                               mb-5">

                        📄

                    </div>

                    <h4 class="font-bold text-slate-900">
                        Applications
                    </h4>

                    <p class="text-sm text-slate-500 mt-2">
                        Monitor applications submitted by students.
                    </p>

                    <div class="mt-5 text-sm font-semibold text-slate-400">
                        {{ $applicationCount }} Applications
                    </div>

                </div>

            </div>

        </div>


        <!-- ================= FOOTER ================= -->

        <footer class="text-center text-xs text-slate-400 mt-12 pb-5">

            © {{ date('Y') }} JobPortal Admin Panel.
            All rights reserved.

        </footer>

    </main>

</body>

</html>