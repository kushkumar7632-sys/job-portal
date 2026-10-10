<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Available Jobs | JobPortal</title>

    @vite('resources/css/app.css')

</head>


<body class="bg-slate-50 text-slate-800 min-h-screen">


<!-- ================= NAVBAR ================= -->

<nav class="bg-white border-b border-slate-200 sticky top-0 z-50">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="h-16 flex items-center justify-between">


            <!-- Logo -->

            <a href="{{ route('student.jobs') }}"
               class="flex items-center gap-2">

                <div class="w-9 h-9 bg-blue-600
                            rounded-lg
                            flex items-center justify-center">

                    <span class="text-white font-bold text-lg">
                        J
                    </span>

                </div>

                <span class="text-xl font-bold text-slate-900">

                    Job<span class="text-blue-600">Portal</span>

                </span>

            </a>


            <!-- Right -->

            <div class="flex items-center gap-3">


                <div class="hidden sm:block text-right">

                    <p class="text-xs text-slate-400">
                        Welcome back
                    </p>

                    <p class="text-sm font-semibold text-slate-700">

                        {{ session('student_name') }}

                    </p>

                </div>


                <!-- Avatar -->

                <div class="w-10 h-10 rounded-full
                            bg-blue-100 text-blue-600
                            flex items-center justify-center
                            font-bold">

                    {{ strtoupper(substr(session('student_name'), 0, 1)) }}

                </div>


                <!-- Dashboard -->

                <a href="{{ route('student.dashboard') }}"
                   class="hidden sm:inline-flex
                          items-center
                          bg-blue-600 hover:bg-blue-700
                          text-white
                          px-4 py-2
                          rounded-lg
                          font-medium
                          transition">

                    Dashboard

                </a>

            </div>

        </div>

    </div>

</nav>



<!-- ================= MAIN ================= -->

