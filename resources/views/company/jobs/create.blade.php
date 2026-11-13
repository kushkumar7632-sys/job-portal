<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Post New Job | JobPortal</title>

    @vite('resources/css/app.css')
</head>

<body class="min-h-screen bg-slate-100 text-slate-800">

    <!-- HEADER -->
    <header class="bg-white border-b border-slate-200">
        <div class="w-full px-6 lg:px-12 py-4 flex items-center justify-between">

            <div class="flex items-center gap-3">
                <div class="w-11 h-11 bg-blue-600 rounded-xl flex items-center justify-center text-white text-xl font-bold">
                    J
                </div>

                <div>
                    <h1 class="text-2xl font-bold text-slate-900">
                        Job<span class="text-blue-600">Portal</span>
                    </h1>
                    <p class="text-xs text-slate-400">Employer Portal</p>
                </div>
            </div>

            <a href="{{ route('company.dashboard') }}"
               class="flex items-center gap-2 px-5 py-2.5 border border-slate-200 rounded-lg text-sm font-semibold text-slate-600 hover:bg-blue-50 hover:text-blue-600 hover:border-blue-300 transition">

                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>

                Dashboard
            </a>

        </div>
    </header>


    <!-- MAIN CONTENT -->
    <main class="w-full px-4 sm:px-6 lg:px-10 xl:px-14 py-8">

        <!-- PAGE TITLE -->
        <div class="mb-7">
            <p class="text-sm font-semibold uppercase tracking-widest text-blue-600 mb-2">
                Employer Portal
            </p>

            <h2 class="text-3xl lg:text-4xl font-bold text-slate-900">
                Post a New Job
            </h2>

            <p class="mt-2 text-slate-500">
                Create a job opening and find the right candidate for your company.
            </p>
        </div>


        <!-- ERROR MESSAGE -->
        @if ($errors->any())

            <div class="mb-6 p-5 rounded-xl border border-red-200 bg-red-50 text-red-700">

                <p class="font-semibold mb-2">Please fix the following errors:</p>

                <ul class="list-disc pl-5 text-sm space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>

            </div>

        @endif


        <!-- SUCCESS MESSAGE -->
        @if(session('success'))

            <div class="mb-6 p-5 rounded-xl border border-green-200 bg-green-50 text-green-700 font-medium">
                {{ session('success') }}
            </div>

        @endif


        <!-- FULL SCREEN FORM CONTAINER -->
        <div class="w-full bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">

            <form action="/company/job/store" method="POST">

                @csrf

                <!-- FORM HEADER -->
                <div class="px-6 sm:px-8 lg:px-10 py-6 border-b border-slate-200 bg-slate-50">

                    <h3 class="text-xl font-bold text-slate-900">
                        Job Posting Form
                    </h3>

                    <p class="text-sm text-slate-500 mt-1">
                        Fill in the following information to publish your job opening.
                    </p>

                </div>


                <!-- SECTION 1 -->
                <div class="px-6 sm:px-8 lg:px-10 py-8 border-b border-slate-200">

                    <div class="flex items-center gap-3 mb-7">

                        <div class="w-10 h-10 rounded-lg bg-blue-100 text-blue-700 flex items-center justify-center font-bold">
                            01
                        </div>

                        <div>
                            <h3 class="text-lg font-bold text-slate-900">
                                Job Information
                            </h3>

                            <p class="text-sm text-slate-500">
                                Enter the basic details of the job.
                            </p>
                        </div>

                    </div>


                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-x-7 gap-y-6">

                        <!-- JOB TITLE -->
                        <div class="xl:col-span-2">

                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                Job Title
                            </label>

                            <input
                                type="text"
                                name="job_title"
                                placeholder="e.g. Laravel Developer"
                                class="w-full px-4 py-3.5 rounded-lg border border-slate-300 bg-white text-sm outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100">

                        </div>


                        <!-- JOB TYPE -->
                        <div>

                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                Job Type
                            </label>

                            <select
                                name="job_type"
                                class="w-full px-4 py-3.5 rounded-lg border border-slate-300 bg-white text-sm outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100">

                                <option>Full Time</option>
                                <option>Part Time</option>
                                <option>Internship</option>
                                <option>Remote</option>

                            </select>

                        </div>


                        <!-- LOCATION -->
                        <div>

                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                Location
                            </label>

                            <input
                                type="text"
                                name="location"
                                placeholder="e.g. Patna, Bihar"
                                class="w-full px-4 py-3.5 rounded-lg border border-slate-300 bg-white text-sm outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100">

                        </div>


                        <!-- SALARY -->
                        <div>

                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                Salary
                            </label>

                            <input
                                type="text"
                                name="salary"
                                placeholder="e.g. ₹4 - ₹6 LPA"
                                class="w-full px-4 py-3.5 rounded-lg border border-slate-300 bg-white text-sm outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100">

                        </div>


                        <!-- EXPERIENCE -->
                        <div>

                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                Experience
                            </label>

                            <input
                                type="text"
                                name="experience"
                                placeholder="e.g. 0-2 Years"
                                class="w-full px-4 py-3.5 rounded-lg border border-slate-300 bg-white text-sm outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100">

                        </div>


                        <!-- VACANCY -->
                        <div>

                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                Number of Vacancies
                            </label>

                            <input
                                type="number"
                                name="vacancy"
                                placeholder="e.g. 5"
                                class="w-full px-4 py-3.5 rounded-lg border border-slate-300 bg-white text-sm outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100">

                        </div>

                    </div>

                </div>


                <!-- SECTION 2 -->
                <div class="px-6 sm:px-8 lg:px-10 py-8 border-b border-slate-200">

                    <div class="flex items-center gap-3 mb-7">

                        <div class="w-10 h-10 rounded-lg bg-indigo-100 text-indigo-700 flex items-center justify-center font-bold">
                            02
                        </div>

                        <div>
                            <h3 class="text-lg font-bold text-slate-900">
                                Job Description
                            </h3>

                            <p class="text-sm text-slate-500">
                                Describe the role and responsibilities.
                            </p>
                        </div>

                    </div>


                    <div>

                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                            Description
                        </label>

                        <textarea
                            name="description"
                            rows="9"
                            placeholder="Describe the job role, responsibilities, requirements and other important details..."
                            class="w-full px-4 py-4 rounded-lg border border-slate-300 bg-white text-sm leading-7 outline-none resize-y transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100"></textarea>

                    </div>

                </div>


                <!-- SECTION 3 -->
                <div class="px-6 sm:px-8 lg:px-10 py-8 border-b border-slate-200">

                    <div class="flex items-center gap-3 mb-7">

                        <div class="w-10 h-10 rounded-lg bg-orange-100 text-orange-700 flex items-center justify-center font-bold">
                            03
                        </div>

                        <div>
                            <h3 class="text-lg font-bold text-slate-900">
                                Application Deadline
                            </h3>

                            <p class="text-sm text-slate-500">
                                Set the last date for applications.
                            </p>
                        </div>

                    </div>


                    <div class="w-full md:w-1/2 xl:w-1/3">

                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                            Application Deadline
                        </label>

                        <input
                            type="date"
                            name="deadline"
                            class="w-full px-4 py-3.5 rounded-lg border border-slate-300 bg-white text-sm outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100">

                    </div>

                </div>


                <!-- FORM FOOTER / SUBMIT -->
                <div class="px-6 sm:px-8 lg:px-10 py-7 bg-slate-50 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-5">

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
                        class="w-full sm:w-auto inline-flex items-center justify-center gap-3 px-10 py-4 bg-blue-600 text-white font-semibold rounded-xl shadow-lg shadow-blue-200 hover:bg-blue-700 hover:shadow-xl transition">

                        Publish Job

                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M5 12h14m-7-7l7 7-7 7"/>
                        </svg>

                    </button>

                </div>

            </form>

        </div>

    </main>


    <!-- FOOTER -->
    <footer class="mt-6 border-t border-slate-200 bg-white">

        <div class="w-full px-6 lg:px-12 py-6 flex flex-col sm:flex-row justify-between items-center gap-3">

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