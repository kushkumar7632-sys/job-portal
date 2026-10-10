<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Job | JobPortal</title>

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


            <!-- Back -->
            <a href="{{ route('company.jobs') }}"
               class="px-5 py-2.5 rounded-xl
                      border border-slate-300
                      text-slate-700 font-semibold
                      hover:bg-slate-100
                      transition">

                ← Back to Jobs

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

                Edit Job

            </h2>

            <p class="text-slate-500 text-lg mt-3">

                Update the details of your job posting.

            </p>

        </div>



        <!-- ================= ERRORS ================= -->
        @if ($errors->any())

            <div class="mb-8 bg-red-50 border border-red-200
                        text-red-700 p-5 rounded-xl">

                <div class="flex items-start gap-3">

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



        <!-- ================= FORM ================= -->
        <form action="{{ route('job.update', $job->id) }}"
              method="POST">

            @csrf

            @method('PUT')


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
                            Update the basic information of this job.
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
                            value="{{ old('job_title', $job->job_title) }}"
                            class="w-full px-4 py-3.5
                                   border border-slate-300
                                   rounded-xl
                                   bg-white
                                   outline-none
                                   focus:border-blue-500
                                   focus:ring-4
                                   focus:ring-blue-100
                                   transition"
                            required>

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
                                   transition"
                            required>

                            <option value="">
                                Select Job Type
                            </option>

                            <option value="Full Time"
                                {{ old('job_type', $job->job_type) == 'Full Time' ? 'selected' : '' }}>
                                Full Time
                            </option>

                            <option value="Part Time"
                                {{ old('job_type', $job->job_type) == 'Part Time' ? 'selected' : '' }}>
                                Part Time
                            </option>

                            <option value="Internship"
                                {{ old('job_type', $job->job_type) == 'Internship' ? 'selected' : '' }}>
                                Internship
                            </option>

                            <option value="Contract"
                                {{ old('job_type', $job->job_type) == 'Contract' ? 'selected' : '' }}>
                                Contract
                            </option>

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
                            value="{{ old('location', $job->location) }}"
                            class="w-full px-4 py-3.5
                                   border border-slate-300
                                   rounded-xl
                                   bg-white
                                   outline-none
                                   focus:border-blue-500
                                   focus:ring-4
                                   focus:ring-blue-100
                                   transition"
                            required>

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
                            value="{{ old('salary', $job->salary) }}"
                            class="w-full px-4 py-3.5
                                   border border-slate-300
                                   rounded-xl
                                   bg-white
                                   outline-none
                                   focus:border-blue-500
                                   focus:ring-4
                                   focus:ring-blue-100
                                   transition"
                            required>

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
                            value="{{ old('experience', $job->experience) }}"
                            class="w-full px-4 py-3.5
                                   border border-slate-300
                                   rounded-xl
                                   bg-white
                                   outline-none
                                   focus:border-blue-500
                                   focus:ring-4
                                   focus:ring-blue-100
                                   transition"
                            required>

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
                            value="{{ old('vacancy', $job->vacancy) }}"
                            min="1"
                            class="w-full px-4 py-3.5
                                   border border-slate-300
                                   rounded-xl
                                   bg-white
                                   outline-none
                                   focus:border-blue-500
                                   focus:ring-4
                                   focus:ring-blue-100
                                   transition"
                            required>

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
                            Update the role and responsibilities.
                        </p>

                    </div>

                </div>


                <label class="block text-sm font-semibold
                              text-slate-700 mb-2">

                    Job Description

                </label>

                <textarea
                    name="description"
                    rows="8"
                    class="w-full px-4 py-3.5
                           border border-slate-300
                           rounded-xl
                           bg-white
                           outline-none
                           resize-y
                           focus:border-blue-500
                           focus:ring-4
                           focus:ring-blue-100
                           transition"
                    required>{{ old('description', $job->description) }}</textarea>

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
                            Update the last date for applications.
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
                        value="{{ old('deadline', $job->deadline) }}"
                        class="w-full px-4 py-3.5
                               border border-slate-300
                               rounded-xl
                               bg-white
                               outline-none
                               focus:border-blue-500
                               focus:ring-4
                               focus:ring-blue-100
                               transition"
                        required>

                </div>

            </section>



            <!-- ================= UPDATE ================= -->
            <div class="border-t border-slate-200 pt-8
                        flex flex-col sm:flex-row
                        items-start sm:items-center
                        justify-between gap-5">

                <div>

                    <p class="font-semibold text-slate-800">
                        Save your changes
                    </p>

                    <p class="text-sm text-slate-500 mt-1">
                        Make sure all job details are correct before updating.
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

                    Update Job →

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