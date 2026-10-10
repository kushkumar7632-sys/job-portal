<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Job Details</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 min-h-screen">

    <!-- Navbar -->
    <nav class="bg-blue-600 text-white px-6 py-4 flex justify-between items-center">

        <h1 class="text-xl font-bold">
            Admin Panel
        </h1>

        <div class="flex items-center gap-4">

            <a href="{{ route('admin.jobs') }}" class="hover:underline">
                Jobs
            </a>

            <a href="{{ route('admin.dashboard') }}" class="hover:underline">
                Dashboard
            </a>

            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf

                <button
                    type="submit"
                    class="bg-white text-blue-600 px-4 py-2 rounded-lg font-semibold"
                >
                    Logout
                </button>
            </form>

        </div>

    </nav>


    <!-- Main Content -->
    <main class="p-6">

        <div class="max-w-3xl mx-auto">

            <div class="bg-white rounded-2xl shadow p-8">

                <div class="flex justify-between items-start mb-6">

                    <div>
                        <h2 class="text-3xl font-bold text-gray-800">
                            {{ $job->job_title }}
                        </h2>

                        <p class="text-gray-500 mt-1">
                            {{ $job->company->company_name ?? 'N/A' }}
                        </p>
                    </div>

                    @if($job->status)

                        <span class="px-3 py-1 rounded-full
                                     bg-green-100 text-green-700
                                     text-sm font-medium">
                            Active
                        </span>

                    @else

                        <span class="px-3 py-1 rounded-full
                                     bg-red-100 text-red-700
                                     text-sm font-medium">
                            Inactive
                        </span>

                    @endif

                </div>


                <!-- Job Details -->

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <div>
                        <p class="text-sm text-gray-500">
                            Job Type
                        </p>

                        <p class="font-semibold text-gray-800">
                            {{ $job->job_type }}
                        </p>
                    </div>


                    <div>
                        <p class="text-sm text-gray-500">
                            Location
                        </p>

                        <p class="font-semibold text-gray-800">
                            {{ $job->location }}
                        </p>
                    </div>


                    <div>
                        <p class="text-sm text-gray-500">
                            Salary
                        </p>

                        <p class="font-semibold text-gray-800">
                            {{ $job->salary }}
                        </p>
                    </div>


                    <div>
                        <p class="text-sm text-gray-500">
                            Experience
                        </p>

                        <p class="font-semibold text-gray-800">
                            {{ $job->experience }}
                        </p>
                    </div>


                    <div>
                        <p class="text-sm text-gray-500">
                            Vacancy
                        </p>

                        <p class="font-semibold text-gray-800">
                            {{ $job->vacancy }}
                        </p>
                    </div>


                    <div>
                        <p class="text-sm text-gray-500">
                            Deadline
                        </p>

                        <p class="font-semibold text-gray-800">
                            {{ $job->deadline }}
                        </p>
                    </div>

                </div>


                <!-- Description -->

                <div class="mt-8">

                    <p class="text-sm text-gray-500 mb-2">
                        Job Description
                    </p>

                    <p class="text-gray-700 leading-relaxed whitespace-pre-line">
                        {{ $job->description }}
                    </p>

                </div>


                <!-- Back -->

                <div class="mt-8">

                    <a
                        href="{{ route('admin.jobs') }}"
                        class="inline-block bg-blue-600 hover:bg-blue-700
                               text-white px-5 py-2.5 rounded-lg font-medium"
                    >
                        ← Back to Jobs
                    </a>

                </div>

            </div>

        </div>

    </main>

</body>

</html>