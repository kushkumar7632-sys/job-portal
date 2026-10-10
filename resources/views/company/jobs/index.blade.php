<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Manage Jobs | JobPortal</title>

    @vite('resources/css/app.css')
</head>

<body class="bg-slate-50 text-slate-800">

<!-- ================= HEADER ================= -->
<header class="bg-white border-b border-slate-200 sticky top-0 z-50">

    <div class="max-w-7xl mx-auto px-6 py-4">

        <div class="flex items-center justify-between">

            <!-- Logo -->
            <div class="flex items-center gap-3">

                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-600 to-indigo-600
                            flex items-center justify-center text-white font-bold text-lg shadow">
                    J
                </div>

                <div>
                    <h1 class="text-xl font-bold text-slate-900">
                        JobPortal
                    </h1>

                    <p class="text-xs text-slate-500">
                        Employer Dashboard
                    </p>
                </div>

            </div>


            <!-- Actions -->
            <div class="flex items-center gap-3">

                <a href="/company/job/create"
                   class="hidden sm:inline-flex items-center gap-2
                          bg-gradient-to-r from-blue-600 to-indigo-600
                          text-white px-5 py-2.5 rounded-xl
                          font-semibold shadow-sm
                          hover:from-blue-700 hover:to-indigo-700
                          transition">

                    <span class="text-lg">+</span>
                    Post New Job

                </a>

            </div>

        </div>

    </div>

</header>


