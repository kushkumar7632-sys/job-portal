<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>{{ $job->job_title }} | JobPortal</title>

    @vite('resources/css/app.css')

</head>


<body class="bg-slate-50 min-h-screen text-slate-800">


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


            <!-- Right Side -->

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

<main class="max-w-5xl mx-auto
             px-4 sm:px-6
             py-8">


    <!-- Breadcrumb -->

    <div class="flex items-center gap-2
                text-sm text-slate-500 mb-5">

        <a href="{{ route('student.dashboard') }}"
           class="hover:text-blue-600">

            Dashboard

        </a>

        <span>›</span>

        <a href="{{ route('student.jobs') }}"
           class="hover:text-blue-600">

            Available Jobs

        </a>

        <span>›</span>

        <span class="text-slate-700">
            Job Details
        </span>

    </div>



    <!-- Back -->

    <a href="{{ route('student.jobs') }}"
       class="inline-flex items-center gap-2
              text-slate-500
              hover:text-blue-600
              text-sm font-medium
              mb-6
              transition">

        ← Back to Jobs

    </a>



    <!-- Success Message -->

    @if(session('success'))

        <div class="mb-6
                    flex items-start gap-3
                    bg-green-50
                    border border-green-200
                    text-green-700
                    px-5 py-4
                    rounded-xl">

            <span class="font-bold">
                ✓
            </span>

            <span class="text-sm">
                {{ session('success') }}
            </span>

        </div>

    @endif



    <!-- Error Message -->

    @if(session('error'))

        <div class="mb-6
                    flex items-start gap-3
                    bg-red-50
                    border border-red-200
                    text-red-700
                    px-5 py-4
                    rounded-xl">

            <span class="font-bold">
                ⚠
            </span>

            <span class="text-sm">
                {{ session('error') }}
            </span>

        </div>

    @endif



    <!-- ================= JOB HEADER ================= -->

    <div class="bg-gradient-to-r
                from-blue-600
                to-indigo-600
                rounded-2xl
                shadow-lg
                p-6 sm:p-8
                text-white
                mb-6">


        <div class="flex flex-col
                    md:flex-row
                    md:items-center
                    md:justify-between
                    gap-6">


            <!-- Job Info -->

            <div class="flex items-start gap-4">


                <!-- Job Icon -->

                <div class="hidden sm:flex
                            flex-shrink-0
                            w-16 h-16
                            bg-white/15
                            rounded-2xl
                            items-center
                            justify-center
                            text-2xl
                            font-bold">

                    {{ strtoupper(substr($job->job_title, 0, 1)) }}

                </div>


                <div>

                    <p class="text-blue-100
                              text-sm font-medium mb-2">

                        JOB OPPORTUNITY

                    </p>


                    <h1 class="text-2xl sm:text-3xl
                               font-bold">

                        {{ $job->job_title }}

                    </h1>


                    <div class="flex flex-wrap
                                items-center gap-3
                                mt-4">


                        <span class="inline-flex
                                     items-center
                                     bg-white/15
                                     px-3 py-1.5
                                     rounded-full
                                     text-sm">

                            💼 {{ $job->job_type }}

                        </span>


                        <span class="inline-flex
                                     items-center
                                     bg-white/15
                                     px-3 py-1.5
                                     rounded-full
                                     text-sm">

                            📍 {{ $job->location }}

                        </span>

                    </div>

                </div>

            </div>


            <!-- Deadline -->

            <div class="md:text-right
                        md:min-w-[180px]">

                <p class="text-blue-100
                          text-sm">

                    Application Deadline

                </p>

                <p class="text-xl
                          font-bold
                          mt-1">

                    {{ $job->deadline }}

                </p>

            </div>

        </div>

    </div>



    <!-- ================= CONTENT ================= -->

    <div class="grid grid-cols-1
                lg:grid-cols-3
                gap-6">


        <!-- ================= LEFT ================= -->

        <div class="lg:col-span-2
                    space-y-6">


            <!-- Job Overview -->

            <div class="bg-white
                        border border-slate-200
                        rounded-2xl
                        shadow-sm
                        p-6 sm:p-7">


                <h2 class="text-xl
                           font-bold
                           text-slate-900
                           mb-6">

                    Job Overview

                </h2>


                <div class="grid grid-cols-1
                            sm:grid-cols-2
                            gap-5">


                    <!-- Location -->

                    <div class="flex items-center gap-4
                                p-4
                                bg-slate-50
                                rounded-xl">

                        <div class="w-11 h-11
                                    bg-blue-50
                                    text-blue-600
                                    rounded-xl
                                    flex items-center
                                    justify-center">

                            📍

                        </div>

                        <div>

                            <p class="text-xs
                                      text-slate-400">

                                Location

                            </p>

                            <p class="font-semibold
                                      text-slate-800
                                      mt-1">

                                {{ $job->location }}

                            </p>

                        </div>

                    </div>


                    <!-- Salary -->

                    <div class="flex items-center gap-4
                                p-4
                                bg-slate-50
                                rounded-xl">

                        <div class="w-11 h-11
                                    bg-green-50
                                    text-green-600
                                    rounded-xl
                                    flex items-center
                                    justify-center">

                            💰

                        </div>

                        <div>

                            <p class="text-xs
                                      text-slate-400">

                                Salary

                            </p>

                            <p class="font-semibold
                                      text-slate-800
                                      mt-1">

                                {{ $job->salary }}

                            </p>

                        </div>

                    </div>


                    <!-- Experience -->

                    <div class="flex items-center gap-4
                                p-4
                                bg-slate-50
                                rounded-xl">

                        <div class="w-11 h-11
                                    bg-purple-50
                                    text-purple-600
                                    rounded-xl
                                    flex items-center
                                    justify-center">

                            🎓

                        </div>

                        <div>

                            <p class="text-xs
                                      text-slate-400">

                                Experience

                            </p>

                            <p class="font-semibold
                                      text-slate-800
                                      mt-1">

                                {{ $job->experience }}

                            </p>

                        </div>

                    </div>


                    <!-- Vacancies -->

                    <div class="flex items-center gap-4
                                p-4
                                bg-slate-50
                                rounded-xl">

                        <div class="w-11 h-11
                                    bg-orange-50
                                    text-orange-600
                                    rounded-xl
                                    flex items-center
                                    justify-center">

                            👥

                        </div>

                        <div>

                            <p class="text-xs
                                      text-slate-400">

                                Vacancies

                            </p>

                            <p class="font-semibold
                                      text-slate-800
                                      mt-1">

                                {{ $job->vacancy }} Positions

                            </p>

                        </div>

                    </div>


                    <!-- Deadline -->

                    <div class="flex items-center gap-4
                                p-4
                                bg-red-50
                                rounded-xl
                                sm:col-span-2">

                        <div class="w-11 h-11
                                    bg-red-100
                                    text-red-600
                                    rounded-xl
                                    flex items-center
                                    justify-center">

                            📅

                        </div>

                        <div>

                            <p class="text-xs
                                      text-red-500">

                                Application Deadline

                            </p>

                            <p class="font-semibold
                                      text-red-700
                                      mt-1">

                                {{ $job->deadline }}

                            </p>

                        </div>

                    </div>

                </div>

            </div>



            <!-- Job Description -->

            <div class="bg-white
                        border border-slate-200
                        rounded-2xl
                        shadow-sm
                        p-6 sm:p-7">


                <h2 class="text-xl
                           font-bold
                           text-slate-900
                           mb-5">

                    Job Description

                </h2>


                <div class="text-slate-600
                            leading-7
                            whitespace-pre-line">

                    {{ $job->description }}

                </div>

            </div>


        </div>



        <!-- ================= RIGHT SIDEBAR ================= -->

        <div class="space-y-6">


            <!-- Apply Card -->

            <div class="bg-white
                        border border-slate-200
                        rounded-2xl
                        shadow-sm
                        p-6
                        lg:sticky
                        lg:top-24">


                <h3 class="text-lg
                           font-bold
                           text-slate-900">

                    Interested in this job?

                </h3>


                <p class="text-sm
                          text-slate-500
                          mt-2
                          leading-6">

                    Submit your application and take
                    the next step in your career.

                </p>


                <!-- Apply Form -->

                <form action="{{ route('student.job.apply', $job->id) }}"
                      method="POST"
                      class="mt-6">

                    @csrf


                    <button
                        type="submit"
                        class="w-full
                               inline-flex
                               justify-center
                               items-center
                               bg-green-600
                               hover:bg-green-700
                               active:bg-green-800
                               text-white
                               font-semibold
                               px-6 py-3.5
                               rounded-xl
                               shadow-sm
                               hover:shadow-md
                               transition">

                        Apply Now

                        <span class="ml-2">
                            →
                        </span>

                    </button>

                </form>


                <!-- Info -->

                <div class="mt-5
                            pt-5
                            border-t
                            border-slate-200
                            space-y-3">


                    <div class="flex items-center gap-2
                                text-sm text-slate-500">

                        <span class="text-green-600">
                            ✓
                        </span>

                        Easy application process

                    </div>


                    <div class="flex items-center gap-2
                                text-sm text-slate-500">

                        <span class="text-green-600">
                            ✓
                        </span>

                        Secure application

                    </div>


                    <div class="flex items-center gap-2
                                text-sm text-slate-500">

                        <span class="text-green-600">
                            ✓
                        </span>

                        Track application status

                    </div>

                </div>

            </div>



            <!-- Job Summary -->

            <div class="bg-blue-50
                        border border-blue-100
                        rounded-2xl
                        p-5">


                <h3 class="font-bold
                           text-blue-900">

                    Quick Summary

                </h3>


                <div class="mt-4 space-y-3
                            text-sm">


                    <div class="flex justify-between gap-3">

                        <span class="text-blue-700">
                            Job Type
                        </span>

                        <span class="font-semibold
                                     text-blue-900">

                            {{ $job->job_type }}

                        </span>

                    </div>


                    <div class="flex justify-between gap-3">

                        <span class="text-blue-700">
                            Experience
                        </span>

                        <span class="font-semibold
                                     text-blue-900">

                            {{ $job->experience }}

                        </span>

                    </div>


                    <div class="flex justify-between gap-3">

                        <span class="text-blue-700">
                            Vacancies
                        </span>

                        <span class="font-semibold
                                     text-blue-900">

                            {{ $job->vacancy }}

                        </span>

                    </div>


                    <div class="flex justify-between gap-3">

                        <span class="text-blue-700">
                            Location
                        </span>

                        <span class="font-semibold
                                     text-blue-900
                                     text-right">

                            {{ $job->location }}

                        </span>

                    </div>

                </div>

            </div>


        </div>

    </div>


</main>



<!-- ================= FOOTER ================= -->

<footer class="border-t border-slate-200 mt-8">

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