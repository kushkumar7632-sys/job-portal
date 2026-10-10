<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Manage Applications</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen">

<div class="max-w-7xl mx-auto px-6 py-8">

    <!-- Header -->
    <div class="flex justify-between items-center mb-6">

        <div>
            <h1 class="text-3xl font-bold text-gray-800">
                Manage Applications
            </h1>

            <p class="text-gray-500 mt-1">
                View and manage student job applications
            </p>
        </div>

        <a href="{{ route('admin.dashboard') }}"
           class="bg-gray-800 text-white px-5 py-2 rounded-lg hover:bg-gray-700">
            ← Dashboard
        </a>

    </div>


    <!-- Success Message -->
    @if(session('success'))
        <div class="mb-5 bg-green-100 border border-green-300 text-green-700 px-4 py-3 rounded-lg">
            {{ session('success') }}
        </div>
    @endif


    <!-- Applications Table -->
    <div class="bg-white rounded-xl shadow overflow-hidden">

        <div class="overflow-x-auto">

            <table class="w-full text-left">

                <thead class="bg-gray-800 text-white">

                    <tr>
                        <th class="px-6 py-4">#</th>
                        <th class="px-6 py-4">Student</th>
                        <th class="px-6 py-4">Job</th>
                        <th class="px-6 py-4">Company</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Applied</th>
                        <th class="px-6 py-4">Action</th>
                    </tr>

                </thead>


                <tbody class="divide-y">

                    @forelse($applications as $application)

                        <tr class="hover:bg-gray-50">

                            <td class="px-6 py-4">
                                {{ $loop->iteration }}
                            </td>


                            <td class="px-6 py-4">

                                <div class="font-semibold text-gray-800">
                                    {{ $application->student->name ?? 'N/A' }}
                                </div>

                                <div class="text-sm text-gray-500">
                                    {{ $application->student->email ?? 'N/A' }}
                                </div>

                            </td>


                            <td class="px-6 py-4">

                                <div class="font-semibold text-gray-800">
                                    {{ $application->job->job_title ?? 'N/A' }}
                                </div>

                                <div class="text-sm text-gray-500">
                                    {{ $application->job->location ?? 'N/A' }}
                                </div>

                            </td>


                            <td class="px-6 py-4">

                                {{ $application->job->company->company_name ?? 'N/A' }}

                            </td>


                            <td class="px-6 py-4">

                                @if($application->status === 'Pending')

                                    <span class="px-3 py-1 text-sm rounded-full bg-yellow-100 text-yellow-700">
                                        Pending
                                    </span>

                                @elseif($application->status === 'Shortlisted')

                                    <span class="px-3 py-1 text-sm rounded-full bg-blue-100 text-blue-700">
                                        Shortlisted
                                    </span>

                                @elseif($application->status === 'Selected')

                                    <span class="px-3 py-1 text-sm rounded-full bg-green-100 text-green-700">
                                        Selected
                                    </span>

                                @else

                                    <span class="px-3 py-1 text-sm rounded-full bg-red-100 text-red-700">
                                        Rejected
                                    </span>

                                @endif

                            </td>


                            <td class="px-6 py-4 text-sm text-gray-600">

                                {{ $application->created_at->format('d M Y') }}

                            </td>


                            <td class="px-6 py-4">

                                <div class="flex gap-2">

                                    <a href="{{ route('admin.applications.show', $application->id) }}"
                                       class="bg-blue-600 text-white px-3 py-2 rounded-lg hover:bg-blue-700 text-sm">
                                        View
                                    </a>


                                    <form action="{{ route('admin.applications.delete', $application->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('Are you sure you want to delete this application?');">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="bg-red-600 text-white px-3 py-2 rounded-lg hover:bg-red-700 text-sm">
                                            Delete
                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="7"
                                class="px-6 py-10 text-center text-gray-500">

                                No applications found.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

</body>
</html>