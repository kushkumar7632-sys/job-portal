<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Manage Jobs</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 min-h-screen">

    <!-- Navbar -->
    <nav class="bg-blue-600 text-white px-6 py-4 flex justify-between items-center">

        <h1 class="text-xl font-bold">
            Admin Panel
        </h1>

        <div class="flex items-center gap-4">

            <a href="{{ route('admin.dashboard') }}"
               class="hover:underline">
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

        <div class="mb-6">

            <h2 class="text-3xl font-bold text-gray-800">
                Manage Jobs
            </h2>

            <p class="text-gray-500 mt-1">
                View and manage all posted jobs.
            </p>

        </div>


        <!-- Success Message -->
        @if(session('success'))

            <div class="mb-6 bg-green-100 border border-green-300
                        text-green-700 px-4 py-3 rounded-lg">

                {{ session('success') }}

            </div>

        @endif


        <!-- Jobs Table -->
        <div class="bg-white rounded-xl shadow overflow-x-auto">

            <table class="w-full text-left">

                <thead class="bg-gray-50 border-b">

                    <tr>

                        <th class="px-6 py-4">
                            Job Title
                        </th>

                        <th class="px-6 py-4">
                            Company
                        </th>

                        <th class="px-6 py-4">
                            Location
                        </th>

                        <th class="px-6 py-4">
                            Type
                        </th>

                        <th class="px-6 py-4">
                            Deadline
                        </th>

                        <th class="px-6 py-4">
                            Status
                        </th>

                        <th class="px-6 py-4">
                            Action
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y">

                    @forelse($jobs as $job)

                        <tr class="hover:bg-gray-50">

                            <!-- Job Title -->
                            <td class="px-6 py-4 font-semibold">
                                {{ $job->job_title }}
                            </td>


                            <!-- Company -->
                            <td class="px-6 py-4">
                                {{ $job->company->company_name ?? 'N/A' }}
                            </td>


                            <!-- Location -->
                            <td class="px-6 py-4">
                                {{ $job->location }}
                            </td>


                            <!-- Job Type -->
                            <td class="px-6 py-4">
                                {{ $job->job_type }}
                            </td>


                            <!-- Deadline -->
                            <td class="px-6 py-4">
                                {{ $job->deadline }}
                            </td>


                            <!-- Status -->
                            <td class="px-6 py-4">

                                @if($job->status)

                                    <span class="px-3 py-1 rounded-full
                                                 text-sm font-medium
                                                 bg-green-100 text-green-700">
                                        Active
                                    </span>

                                @else

                                    <span class="px-3 py-1 rounded-full
                                                 text-sm font-medium
                                                 bg-red-100 text-red-700">
                                        Inactive
                                    </span>

                                @endif

                            </td>


                            <!-- Actions -->
                            <td class="px-6 py-4">

                                <div class="flex gap-2">

                                    <!-- View -->
                                    <a
                                        href="{{ route('admin.jobs.show', $job->id) }}"
                                        class="bg-blue-600 hover:bg-blue-700
                                               text-white px-4 py-2 rounded-lg
                                               text-sm font-medium"
                                    >
                                        View
                                    </a>


                                    <!-- Delete -->
                                    <form
                                        action="{{ route('admin.jobs.delete', $job->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this job?');"
                                    >

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="bg-red-600 hover:bg-red-700
                                                   text-white px-4 py-2 rounded-lg
                                                   text-sm font-medium"
                                        >
                                            Delete
                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>


                    @empty

                        <tr>

                            <td
                                colspan="7"
                                class="px-6 py-10 text-center text-gray-500"
                            >
                                No jobs posted yet.
                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </main>

</body>

</html>