<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/svg+xml"
      href="{{ asset('jobportal.svg') }}?v=4">

    <title>Company Dashboard</title>

    @vite('resources/css/app.css')
</head>

<body class="bg-[#f7f8fa] text-slate-800 antialiased">

    <div class="min-h-screen flex">

        <!-- Sidebar -->
        <aside class="hidden lg:flex w-[250px] bg-[#111827] text-white flex-col shrink-0">

            <!-- Logo -->
            <div class="h-20 px-7 flex items-center border-b border-white/10">

                <a href="/company/dashboard"
                   class="text-2xl font-bold tracking-tight">

                    Job<span class="text-blue-400">Portal</span>

                </a>

            </div>


            <!-- Navigation -->
            <div class="px-4 py-8 flex-1">

                <p class="px-3 text-[11px] font-semibold
                          uppercase tracking-[0.15em]
                          text-slate-500 mb-4">

                    Workspace

                </p>


                <nav class="space-y-1">

                    <a href="/company/dashboard"
                       class="flex items-center gap-3 px-3 py-3
                              rounded-lg bg-blue-600 text-white
                              text-sm font-medium">

                        <svg class="w-5 h-5" fill="none"
                             stroke="currentColor" viewBox="0 0 24 24">
                            <rect x="3" y="3" width="7" height="7" rx="1"/>
                            <rect x="14" y="3" width="7" height="7" rx="1"/>
                            <rect x="14" y="14" width="7" height="7" rx="1"/>
                            <rect x="3" y="14" width="7" height="7" rx="1"/>
                        </svg>

                        Dashboard

                    </a>


                    <a href="/company/job/create"
                       class="sidebar-link">

                        <svg class="w-5 h-5" fill="none"
                             stroke="currentColor" viewBox="0 0 24 24">
                            <rect x="3" y="7" width="18" height="14" rx="2"/>
                            <path d="M8 7V4h8v3M3 12h18M10 12v2h4v-2"/>
                        </svg>

                        Post a Job

                    </a>


                    <a href="{{ route('company.jobs') }}"
                       class="sidebar-link">

                        <svg class="w-5 h-5" fill="none"
                             stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M4 5h16M4 10h16M4 15h10M4 20h10"/>
                        </svg>

                        Manage Jobs

                    </a>


                    <a href="#"
                       class="sidebar-link">

                        <svg class="w-5 h-5" fill="none"
                             stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                            <circle cx="9" cy="7" r="4"/>
                            <path d="M20 8v6M23 11h-6"/>
                        </svg>

                        Applications

                    </a>


                    <a href="{{ route('company.profile') }}"
                       class="sidebar-link">

                        <svg class="w-5 h-5" fill="none"
                             stroke="currentColor" viewBox="0 0 24 24">
                            <rect x="3" y="4" width="18" height="16" rx="2"/>
                            <circle cx="9" cy="10" r="2"/>
                            <path d="M6 16c0-2 1.5-3 3-3s3 1 3 3M15 9h3M15 13h3"/>
                        </svg>

                        Company Profile

                    </a>

                </nav>


                <!-- Account Section -->
                <div class="mt-10">

                    <p class="px-3 text-[11px] font-semibold
                              uppercase tracking-[0.15em]
                              text-slate-500 mb-4">

                        Account

                    </p>

                    <form action="/company/logout" method="POST">

                        @csrf

                        <button type="submit"
                                class="sidebar-link w-full text-left">

                            <svg class="w-5 h-5" fill="none"
                                 stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M10 17l5-5-5-5M15 12H3"/>
                                <path d="M12 3h6a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-6"/>
                            </svg>

                            Sign out

                        </button>

                    </form>

                </div>

            </div>


            <!-- Sidebar Footer -->
            <div class="p-5 border-t border-white/10">

                <p class="text-xs text-slate-500">
                    © {{ date('Y') }} JobPortal
                </p>

                <p class="text-xs text-slate-400 mt-1">
                    Employer Workspace
                </p>

            </div>

        </aside>



        <!-- Main Content -->
        <div class="flex-1 min-w-0">


            <!-- Top Navbar -->
            <header class="h-20 bg-white border-b border-slate-200
                           px-5 sm:px-8 flex items-center
                           justify-between sticky top-0 z-40">

                <!-- Mobile Logo -->
                <a href="/company/dashboard"
                   class="lg:hidden text-xl font-bold">

                    Job<span class="text-blue-600">Portal</span>

                </a>


                <div class="hidden lg:block">

                    <p class="text-sm font-medium text-slate-800">
                        Employer Workspace
                    </p>

                    <p class="text-xs text-slate-400 mt-1">
                        Manage your recruitment activities
                    </p>

                </div>


                <!-- Account Info -->
                <div class="flex items-center gap-3 sm:gap-4">

                    <div class="hidden sm:block text-right">

                        <p class="text-sm font-semibold text-slate-800">
                            {{ session('company_name') }}
                        </p>

                        <p class="text-xs text-slate-400 mt-1">
                            Company Account
                        </p>

                    </div>


                    <div class="w-10 h-10 rounded-full
                                bg-blue-50 border border-blue-100
                                flex items-center justify-center
                                text-blue-700 font-semibold">

                        {{ strtoupper(substr(session('company_name'), 0, 1)) }}

                    </div>


                    <!-- Mobile Logout -->
                    <form action="/company/logout" method="POST"
                          class="lg:hidden">

                        @csrf

                        <button type="submit"
                                class="text-sm font-medium text-red-600
                                       border border-red-200 rounded-lg
                                       px-3 py-2">

                            Logout

                        </button>

                    </form>

                </div>

            </header>



            <!-- Dashboard Body -->
            <main class="max-w-[1500px] mx-auto px-5 sm:px-8 py-9">


                <!-- Page Heading -->
                <div class="flex flex-col sm:flex-row
                            sm:items-center sm:justify-between gap-5 mb-9">

                    <div>

                        <p class="text-xs font-semibold
                                  uppercase tracking-[0.15em]
                                  text-blue-600 mb-3">

                            OVERVIEW

                        </p>

                        <h1 class="text-2xl sm:text-3xl
                                   font-semibold tracking-tight
                                   text-slate-900">

                            Dashboard

                        </h1>

                        <p class="text-sm text-slate-500 mt-2">

                            Welcome back, {{ session('company_name') }}.
                            Here's your recruitment overview.

                        </p>

                    </div>


                    <a href="/company/job/create"
                       class="inline-flex items-center justify-center
                              gap-2 bg-blue-600 hover:bg-blue-700
                              text-white text-sm font-semibold
                              px-5 py-3 rounded-lg transition">

                        <svg class="w-4 h-4" fill="none"
                             stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M12 5v14M5 12h14"/>
                        </svg>

                        Post a new job

                    </a>

                </div>



                <!-- Statistics -->
                <div class="grid grid-cols-1 sm:grid-cols-2
                            xl:grid-cols-3 gap-5 mb-10">


                    <!-- Total Jobs -->
                    <div class="bg-white border border-slate-200
                                rounded-xl p-6">

                        <div class="flex items-start justify-between">

                            <div>

                                <p class="text-sm text-slate-500 font-medium">
                                    Total job postings
                                </p>

                                <h2 class="text-3xl font-semibold
                                           text-slate-900 mt-4">

                                    {{ $totalJobs }}

                                </h2>

                                <p class="text-xs text-slate-400 mt-2">
                                    Jobs created by your company
                                </p>

                            </div>


                            <div class="w-11 h-11 rounded-lg
                                        bg-blue-50 text-blue-600
                                        flex items-center justify-center">

                                <svg class="w-5 h-5" fill="none"
                                     stroke="currentColor" viewBox="0 0 24 24">
                                    <rect x="3" y="7" width="18" height="14" rx="2"/>
                                    <path d="M8 7V4h8v3M3 12h18"/>
                                </svg>

                            </div>

                        </div>

                    </div>



                    <!-- Applications -->
                    <div class="bg-white border border-slate-200
                                rounded-xl p-6">

                        <div class="flex items-start justify-between">

                            <div>

                                <p class="text-sm text-slate-500 font-medium">
                                    Total applications
                                </p>

                                <h2 class="text-3xl font-semibold
                                           text-slate-900 mt-4">

                                    0

                                </h2>

                                <p class="text-xs text-slate-400 mt-2">
                                    Candidate applications
                                </p>

                            </div>


                            <div class="w-11 h-11 rounded-lg
                                        bg-emerald-50 text-emerald-600
                                        flex items-center justify-center">

                                <svg class="w-5 h-5" fill="none"
                                     stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                                    <circle cx="9" cy="7" r="4"/>
                                    <path d="M20 8v6M23 11h-6"/>
                                </svg>

                            </div>

                        </div>

                    </div>



                    <!-- Company Status -->
                    <div class="bg-white border border-slate-200
                                rounded-xl p-6">

                        <div class="flex items-start justify-between">

                            <div>

                                <p class="text-sm text-slate-500 font-medium">
                                    Account status
                                </p>

                                <h2 class="text-xl font-semibold
                                           text-emerald-600 mt-4">

                                    Approved

                                </h2>

                                <p class="text-xs text-slate-400 mt-2">
                                    Company verification status
                                </p>

                            </div>


                            <div class="w-11 h-11 rounded-lg
                                        bg-emerald-50 text-emerald-600
                                        flex items-center justify-center">

                                <svg class="w-5 h-5" fill="none"
                                     stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="M5 12l4 4L19 6"/>
                                    <circle cx="12" cy="12" r="10"/>
                                </svg>

                            </div>

                        </div>

                    </div>

                </div>



                <!-- Quick Actions -->
                <section class="mb-10">

                    <div class="mb-6">

                        <h2 class="text-lg font-semibold text-slate-900">
                            Recruitment management
                        </h2>

                        <p class="text-sm text-slate-500 mt-1">
                            Access the tools you need to manage hiring.
                        </p>

                    </div>


                    <div class="grid grid-cols-1 sm:grid-cols-2
                                xl:grid-cols-4 gap-5">


                        <!-- Post Job -->
                        <a href="/company/job/create"
                           class="action-card group">

                            <div class="action-icon bg-blue-50 text-blue-600">

                                <svg class="w-6 h-6" fill="none"
                                     stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 5v14M5 12h14"/>
                                </svg>

                            </div>

                            <h3 class="font-semibold text-slate-900">
                                Post a new job
                            </h3>

                            <p class="text-sm text-slate-500 mt-2 leading-6">
                                Create and publish a new job opening.
                            </p>

                            <div class="mt-5 text-sm font-semibold text-blue-600
                                        flex items-center gap-2">

                                Create job

                                <span class="transition group-hover:translate-x-1">
                                    →
                                </span>

                            </div>

                        </a>



                        <!-- Manage Jobs -->
                        <a href="{{ route('company.jobs') }}"
                           class="action-card group">

                            <div class="action-icon bg-violet-50 text-violet-600">

                                <svg class="w-6 h-6" fill="none"
                                     stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="M4 5h16M4 10h16M4 15h10M4 20h10"/>
                                </svg>

                            </div>

                            <h3 class="font-semibold text-slate-900">
                                Manage jobs
                            </h3>

                            <p class="text-sm text-slate-500 mt-2 leading-6">
                                Review and manage your published jobs.
                            </p>

                            <div class="mt-5 text-sm font-semibold text-violet-600
                                        flex items-center gap-2">

                                View jobs

                                <span class="transition group-hover:translate-x-1">
                                    →
                                </span>

                            </div>

                        </a>



                        <!-- Applications -->
                        <a href="#"
                           class="action-card group">

                            <div class="action-icon bg-emerald-50 text-emerald-600">

                                <svg class="w-6 h-6" fill="none"
                                     stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                                    <circle cx="9" cy="7" r="4"/>
                                    <path d="M20 8v6M23 11h-6"/>
                                </svg>

                            </div>

                            <h3 class="font-semibold text-slate-900">
                                Applications
                            </h3>

                            <p class="text-sm text-slate-500 mt-2 leading-6">
                                Review applications from candidates.
                            </p>

                            <div class="mt-5 text-sm font-semibold text-emerald-600
                                        flex items-center gap-2">

                                View applications

                                <span class="transition group-hover:translate-x-1">
                                    →
                                </span>

                            </div>

                        </a>



                        <!-- Profile -->
                        <a href="{{ route('company.profile') }}"
                           class="action-card group">

                            <div class="action-icon bg-orange-50 text-orange-600">

                                <svg class="w-6 h-6" fill="none"
                                     stroke="currentColor" viewBox="0 0 24 24">
                                    <rect x="3" y="4" width="18" height="16" rx="2"/>
                                    <circle cx="9" cy="10" r="2"/>
                                    <path d="M6 16c0-2 1.5-3 3-3s3 1 3 3M15 9h3"/>
                                </svg>

                            </div>

                            <h3 class="font-semibold text-slate-900">
                                Company profile
                            </h3>

                            <p class="text-sm text-slate-500 mt-2 leading-6">
                                Update your organization information.
                            </p>

                            <div class="mt-5 text-sm font-semibold text-orange-600
                                        flex items-center gap-2">

                                View profile

                                <span class="transition group-hover:translate-x-1">
                                    →
                                </span>

                            </div>

                        </a>

                    </div>

                </section>



                <!-- Recruitment CTA -->
                <section class="bg-white border border-slate-200
                                rounded-xl p-6 sm:p-8">

                    <div class="flex flex-col md:flex-row
                                md:items-center md:justify-between gap-6">

                        <div>

                            <h2 class="text-lg font-semibold text-slate-900">
                                Ready to grow your team?
                            </h2>

                            <p class="text-sm text-slate-500 mt-2">
                                Publish your next job opening and connect
                                with potential candidates.
                            </p>

                        </div>


                        <a href="/company/job/create"
                           class="inline-flex items-center justify-center
                                  gap-2 bg-slate-900 hover:bg-slate-700
                                  text-white text-sm font-semibold
                                  px-6 py-3 rounded-lg transition">

                            Create job posting

                            <span>→</span>

                        </a>

                    </div>

                </section>


                <!-- Footer -->
                <footer class="mt-12 pt-6 border-t border-slate-200">

                    <p class="text-xs text-slate-400 text-center">
                        © {{ date('Y') }} JobPortal. All rights reserved.
                    </p>

                </footer>


            </main>

        </div>

    </div>


    <!-- Custom Styles -->
    <style>

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px;
            border-radius: 8px;
            color: #9ca3af;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .sidebar-link:hover {
            background: rgba(255, 255, 255, 0.07);
            color: #ffffff;
        }

        .action-card {
            display: block;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 24px;
            transition: border-color 0.2s ease,
                        transform 0.2s ease;
        }

        .action-card:hover {
            border-color: #93c5fd;
            transform: translateY(-3px);
        }

        .action-icon {
            width: 48px;
            height: 48px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
        }

    </style>

</body>
</html>