<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">


    <!-- Header -->

    <div class="flex flex-col md:flex-row
                md:items-end
                md:justify-between
                gap-4 mb-8">


        <div>

            <div class="flex items-center gap-2
                        text-sm text-slate-500 mb-2">

                <a href="{{ route('student.dashboard') }}"
                   class="hover:text-blue-600">

                    Dashboard

                </a>

                <span>›</span>

                <span>Available Jobs</span>

            </div>


            <h1 class="text-3xl md:text-4xl
                       font-bold text-slate-900">

                Find your next opportunity

            </h1>


            <p class="text-slate-500 mt-2">

                Explore available jobs and find the right role
                for your career.

            </p>

        </div>


        <!-- Job Count -->

        @if($jobs->count() > 0)

            <div class="inline-flex items-center
                        gap-2
                        bg-white
                        border border-slate-200
                        px-4 py-2.5
                        rounded-xl
                        shadow-sm
                        text-sm">

                <span class="w-2.5 h-2.5
                             bg-green-500
                             rounded-full">
                </span>

                <span class="text-slate-500">
                    {{ $jobs->count() }} jobs available
                </span>

            </div>

        @endif

    </div>



    @if($jobs->count() > 0)


        <!-- ================= JOB GRID ================= -->

        <div class="grid grid-cols-1
                    md:grid-cols-2
                    xl:grid-cols-3
                    gap-6">


            @foreach($jobs as $job)


                <!-- Job Card -->

                <div class="group
                            bg-white
                            border border-slate-200
                            rounded-2xl
                            overflow-hidden
                            shadow-sm
                            hover:shadow-xl
                            hover:-translate-y-1
                            transition duration-300">


                    <!-- Card Top -->

                    <div class="p-6">


                        <!-- Job Header -->

                        <div class="flex items-start
                                    justify-between gap-4">


                            <div class="flex items-start gap-3">


                                <!-- Job Icon -->

                                <div class="w-12 h-12
                                            flex-shrink-0
                                            bg-blue-50
                                            text-blue-600
                                            rounded-xl
                                            flex items-center
                                            justify-center
                                            text-lg
                                            font-bold">

                                    {{ strtoupper(substr($job->job_title, 0, 1)) }}

                                </div>


                                <div>

                                    <h2 class="text-lg
                                               font-bold
                                               text-slate-900
                                               group-hover:text-blue-600
                                               transition">

                                        {{ $job->job_title }}

                                    </h2>


                                    <p class="text-sm
                                              text-slate-400
                                              mt-1">

                                        Job Opportunity

                                    </p>

                                </div>

                            </div>


                            <!-- Job Type Badge -->

                            <span class="flex-shrink-0
                                         px-2.5 py-1
                                         rounded-full
                                         bg-blue-50
                                         text-blue-600
                                         text-xs
                                         font-semibold">

                                {{ $job->job_type }}

                            </span>

                        </div>



                        <!-- Divider -->

                        <div class="border-t
                                    border-slate-100
                                    my-5">
                        </div>



                        <!-- Job Information -->

                        <div class="space-y-3">


                            <!-- Location -->

                            <div class="flex items-center
                                        gap-3
                                        text-sm">

                                <div class="w-8 h-8
                                            rounded-lg
                                            bg-slate-100
                                            flex items-center
                                            justify-center">

                                    📍

                                </div>

                                <div>

                                    <p class="text-xs text-slate-400">
                                        Location
                                    </p>

                                    <p class="font-medium text-slate-700">

                                        {{ $job->location }}

                                    </p>

                                </div>

                            </div>


                            <!-- Salary -->

                            <div class="flex items-center
                                        gap-3
                                        text-sm">

                                <div class="w-8 h-8
                                            rounded-lg
                                            bg-green-50
                                            flex items-center
                                            justify-center">

                                    💰

                                </div>

                                <div>

                                    <p class="text-xs text-slate-400">
                                        Salary
                                    </p>

                                    <p class="font-medium text-slate-700">

                                        {{ $job->salary }}

                                    </p>

                                </div>

                            </div>


                            <!-- Experience -->

                            <div class="flex items-center
                                        gap-3
                                        text-sm">

                                <div class="w-8 h-8
                                            rounded-lg
                                            bg-purple-50
                                            flex items-center
                                            justify-center">

                                    🎓

                                </div>

                                <div>

                                    <p class="text-xs text-slate-400">
                                        Experience
                                    </p>

                                    <p class="font-medium text-slate-700">

                                        {{ $job->experience }}

                                    </p>

                                </div>

                            </div>


                            <!-- Vacancy -->

                            <div class="flex items-center
                                        gap-3
                                        text-sm">

                                <div class="w-8 h-8
                                            rounded-lg
                                            bg-orange-50
                                            flex items-center
                                            justify-center">

                                    👥

                                </div>

                                <div>

                                    <p class="text-xs text-slate-400">
                                        Open Positions
                                    </p>

                                    <p class="font-medium text-slate-700">

                                        {{ $job->vacancy }} Vacancy

                                    </p>

                                </div>

                            </div>

                        </div>

                    </div>



                    <!-- Card Bottom -->

                    <div class="bg-slate-50
                                border-t border-slate-100
                                px-6 py-4">


                        <div class="flex items-center
                                    justify-between gap-3">


                            <!-- Deadline -->

                            <div>

                                <p class="text-xs text-slate-400">
                                    Application Deadline
                                </p>

                                <p class="text-sm
                                          font-semibold
                                          text-red-600
                                          mt-1">

                                    {{ $job->deadline }}

                                </p>

                            </div>


                            <!-- Details -->

                            <a href="{{ route('student.job.details', $job->id) }}"
                               class="inline-flex
                                      items-center
                                      justify-center
                                      bg-blue-600
                                      hover:bg-blue-700
                                      text-white
                                      px-4 py-2.5
                                      rounded-lg
                                      text-sm
                                      font-semibold
                                      transition
                                      shadow-sm">

                                View Details

                                <span class="ml-2">
                                    →
                                </span>

                            </a>

                        </div>

                    </div>


                </div>


            @endforeach


        </div>


    @else


        <!-- ================= EMPTY STATE ================= -->

        <div class="bg-white
                    border border-slate-200
                    rounded-2xl
                    shadow-sm
                    p-12 sm:p-16
                    text-center">


            <div class="mx-auto w-20 h-20
                        bg-blue-50
                        rounded-2xl
                        flex items-center
                        justify-center
                        text-4xl">

                💼

            </div>


            <h2 class="text-2xl
                       font-bold
                       text-slate-900
                       mt-6">

                No Jobs Available

            </h2>


            <p class="text-slate-500
                      max-w-md
                      mx-auto
                      mt-2
                      leading-6">

                There are currently no job openings available.
                Please check again later for new opportunities.

            </p>


            <a href="{{ route('student.dashboard') }}"
               class="inline-flex
                      items-center
                      mt-6
                      bg-blue-600
                      hover:bg-blue-700
                      text-white
                      px-6 py-3
                      rounded-xl
                      font-semibold
                      transition">

                Back to Dashboard

                <span class="ml-2">
                    →
                </span>

            </a>

        </div>


    @endif


</main>



<!-- ================= FOOTER ================= -->

<footer class="border-t border-slate-200 mt-10">

    <div class="max-w-7xl mx-auto
                px-4 sm:px-6
                py-6
                text-center">

        <p class="text-sm text-slate-400">

            © {{ date('Y') }} JobPortal. All rights reserved.

        </p>

    </div>

</footer>


</body>

</html>