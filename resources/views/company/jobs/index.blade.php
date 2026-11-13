<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Manage Jobs | JobPortal</title>

    @vite('resources/css/app.css')

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: Inter, sans-serif;
        }

        .hero-bg {
            background: linear-gradient(115deg, #0f172a, #172554 60%, #1d4ed8);
        }

        .stat-card {
            transition: all .25s ease;
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 25px rgba(15, 23, 42, .07);
        }

        .job-row {
            transition: background .2s ease;
        }

        .job-row:hover {
            background: #f8fbff;
        }

        .action-btn {
            transition: all .2s ease;
        }
    </style>
</head>

<body class="bg-slate-50 text-slate-800 min-h-screen">

    <!-- NAVBAR -->
    <header class="bg-white border-b border-slate-200 sticky top-0 z-50">

        <div class="w-full px-5 lg:px-10 xl:px-14 h-20
                    flex items-center justify-between">

            <!-- LOGO -->
            <a href="{{ route('company.dashboard') }}"
               class="flex items-center gap-3">

                <div class="w-12 h-12 rounded-xl bg-blue-600
                            flex items-center justify-center
                            text-white text-2xl font-bold shadow-lg">
                    J
                </div>

                <div>
                    <h1 class="text-2xl font-bold text-slate-900">
                        Job<span class="text-blue-600">Portal</span>
                    </h1>

                    <!-- <p class="text-xs text-slate-400 tracking-widest font-semibold">
                        EMPLOYER PORTAL
                    </p> -->
                </div>

            </a>


            <!-- NAV ACTION -->
            <div class="flex items-center gap-3">

                <span class="hidden md:block text-sm text-slate-500">
                    Job Management
                </span>

                <a href="/company/job/create"
                   class="inline-flex items-center gap-2
                          bg-blue-600 hover:bg-blue-700
                          text-white px-5 py-3 rounded-xl
                          font-semibold text-sm transition shadow-sm">

                    <svg class="w-5 h-5" fill="none"
                         stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M12 5v14m-7-7h14"/>
                    </svg>

                    Post New Job

                </a>

            </div>

        </div>

    </header>


    <!-- MAIN -->
    <main class="w-full px-5 lg:px-10 xl:px-14 py-9">


        <!-- PAGE HEADER -->
        <section class="flex flex-col lg:flex-row
                        lg:items-center lg:justify-between
                        gap-5 mb-9">

            <div>

                <div class="flex items-center gap-2 text-sm mb-3">

                    <a href="{{ route('company.dashboard') }}"
                       class="text-slate-400 hover:text-blue-600">
                        Dashboard
                    </a>

                    <span class="text-slate-300">/</span>

                    <span class="text-blue-600 font-semibold">
                        Manage Jobs
                    </span>

                </div>

                <!-- <p class="text-xs font-bold tracking-widest
                          text-blue-600 uppercase mb-2">
                    Employer Workspace
                </p> -->

                <!-- <h2 class="text-3xl lg:text-4xl font-bold text-slate-900">
                    Manage Jobs
                </h2> -->

                <p class="text-slate-500 mt-2">
                    Track, manage and update your company's job listings.
                </p>

            </div>


            <a href="/company/job/create"
               class="inline-flex items-center justify-center gap-2
                      bg-slate-900 hover:bg-blue-700
                      text-white px-6 py-3.5 rounded-xl
                      font-semibold transition">

                <svg class="w-5 h-5" fill="none"
                     stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M12 5v14m-7-7h14"/>
                </svg>

                Create New Job

            </a>

        </section>



        <!-- SUCCESS MESSAGE -->
        @if(session('success'))

            <div class="mb-7 flex items-center gap-4
                        bg-green-50 border border-green-200
                        text-green-800 px-5 py-4 rounded-xl">

                <div class="w-10 h-10 rounded-full bg-green-100
                            flex items-center justify-center shrink-0">

                    <svg class="w-5 h-5" fill="none"
                         stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M5 13l4 4L19 7"/>
                    </svg>

                </div>

                <p class="font-semibold text-sm">
                    {{ session('success') }}
                </p>

            </div>

        @endif



        <!-- STATISTICS -->
        <section class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6 mb-9">


            <!-- TOTAL JOBS -->
            <div class="stat-card bg-white border border-slate-200
                        rounded-2xl p-6">

                <div class="flex items-center justify-between">

                    <div>
                        <p class="text-sm font-medium text-slate-500">
                            Total Jobs Posted
                        </p>

                        <h3 class="text-4xl font-bold text-slate-900 mt-3">
                            {{ $jobs->count() }}
                        </h3>

                        <p class="text-xs text-slate-400 mt-2">
                            All company listings
                        </p>
                    </div>

                    <div class="w-14 h-14 rounded-2xl bg-blue-50
                                text-blue-600 flex items-center justify-center">

                        <svg class="w-7 h-7" fill="none"
                             stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="1.8"
                                  d="M4 7h16M4 12h16M4 17h10"/>
                        </svg>

                    </div>

                </div>

            </div>



            <!-- ACTIVE JOBS -->
            <div class="stat-card bg-white border border-slate-200
                        rounded-2xl p-6">

                <div class="flex items-center justify-between">

                    <div>
                        <p class="text-sm font-medium text-slate-500">
                            Active Listings
                        </p>

                        <h3 class="text-4xl font-bold text-emerald-600 mt-3">
                            {{ $jobs->count() }}
                        </h3>

                        <p class="text-xs text-slate-400 mt-2">
                            Currently listed jobs
                        </p>
                    </div>

                    <div class="w-14 h-14 rounded-2xl bg-emerald-50
                                text-emerald-600 flex items-center justify-center">

                        <svg class="w-7 h-7" fill="none"
                             stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="1.8"
                                  d="M9 12l2 2 4-4m5-3v5a9 9 0 11-18 0V7l9-4 9 4z"/>
                        </svg>

                    </div>

                </div>

            </div>



            <!-- VACANCIES -->
            <div class="stat-card bg-white border border-slate-200
                        rounded-2xl p-6">

                <div class="flex items-center justify-between">

                    <div>
                        <p class="text-sm font-medium text-slate-500">
                            Total Vacancies
                        </p>

                        <h3 class="text-4xl font-bold text-indigo-600 mt-3">
                            {{ $jobs->sum('vacancy') }}
                        </h3>

                        <p class="text-xs text-slate-400 mt-2">
                            Available positions
                        </p>
                    </div>

                    <div class="w-14 h-14 rounded-2xl bg-indigo-50
                                text-indigo-600 flex items-center justify-center">

                        <svg class="w-7 h-7" fill="none"
                             stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="1.8"
                                  d="M16 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2m12-13a4 4 0 11-8 0 4 4 0 018 0zm2 4a4 4 0 014 4v2"/>
                        </svg>

                    </div>

                </div>

            </div>

        </section>



        <!-- JOB MANAGEMENT TABLE -->
        <section class="bg-white border border-slate-200
                        rounded-2xl overflow-hidden">


            <!-- TABLE HEADER -->
            <div class="px-6 lg:px-8 py-6
                        border-b border-slate-200
                        flex flex-col sm:flex-row
                        sm:items-center sm:justify-between gap-4">

                <div>

                    <h3 class="text-xl font-bold text-slate-900">
                        Posted Jobs
                    </h3>

                    <p class="text-sm text-slate-400 mt-1">
                        Manage all your published job opportunities.
                    </p>

                </div>


                <div class="inline-flex items-center gap-2
                            bg-blue-50 text-blue-700
                            border border-blue-100
                            px-4 py-2 rounded-lg text-sm font-semibold">

                    <span class="w-2 h-2 rounded-full bg-blue-500"></span>

                    {{ $jobs->count() }} Total Jobs

                </div>

            </div>



            <!-- TABLE -->
            <div class="overflow-x-auto">

                <table class="w-full min-w-[1000px]">

                    <thead class="bg-slate-50 border-b border-slate-200">

                        <tr>

                            <th class="text-left px-7 py-5 text-xs
                                       font-bold uppercase tracking-wider
                                       text-slate-500">
                                Job Details
                            </th>

                            <th class="text-left px-6 py-5 text-xs
                                       font-bold uppercase tracking-wider
                                       text-slate-500">
                                Location
                            </th>

                            <th class="text-left px-6 py-5 text-xs
                                       font-bold uppercase tracking-wider
                                       text-slate-500">
                                Salary
                            </th>

                            <th class="text-left px-6 py-5 text-xs
                                       font-bold uppercase tracking-wider
                                       text-slate-500">
                                Vacancies
                            </th>

                            <th class="text-left px-6 py-5 text-xs
                                       font-bold uppercase tracking-wider
                                       text-slate-500">
                                Deadline
                            </th>

                            <th class="text-right px-7 py-5 text-xs
                                       font-bold uppercase tracking-wider
                                       text-slate-500">
                                Actions
                            </th>

                        </tr>

                    </thead>



                    <tbody class="divide-y divide-slate-100">


                        @forelse($jobs as $job)

                            <tr class="job-row">


                                <!-- JOB TITLE -->
                                <td class="px-7 py-6">

                                    <div class="flex items-center gap-4">

                                        <div class="w-12 h-12 rounded-xl
                                                    bg-blue-50 text-blue-700
                                                    flex items-center justify-center
                                                    text-lg font-bold shrink-0">

                                            {{ strtoupper(substr($job->job_title, 0, 1)) }}

                                        </div>

                                        <div>

                                            <h4 class="font-bold text-slate-900 text-base">
                                                {{ $job->job_title }}
                                            </h4>

                                            <p class="text-xs text-slate-400 mt-1">
                                                Job Opening
                                            </p>

                                        </div>

                                    </div>

                                </td>



                                <!-- LOCATION -->
                                <td class="px-6 py-6">

                                    <div class="flex items-center gap-2 text-slate-600">

                                        <svg class="w-4 h-4 text-blue-500 shrink-0"
                                             fill="none" stroke="currentColor"
                                             viewBox="0 0 24 24">

                                            <path stroke-linecap="round"
                                                  stroke-linejoin="round"
                                                  stroke-width="1.8"
                                                  d="M20 10c0 5-8 11-8 11S4 15 4 10a8 8 0 1116 0z"/>

                                            <circle cx="12" cy="10" r="2.5"
                                                    stroke-width="1.8"/>

                                        </svg>

                                        <span class="text-sm font-medium">
                                            {{ $job->location }}
                                        </span>

                                    </div>

                                </td>



                                <!-- SALARY -->
                                <td class="px-6 py-6">

                                    <span class="text-sm font-bold text-slate-800">
                                        {{ $job->salary }}
                                    </span>

                                </td>



                                <!-- VACANCY -->
                                <td class="px-6 py-6">

                                    <span class="inline-flex items-center
                                                 bg-blue-50 text-blue-700
                                                 border border-blue-100
                                                 px-3 py-2 rounded-lg
                                                 text-xs font-bold">

                                        {{ $job->vacancy }} Openings

                                    </span>

                                </td>



                                <!-- DEADLINE -->
                                <td class="px-6 py-6">

                                    <span class="text-sm text-slate-600 font-medium">
                                        {{ $job->deadline }}
                                    </span>

                                </td>



                                <!-- ACTIONS -->
                                <td class="px-7 py-6">

                                    <div class="flex justify-end items-center gap-2">


                                        <!-- EDIT -->
                                        <a href="{{ route('job.edit', $job->id) }}"
                                           class="action-btn inline-flex items-center
                                                  gap-2 bg-amber-50 text-amber-700
                                                  border border-amber-200
                                                  px-4 py-2.5 rounded-lg
                                                  text-sm font-semibold
                                                  hover:bg-amber-100">

                                            <svg class="w-4 h-4" fill="none"
                                                 stroke="currentColor"
                                                 viewBox="0 0 24 24">

                                                <path stroke-linecap="round"
                                                      stroke-linejoin="round"
                                                      stroke-width="1.8"
                                                      d="M16.862 4.487l1.687-1.688a2.121 2.121 0 013 3l-1.688 1.688M16.862 4.487L7.5 13.85l-1 4 4-1 9.362-9.363"/>

                                            </svg>

                                            Edit

                                        </a>



                                        <!-- DELETE -->
                                        <form action="{{ route('job.delete', $job->id) }}"
                                              method="POST"
                                              onsubmit="return confirm('Are you sure you want to delete this job?')">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    class="action-btn inline-flex items-center
                                                           gap-2 bg-red-50 text-red-600
                                                           border border-red-200
                                                           px-4 py-2.5 rounded-lg
                                                           text-sm font-semibold
                                                           hover:bg-red-100">

                                                <svg class="w-4 h-4" fill="none"
                                                     stroke="currentColor"
                                                     viewBox="0 0 24 24">

                                                    <path stroke-linecap="round"
                                                          stroke-linejoin="round"
                                                          stroke-width="1.8"
                                                          d="M4 7h16m-10 4v6m4-6v6M5 7l1 14h12l1-14M9 7V4h6v3"/>

                                                </svg>

                                                Delete

                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>


                        @empty


                            <!-- EMPTY STATE -->
                            <tr>

                                <td colspan="6" class="px-6 py-20">

                                    <div class="text-center max-w-lg mx-auto">

                                        <div class="w-20 h-20 mx-auto rounded-2xl
                                                    bg-slate-100 text-slate-400
                                                    flex items-center justify-center">

                                            <svg class="w-10 h-10" fill="none"
                                                 stroke="currentColor"
                                                 viewBox="0 0 24 24">

                                                <path stroke-linecap="round"
                                                      stroke-linejoin="round"
                                                      stroke-width="1.5"
                                                      d="M4 7h16M4 12h16M4 17h10"/>

                                            </svg>

                                        </div>

                                        <h3 class="text-xl font-bold text-slate-900 mt-6">
                                            No Jobs Found
                                        </h3>

                                        <p class="text-slate-500 text-sm mt-2 leading-6">
                                            You haven't posted any job opportunities yet.
                                            Create your first job listing to start hiring.
                                        </p>

                                        <a href="/company/job/create"
                                           class="inline-flex items-center gap-2
                                                  mt-7 bg-blue-600 hover:bg-blue-700
                                                  text-white px-6 py-3 rounded-xl
                                                  font-semibold transition">

                                            <svg class="w-5 h-5" fill="none"
                                                 stroke="currentColor"
                                                 viewBox="0 0 24 24">
                                                <path stroke-linecap="round"
                                                      stroke-linejoin="round"
                                                      stroke-width="2"
                                                      d="M12 5v14m-7-7h14"/>
                                            </svg>

                                            Post Your First Job

                                        </a>

                                    </div>

                                </td>

                            </tr>


                        @endforelse


                    </tbody>

                </table>

            </div>



            <!-- TABLE FOOTER -->
            @if($jobs->count() > 0)

                <div class="px-6 lg:px-8 py-5
                            border-t border-slate-100
                            flex flex-col sm:flex-row
                            sm:items-center sm:justify-between gap-3">

                    <p class="text-sm text-slate-500">
                        Showing
                        <span class="font-bold text-slate-800">
                            {{ $jobs->count() }}
                        </span>
                        job listings
                    </p>

                    <a href="/company/job/create"
                       class="text-sm text-blue-600 hover:text-blue-800
                              font-semibold transition">

                        Create Another Job

                    </a>

                </div>

            @endif

        </section>

    </main>



    <!-- FOOTER -->
    <footer class="bg-white border-t border-slate-200 mt-12">

        <div class="w-full px-5 lg:px-10 xl:px-14 py-7
                    flex flex-col md:flex-row
                    items-center justify-between gap-3">

            <p class="text-sm text-slate-500">
                © {{ date('Y') }} JobPortal. All rights reserved.
            </p>

            <p class="text-sm text-slate-400">
                Employer Job Management
            </p>

        </div>

    </footer>

</body>
</html>
