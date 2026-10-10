<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>My Applications | JobPortal</title>

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
                                rounded-lg flex items-center
                                justify-center">

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
                            Logged in as
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
                              bg-blue-600
                              hover:bg-blue-700
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


        <!-- Page Header -->

        <div class="flex flex-col md:flex-row
                    md:items-center md:justify-between
                    gap-4 mb-8">


            <div>

                <div class="flex items-center gap-2
                            text-sm text-slate-500 mb-2">

                    <a href="{{ route('student.dashboard') }}"
                       class="hover:text-blue-600">

                        Dashboard

                    </a>

                    <span>›</span>

                    <span>My Applications</span>

                </div>


                <h1 class="text-3xl font-bold text-slate-900">

                    My Applications

                </h1>


                <p class="text-slate-500 mt-2">

                    Track and manage the jobs you have applied for.

                </p>

            </div>


            <!-- Browse Jobs -->

            <a href="{{ route('student.jobs') }}"
               class="inline-flex items-center justify-center
                      bg-blue-600 hover:bg-blue-700
                      text-white
                      px-5 py-3
                      rounded-xl
                      font-semibold
                      shadow-sm
                      transition">

                Find More Jobs

                <span class="ml-2">→</span>

            </a>

        </div>



        @if($applications->count() > 0)


            <!-- ================= APPLICATIONS ================= -->

            <div class="space-y-5">


                @foreach($applications as $application)


                    <div class="bg-white
                                border border-slate-200
                                rounded-2xl
                                shadow-sm
                                hover:shadow-md
                                transition duration-200
                                overflow-hidden">


                        <div class="p-5 sm:p-6">


                            <div class="flex flex-col
                                        lg:flex-row
                                        lg:items-center
                                        lg:justify-between
                                        gap-6">


                                <!-- LEFT -->

                                <div class="flex gap-4">


                                    <!-- Company/Job Icon -->

                                    <div class="hidden sm:flex
                                                flex-shrink-0
                                                w-14 h-14
                                                rounded-xl
                                                bg-blue-50
                                                text-blue-600
                                                items-center
                                                justify-center
                                                text-xl
                                                font-bold">

                                        {{ strtoupper(substr($application->job->job_title, 0, 1)) }}

                                    </div>


                                    <div>


                                        <!-- Job Title -->

                                        <h2 class="text-xl font-bold
                                                   text-slate-900">

                                            {{ $application->job->job_title }}

                                        </h2>


                                        <!-- Job Details -->

                                        <div class="flex flex-wrap
                                                    gap-x-5 gap-y-2
                                                    mt-3
                                                    text-sm
                                                    text-slate-500">


                                            <span class="flex items-center gap-1">

                                                <span>📍</span>

                                                {{ $application->job->location }}

                                            </span>


                                            <span class="flex items-center gap-1">

                                                <span>💼</span>

                                                {{ $application->job->job_type }}

                                            </span>


                                            <span class="flex items-center gap-1">

                                                <span>💰</span>

                                                {{ $application->job->salary }}

                                            </span>

                                        </div>


                                        <!-- Applied Date -->

                                        <div class="flex items-center
                                                    gap-2 mt-4
                                                    text-sm text-slate-400">

                                            <span>Applied on</span>

                                            <span class="font-medium
                                                         text-slate-600">

                                                {{ $application->created_at->format('d M Y') }}

                                            </span>

                                        </div>

                                    </div>

                                </div>



                                <!-- RIGHT -->

                                <div class="flex flex-col
                                            lg:items-end
                                            gap-3
                                            lg:min-w-[180px]">


                                    <!-- STATUS -->

                                    <div>

                                        @if($application->status === 'Pending')

                                            <span class="inline-flex
                                                         items-center gap-2
                                                         px-4 py-2
                                                         rounded-full
                                                         bg-amber-50
                                                         border border-amber-200
                                                         text-amber-700
                                                         font-semibold
                                                         text-sm">

                                                <span class="w-2 h-2
                                                             bg-amber-500
                                                             rounded-full">
                                                </span>

                                                Pending

                                            </span>


                                        @elseif($application->status === 'Shortlisted')

                                            <span class="inline-flex
                                                         items-center gap-2
                                                         px-4 py-2
                                                         rounded-full
                                                         bg-blue-50
                                                         border border-blue-200
                                                         text-blue-700
                                                         font-semibold
                                                         text-sm">

                                                <span class="w-2 h-2
                                                             bg-blue-500
                                                             rounded-full">
                                                </span>

                                                Shortlisted

                                            </span>


                                        @elseif($application->status === 'Selected')

                                            <span class="inline-flex
                                                         items-center gap-2
                                                         px-4 py-2
                                                         rounded-full
                                                         bg-green-50
                                                         border border-green-200
                                                         text-green-700
                                                         font-semibold
                                                         text-sm">

                                                <span class="w-2 h-2
                                                             bg-green-500
                                                             rounded-full">
                                                </span>

                                                Selected

                                            </span>


                                        @elseif($application->status === 'Rejected')

                                            <span class="inline-flex
                                                         items-center gap-2
                                                         px-4 py-2
                                                         rounded-full
                                                         bg-red-50
                                                         border border-red-200
                                                         text-red-700
                                                         font-semibold
                                                         text-sm">

                                                <span class="w-2 h-2
                                                             bg-red-500
                                                             rounded-full">
                                                </span>

                                                Rejected

                                            </span>

                                        @endif

                                    </div>



                                    <!-- ACTIONS -->

                                    <div class="flex flex-wrap
                                                items-center gap-4">


                                        <!-- View Job -->

                                        <a href="{{ route('student.job.details', $application->job_id) }}"
                                           class="text-blue-600
                                                  hover:text-blue-800
                                                  font-semibold
                                                  text-sm
                                                  transition">

                                            View Job →

                                        </a>


                                        <!-- Resume -->

                                        @if($application->resume)

                                            <span class="inline-flex
                                                         items-center gap-1
                                                         text-green-600
                                                         text-sm
                                                         font-semibold">

                                                ✓ Resume Uploaded

                                            </span>

                                        @else

                                            <a href="{{ route('student.resume.upload', $application->job_id) }}"
                                               class="text-orange-600
                                                      hover:text-orange-700
                                                      text-sm
                                                      font-semibold">

                                                Upload Resume →

                                            </a>

                                        @endif

                                    </div>

                                </div>

                            </div>

                        </div>


                        <!-- Bottom Status Strip -->

                        @if($application->status === 'Selected')

                            <div class="bg-green-50
                                        border-t border-green-100
                                        px-5 py-3">

                                <p class="text-sm text-green-700
                                          font-medium">

                                    🎉 Congratulations! You have been selected
                                    for this position.

                                </p>

                            </div>


                        @elseif($application->status === 'Shortlisted')

                            <div class="bg-blue-50
                                        border-t border-blue-100
                                        px-5 py-3">

                                <p class="text-sm text-blue-700
                                          font-medium">

                                    Your application has been shortlisted.
                                    Keep an eye on your application status.

                                </p>

                            </div>

                        @endif


                    </div>


                @endforeach


            </div>


        @else


            <!-- ================= EMPTY STATE ================= -->

            <div class="bg-white
                        border border-slate-200
                        rounded-2xl
                        shadow-sm
                        p-10 sm:p-16
                        text-center">


                <div class="mx-auto w-20 h-20
                            bg-blue-50
                            rounded-2xl
                            flex items-center justify-center
                            text-4xl">

                    📋

                </div>


                <h2 class="text-2xl font-bold
                           text-slate-900 mt-6">

                    No Applications Yet

                </h2>


                <p class="text-slate-500
                          max-w-md mx-auto
                          mt-2 leading-6">

                    You haven't applied for any jobs yet.
                    Explore available opportunities and start
                    building your career today.

                </p>


                <a href="{{ route('student.jobs') }}"
                   class="inline-flex items-center
                          mt-6
                          bg-blue-600
                          hover:bg-blue-700
                          text-white
                          px-6 py-3
                          rounded-xl
                          font-semibold
                          shadow-sm
                          transition">

                    Browse Available Jobs

                    <span class="ml-2">→</span>

                </a>

            </div>


        @endif


    </main>



    <!-- ================= FOOTER ================= -->

    <footer class="border-t border-slate-200 mt-10">

        <div class="max-w-7xl mx-auto px-4
                    py-6 text-center">

            <p class="text-sm text-slate-400">

                © {{ date('Y') }} JobPortal. All rights reserved.

            </p>

        </div>

    </footer>


</body>

</html>