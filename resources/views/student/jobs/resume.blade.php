<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Upload Resume | JobPortal</title>

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

    <main class="max-w-3xl mx-auto
                 px-4 sm:px-6
                 py-8 sm:py-10">


        <!-- Breadcrumb -->

        <div class="flex items-center gap-2
                    text-sm text-slate-500 mb-6">

            <a href="{{ route('student.jobs') }}"
               class="hover:text-blue-600">

                Jobs

            </a>

            <span>›</span>

            <a href="{{ route('student.job.details', $application->job_id) }}"
               class="hover:text-blue-600">

                Job Details

            </a>

            <span>›</span>

            <span class="text-slate-700">
                Upload Resume
            </span>

        </div>



        <!-- Back -->

        <a href="{{ route('student.job.details', $application->job_id) }}"
           class="inline-flex items-center gap-2
                  text-slate-500
                  hover:text-blue-600
                  font-medium
                  text-sm
                  mb-5
                  transition">

            ← Back to Job

        </a>



        <!-- ================= CARD ================= -->

        <div class="bg-white
                    border border-slate-200
                    rounded-2xl
                    shadow-sm
                    overflow-hidden">


            <!-- Card Header -->

            <div class="bg-gradient-to-r
                        from-blue-600
                        to-indigo-600
                        px-6 sm:px-8
                        py-7
                        text-white">


                <div class="flex items-center gap-4">


                    <div class="w-14 h-14
                                bg-white/15
                                rounded-xl
                                flex items-center
                                justify-center
                                text-2xl">

                        📄

                    </div>


                    <div>

                        <p class="text-blue-100
                                  text-sm font-medium">

                            COMPLETE YOUR APPLICATION

                        </p>

                        <h1 class="text-2xl
                                   sm:text-3xl
                                   font-bold mt-1">

                            Upload Your Resume

                        </h1>

                    </div>

                </div>


                <p class="text-blue-100
                          text-sm
                          mt-5
                          max-w-xl">

                    Upload your latest resume to complete
                    your application and give employers
                    a better view of your skills.

                </p>

            </div>



            <!-- Card Body -->

            <div class="p-6 sm:p-8">


                <!-- Success -->

                @if(session('success'))

                    <div class="mb-6
                                flex gap-3
                                bg-green-50
                                border border-green-200
                                text-green-700
                                px-4 py-4
                                rounded-xl">

                        <span class="font-bold">
                            ✓
                        </span>

                        <span class="text-sm">
                            {{ session('success') }}
                        </span>

                    </div>

                @endif



                <!-- Errors -->

                @if ($errors->any())

                    <div class="mb-6
                                bg-red-50
                                border border-red-200
                                text-red-700
                                px-4 py-4
                                rounded-xl">

                        <p class="font-semibold
                                  text-sm mb-2">

                            Please fix the following:

                        </p>

                        <ul class="list-disc
                                   list-inside
                                   text-sm
                                   space-y-1">

                            @foreach ($errors->all() as $error)

                                <li>
                                    {{ $error }}
                                </li>

                            @endforeach

                        </ul>

                    </div>

                @endif



                <!-- Resume Form -->

                <form
                    action="{{ route('student.resume.store', $application->job_id) }}"
                    method="POST"
                    enctype="multipart/form-data">

                    @csrf



                    <!-- Label -->

                    <label class="block
                                  text-sm
                                  font-semibold
                                  text-slate-700
                                  mb-3">

                        Select your resume

                    </label>



                    <!-- Upload Area -->

                    <div class="group
                                border-2
                                border-dashed
                                border-slate-300
                                hover:border-blue-500
                                hover:bg-blue-50/40
                                rounded-2xl
                                p-7 sm:p-10
                                text-center
                                transition duration-200">


                        <!-- Icon -->

                        <div class="mx-auto
                                    w-16 h-16
                                    bg-blue-50
                                    text-blue-600
                                    rounded-2xl
                                    flex items-center
                                    justify-center
                                    text-3xl
                                    group-hover:scale-105
                                    transition">

                            📁

                        </div>


                        <h3 class="text-lg
                                   font-bold
                                   text-slate-800
                                   mt-5">

                            Choose your resume

                        </h3>


                        <p class="text-sm
                                  text-slate-500
                                  mt-2">

                            Upload a professional resume
                            for this job application.

                        </p>



                        <!-- File Input -->

                        <div class="mt-6">

                            <input
                                type="file"
                                name="resume"
                                accept=".pdf,.doc,.docx"
                                required
                                class="w-full
                                       text-sm
                                       text-slate-600
                                       file:mr-4
                                       file:py-2.5
                                       file:px-4
                                       file:rounded-lg
                                       file:border-0
                                       file:bg-blue-50
                                       file:text-blue-700
                                       file:font-semibold
                                       hover:file:bg-blue-100
                                       cursor-pointer">

                        </div>


                        <!-- Format -->

                        <div class="flex flex-wrap
                                    justify-center
                                    gap-2
                                    mt-5">

                            <span class="px-3 py-1
                                         bg-slate-100
                                         text-slate-600
                                         rounded-full
                                         text-xs
                                         font-medium">

                                PDF

                            </span>

                            <span class="px-3 py-1
                                         bg-slate-100
                                         text-slate-600
                                         rounded-full
                                         text-xs
                                         font-medium">

                                DOC

                            </span>

                            <span class="px-3 py-1
                                         bg-slate-100
                                         text-slate-600
                                         rounded-full
                                         text-xs
                                         font-medium">

                                DOCX

                            </span>

                            <span class="px-3 py-1
                                         bg-slate-100
                                         text-slate-600
                                         rounded-full
                                         text-xs
                                         font-medium">

                                Max 2MB

                            </span>

                        </div>

                    </div>



                    <!-- Upload Button -->

                    <button
                        type="submit"
                        class="w-full
                               mt-6
                               bg-blue-600
                               hover:bg-blue-700
                               active:bg-blue-800
                               text-white
                               font-semibold
                               py-3.5
                               rounded-xl
                               shadow-sm
                               hover:shadow-md
                               transition duration-200">

                        Upload Resume →

                    </button>

                </form>



                <!-- Resume Tips -->

                <div class="mt-7
                            bg-blue-50
                            border border-blue-100
                            rounded-xl
                            p-5">


                    <div class="flex gap-3">


                        <div class="w-9 h-9
                                    flex-shrink-0
                                    bg-blue-100
                                    text-blue-600
                                    rounded-lg
                                    flex items-center
                                    justify-center">

                            💡

                        </div>


                        <div>

                            <h3 class="font-semibold
                                       text-blue-900">

                                Resume Tips

                            </h3>


                            <ul class="mt-2
                                       text-sm
                                       text-blue-700
                                       space-y-1.5">

                                <li>
                                    • Keep your education details updated.
                                </li>

                                <li>
                                    • Highlight relevant technical skills.
                                </li>

                                <li>
                                    • Mention your projects and experience.
                                </li>

                                <li>
                                    • Make sure your contact information is correct.
                                </li>

                            </ul>

                        </div>

                    </div>

                </div>


            </div>

        </div>


        <!-- Security Note -->

        <p class="text-center
                  text-xs
                  text-slate-400
                  mt-5">

            🔒 Your resume will be securely associated
            with your job application.

        </p>


    </main>



    <!-- ================= FOOTER ================= -->

    <footer class="border-t border-slate-200 mt-6">

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