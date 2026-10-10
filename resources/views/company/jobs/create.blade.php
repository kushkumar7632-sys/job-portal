<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Post New Job | JobPortal</title>

    @vite('resources/css/app.css')
</head>

<body class="bg-slate-50 min-h-screen">

    <!-- ================= HEADER ================= -->
    <header class="bg-white border-b border-slate-200">

        <div class="w-full px-6 lg:px-12 py-5 flex items-center justify-between">

            <!-- Logo -->
            <div class="flex items-center gap-3">

                <div class="w-11 h-11 rounded-xl bg-blue-600
                            text-white flex items-center justify-center
                            text-xl font-bold">
                    J
                </div>

                <div>
                    <h1 class="text-2xl font-bold text-slate-900">
                        Job<span class="text-blue-600">Portal</span>
                    </h1>

                    <p class="text-xs text-slate-400">
                        Employer Portal
                    </p>
                </div>

            </div>


            <!-- Dashboard -->
            <a href="{{ route('company.dashboard') }}"
               class="px-5 py-2.5 rounded-xl
                      border border-blue-600
                      text-blue-600 font-semibold
                      hover:bg-blue-600 hover:text-white
                      transition">

                ← Dashboard

            </a>

        </div>

    </header>



    <!-- ================= MAIN ================= -->
    <main class="w-full px-6 lg:px-12 xl:px-20 py-10 lg:py-14">

        <!-- Heading -->
        <div class="mb-10">

            <p class="text-sm font-bold text-blue-600
                      uppercase tracking-wider mb-2">

                Employer Portal

            </p>

            <h2 class="text-4xl lg:text-5xl font-bold text-slate-900">

                Post a New Job

            </h2>

            <p class="text-slate-500 text-lg mt-3">

                Create a job opening and find the right candidate for your company.

            </p>

        </div>



        <!-- ================= ERROR ================= -->
        @if ($errors->any())

            <div class="mb-8 bg-red-50 border border-red-200
                        text-red-700 p-5 rounded-xl">

                <div class="flex gap-3">

                    <span class="text-lg">
                        ⚠️
                    </span>

                    <div>

                        <p class="font-semibold mb-2">
                            Please fix the following errors:
                        </p>

                        <ul class="list-disc pl-5 text-sm space-y-1">

                            @foreach ($errors->all() as $error)

                                <li>
                                    {{ $error }}
                                </li>

                            @endforeach

                        </ul>

                    </div>

                </div>

            </div>

        @endif



        <!-- ================= SUCCESS ================= -->
        @if(session('success'))

            <div class="mb-8 bg-green-50 border border-green-200
                        text-green-700 p-5 rounded-xl">

                <div class="flex items-center gap-3">

                    <span class="text-lg">
                        ✓
                    </span>

                    <span class="font-medium">
                        {{ session('success') }}
                    </span>

                </div>

            </div>

        @endif



        <!-- ================= FORM ================= -->
        <form action="/company/job/store" method="POST">

            @csrf


            <!-- ================= JOB INFORMATION ================= -->
            <section class="mb-12">

                <div class="flex items-center gap-4 mb-7">

                    <div class="w-10 h-10 rounded-xl
                                bg-blue-100 text-blue-600
                                flex items-center justify-center
                                font-bold">

                        1

                    </div>

                    <div>

                        <h3 class="text-2xl font-bold text-slate-900">
                            Job Information
                        </h3>

                        <p class="text-sm text-slate-500">
                            Enter the basic details of the job.
                        </p>

                    </div>

                </div>


                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">


                    <!-- Job Title -->
                    <div class="xl:col-span-2">

                        <label class="block text-sm font-semibold
                                      text-slate-700 mb-2">

                            Job Title

                        </label>

                        <input
                            type="text"
                            name="job_title"
                            placeholder="e.g. Laravel Developer"
                            class="w-full px-4 py-3.5
                                   border border-slate-300
                                   rounded-xl
                                   bg-white
                                   outline-none
                                   focus:border-blue-500
                                   focus:ring-4
                                   focus:ring-blue-100
                                   transition">

                    </div>



                    <!-- Job Type -->
                    <div>

                        <label class="block text-sm font-semibold
                                      text-slate-700 mb-2">

                            Job Type

                        </label>

                        <select
                            name="job_type"
                            class="w-full px-4 py-3.5
                                   border border-slate-300
                                   rounded-xl
                                   bg-white
                                   outline-none
                                   focus:border-blue-500
                                   focus:ring-4
                                   focus:ring-blue-100
                                   transition">

                            <option>Full Time</option>
                            <option>Part Time</option>
                            <option>Internship</option>
                            <option>Remote</option>

                        </select>

                    </div>



                    <!-- Location -->
                    <div>

                        <label class="block text-sm font-semibold
                                      text-slate-700 mb-2">

                            Location

                        </label>

                        <input
                            type="text"
                            name="location"
                            placeholder="e.g. Patna, Bihar"
                            class="w-full px-4 py-3.5
                                   border border-slate-300
                                   rounded-xl
                                   bg-white
                                   outline-none
                                   focus:border-blue-500
                                   focus:ring-4
                                   focus:ring-blue-100
                                   transition">

                    </div>



                    <!-- Salary -->
                    <div>

                        <label class="block text-sm font-semibold
                                      text-slate-700 mb-2">

                            Salary

                        </label>

                        <input
                            type="text"
                            name="salary"
                            placeholder="e.g. ₹4 - ₹6 LPA"
                            class="w-full px-4 py-3.5
                                   border border-slate-300
                                   rounded-xl
                                   bg-white
                                   outline-none
                                   focus:border-blue-500
                                   focus:ring-4
                                   focus:ring-blue-100
                                   transition">

                    </div>



                    <!-- Experience -->
                    <div>

                        <label class="block text-sm font-semibold
                                      text-slate-700 mb-2">

                            Experience

                        </label>

                        <input
                            type="text"
                            name="experience"
                            placeholder="e.g. 0-2 Years"
                            class="w-full px-4 py-3.5
                                   border border-slate-300
                                   rounded-xl
                                   bg-white
                                   outline-none
                                   focus:border-blue-500
                                   focus:ring-4
                                   focus:ring-blue-100
                                   transition">

                    </div>



                    <!-- Vacancy -->
                    <div>

                        <label class="block text-sm font-semibold
                                      text-slate-700 mb-2">

                            Number of Vacancies

                        </label>

                        <input
                            type="number"
                            name="vacancy"
                            placeholder="e.g. 5"
                            class="w-full px-4 py-3.5
                                   border border-slate-300
                                   rounded-xl
                                   bg-white
                                   outline-none
                                   focus:border-blue-500
                                   focus:ring-4
                                   focus:ring-blue-100
                                   transition">

                    </div>

                </div>

            </section>



            <!-- ================= DESCRIPTION ================= -->
            <section class="mb-12">

                <div class="flex items-center gap-4 mb-7">

                    <div class="w-10 h-10 rounded-xl
                                bg-indigo-100 text-indigo-600
                                flex items-center justify-center
                                font-bold">

                        2

                    </div>

                    <div>

                        <h3 class="text-2xl font-bold text-slate-900">
                            Job Description
                        </h3>

                        <p class="text-sm text-slate-500">
                            Describe the role and responsibilities.
                        </p>

                    </div>

                </div>


                <div>

                    <label class="block text-sm font-semibold
                                  text-slate-700 mb-2">

                        Description

                    </label>

                    <textarea
                        name="description"
                        rows="8"
                        placeholder="Describe the job role, responsibilities, requirements and other important details..."
                        class="w-full px-4 py-3.5
                               border border-slate-300
                               rounded-xl
                               bg-white
                               outline-none
                               resize-y
                               focus:border-blue-500
                               focus:ring-4
                               focus:ring-blue-100
                               transition"></textarea>

                </div>

            </section>



            <!-- ================= DEADLINE ================= -->
            <section class="mb-12">

                <div class="flex items-center gap-4 mb-7">

                    <div class="w-10 h-10 rounded-xl
                                bg-orange-100 text-orange-600
                                flex items-center justify-center
                                font-bold">

                        3

                    </div>

                    <div>

                        <h3 class="text-2xl font-bold text-slate-900">
                            Application Deadline
                        </h3>

                        <p class="text-sm text-slate-500">
                            Set the last date for applications.
                        </p>

                    </div>

                </div>


                <div class="max-w-md">

                    <label class="block text-sm font-semibold
                                  text-slate-700 mb-2">

                        Application Deadline

                    </label>

                    <input
                        type="date"
                        name="deadline"
                        class="w-full px-4 py-3.5
                               border border-slate-300
                               rounded-xl
                               bg-white
                               outline-none
                               focus:border-blue-500
                               focus:ring-4
                               focus:ring-blue-100
                               transition">

                </div>

            </section>



            <!-- ================= SUBMIT ================= -->
            <div class="border-t border-slate-200 pt-8
                        flex flex-col sm:flex-row
                        items-start sm:items-center
                        justify-between gap-5">

                <div>

                    <p class="font-semibold text-slate-800">
                        Ready to publish?
                    </p>

                    <p class="text-sm text-slate-500 mt-1">
                        Make sure all job details are correct before publishing.
                    </p>

                </div>


                <button
                    type="submit"
                    class="w-full sm:w-auto
                           px-10 py-4
                           bg-gradient-to-r
                           from-blue-600
                           to-indigo-600
                           text-white
                           font-semibold
                           rounded-xl
                           shadow-lg
                           shadow-blue-200
                           hover:from-blue-700
                           hover:to-indigo-700
                           hover:-translate-y-0.5
                           transition">

                    Publish Job →

                </button>

            </div>

        </form>

    </main>



    <!-- ================= FOOTER ================= -->
    <footer class="border-t border-slate-200 bg-white">

        <div class="w-full px-6 lg:px-12 py-6
                    flex flex-col sm:flex-row
                    justify-between items-center gap-3">

            <p class="text-sm text-slate-500">
                © {{ date('Y') }} JobPortal
            </p>

            <p class="text-sm text-slate-400">
                Professional hiring made simple.
            </p>

        </div>

    </footer>

</body>

</html>