<!-- ================= MAIN ================= -->
<main class="max-w-7xl mx-auto px-6 py-10">

    <!-- Page Heading -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-5 mb-8">

        <div>

            <p class="text-sm font-semibold text-blue-600 uppercase tracking-wide">
                Employer Panel
            </p>

            <h2 class="text-3xl md:text-4xl font-bold text-slate-900 mt-1">
                My Jobs
            </h2>

            <p class="text-slate-500 mt-2">
                Manage your posted jobs, update details or remove expired listings.
            </p>

        </div>


        <!-- Mobile Post Button -->
        <a href="/company/job/create"
           class="sm:hidden inline-flex justify-center items-center gap-2
                  bg-gradient-to-r from-blue-600 to-indigo-600
                  text-white px-5 py-3 rounded-xl
                  font-semibold shadow-sm">

            <span class="text-lg">+</span>
            Post New Job

        </a>

    </div>


    <!-- ================= SUCCESS MESSAGE ================= -->
    @if(session('success'))

        <div class="mb-6 flex items-center gap-3
                    bg-green-50 border border-green-200
                    text-green-700 px-5 py-4 rounded-xl">

            <div class="w-9 h-9 rounded-full bg-green-100
                        flex items-center justify-center font-bold">
                ✓
            </div>

            <p class="font-medium">
                {{ session('success') }}
            </p>

        </div>

    @endif


    <!-- ================= JOB SUMMARY ================= -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-8">

        <div class="bg-white border border-slate-200 rounded-2xl p-5">

            <p class="text-sm text-slate-500">
                Total Jobs
            </p>

            <h3 class="text-3xl font-bold text-slate-900 mt-2">
                {{ $jobs->count() }}
            </h3>

        </div>


        <div class="bg-white border border-slate-200 rounded-2xl p-5">

            <p class="text-sm text-slate-500">
                Active Listings
            </p>

            <h3 class="text-3xl font-bold text-green-600 mt-2">
                {{ $jobs->count() }}
            </h3>

        </div>


        <div class="bg-white border border-slate-200 rounded-2xl p-5">

            <p class="text-sm text-slate-500">
                Hiring Opportunities
            </p>

            <h3 class="text-3xl font-bold text-blue-600 mt-2">
                {{ $jobs->sum('vacancy') }}
            </h3>

        </div>

    </div>


    <!-- ================= JOB TABLE ================= -->
    <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden">

        <!-- Table Header -->
        <div class="px-6 py-5 border-b border-slate-200">

            <div class="flex items-center justify-between">

                <div>

                    <h3 class="text-lg font-bold text-slate-900">
                        Posted Jobs
                    </h3>

                    <p class="text-sm text-slate-500 mt-1">
                        All jobs posted by your company
                    </p>

                </div>

                <span class="hidden sm:block text-sm text-slate-500">
                    {{ $jobs->count() }} jobs
                </span>

            </div>

        </div>


        <!-- Responsive Table -->
        <div class="overflow-x-auto">

            <table class="w-full min-w-[900px]">

                <thead class="bg-slate-50 border-b border-slate-200">

                    <tr>

                        <th class="text-left px-6 py-4 text-xs font-bold
                                   text-slate-500 uppercase tracking-wider">
                            Job
                        </th>

                        <th class="text-left px-6 py-4 text-xs font-bold
                                   text-slate-500 uppercase tracking-wider">
                            Location
                        </th>

                        <th class="text-left px-6 py-4 text-xs font-bold
                                   text-slate-500 uppercase tracking-wider">
                            Salary
                        </th>

                        <th class="text-left px-6 py-4 text-xs font-bold
                                   text-slate-500 uppercase tracking-wider">
                            Vacancy
                        </th>

                        <th class="text-left px-6 py-4 text-xs font-bold
                                   text-slate-500 uppercase tracking-wider">
                            Deadline
                        </th>

                        <th class="text-right px-6 py-4 text-xs font-bold
                                   text-slate-500 uppercase tracking-wider">
                            Action
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-slate-100">

                    @forelse($jobs as $job)

                    <tr class="hover:bg-slate-50 transition">


                        <!-- Job -->
                        <td class="px-6 py-5">

                            <div class="flex items-center gap-4">

                                <div class="w-11 h-11 rounded-xl
                                            bg-blue-50 text-blue-600
                                            flex items-center justify-center
                                            font-bold">

                                    {{ strtoupper(substr($job->job_title, 0, 1)) }}

                                </div>


                                <div>

                                    <h4 class="font-bold text-slate-900">
                                        {{ $job->job_title }}
                                    </h4>

                                    <p class="text-sm text-slate-500 mt-1">
                                        Job Opening
                                    </p>

                                </div>

                            </div>

                        </td>


                        <!-- Location -->
                        <td class="px-6 py-5">

                            <div class="flex items-center gap-2 text-slate-600">

                                <span class="text-blue-600">📍</span>

                                <span>
                                    {{ $job->location }}
                                </span>

                            </div>

                        </td>


                        <!-- Salary -->
                        <td class="px-6 py-5">

                            <span class="font-semibold text-slate-800">
                                {{ $job->salary }}
                            </span>

                        </td>


                        <!-- Vacancy -->
                        <td class="px-6 py-5">

                            <span class="inline-flex items-center
                                         bg-blue-50 text-blue-700
                                         px-3 py-1 rounded-full
                                         text-sm font-semibold">

                                {{ $job->vacancy }} Openings

                            </span>

                        </td>


                        <!-- Deadline -->
                        <td class="px-6 py-5">

                            <span class="text-slate-600">
                                {{ $job->deadline }}
                            </span>

                        </td>


                        <!-- Actions -->
                        <td class="px-6 py-5">

                            <div class="flex justify-end items-center gap-2">


                                <!-- Edit -->
                                <a href="{{ route('job.edit', $job->id) }}"
                                   class="inline-flex items-center gap-2
                                          bg-amber-50 text-amber-700
                                          border border-amber-200
                                          px-4 py-2 rounded-lg
                                          font-semibold text-sm
                                          hover:bg-amber-100 transition">

                                    ✏️
                                    Edit

                                </a>


                                <!-- Delete -->
                                <form action="{{ route('job.delete', $job->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('Are you sure you want to delete this job?')"
                                      class="inline">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="inline-flex items-center gap-2
                                                   bg-red-50 text-red-600
                                                   border border-red-200
                                                   px-4 py-2 rounded-lg
                                                   font-semibold text-sm
                                                   hover:bg-red-100 transition">

                                        🗑
                                        Delete

                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>


                    @empty

                    <!-- Empty State -->
                    <tr>

                        <td colspan="6" class="px-6 py-16">

                            <div class="text-center">

                                <div class="w-16 h-16 mx-auto rounded-2xl
                                            bg-slate-100
                                            flex items-center justify-center
                                            text-3xl">
                                    💼
                                </div>

                                <h3 class="text-xl font-bold text-slate-900 mt-5">
                                    No jobs posted yet
                                </h3>

                                <p class="text-slate-500 mt-2 max-w-md mx-auto">
                                    Start hiring by posting your first job opportunity.
                                </p>

                                <a href="/company/job/create"
                                   class="inline-flex items-center gap-2
                                          mt-6
                                          bg-gradient-to-r from-blue-600 to-indigo-600
                                          text-white px-6 py-3 rounded-xl
                                          font-semibold shadow-sm
                                          hover:from-blue-700 hover:to-indigo-700
                                          transition">

                                    <span class="text-lg">+</span>
                                    Post Your First Job

                                </a>

                            </div>

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</main>


<!-- ================= FOOTER ================= -->
<footer class="border-t border-slate-200 bg-white mt-12">

    <div class="max-w-7xl mx-auto px-6 py-6">

        <div class="flex flex-col sm:flex-row
                    items-center justify-between gap-3">

            <p class="text-sm text-slate-500">
                © {{ date('Y') }} JobPortal. All rights reserved.
            </p>

            <p class="text-sm text-slate-400">
                Employer Job Management
            </p>

        </div>

    </div>

</footer>

</body>
</html>