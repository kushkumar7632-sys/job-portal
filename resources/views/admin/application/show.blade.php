<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Application Details</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen">

<div class="max-w-5xl mx-auto px-6 py-8">

    <!-- Header -->
    <div class="flex justify-between items-center mb-6">

        <div>
            <h1 class="text-3xl font-bold text-gray-800">
                Application Details
            </h1>

            <p class="text-gray-500 mt-1">
                View complete application information
            </p>
        </div>

        <a href="{{ route('admin.applications') }}"
           class="bg-gray-800 text-white px-5 py-2 rounded-lg hover:bg-gray-700">
            ← Applications
        </a>

    </div>


    <!-- Student Information -->
    <div class="bg-white rounded-xl shadow p-6 mb-6">

        <h2 class="text-xl font-bold text-gray-800 mb-4">
            Student Information
        </h2>

        <div class="grid md:grid-cols-2 gap-4">

            <div>
                <p class="text-sm text-gray-500">Name</p>
                <p class="font-semibold text-gray-800">
                    {{ $application->student->name ?? 'N/A' }}
                </p>
            </div>

            <div>
                <p class="text-sm text-gray-500">Email</p>
                <p class="font-semibold text-gray-800">
                    {{ $application->student->email ?? 'N/A' }}
                </p>
            </div>

            <div>
                <p class="text-sm text-gray-500">Phone</p>
                <p class="font-semibold text-gray-800">
                    {{ $application->student->phone ?? 'N/A' }}
                </p>
            </div>

        </div>

    </div>


    <!-- Job Information -->
    <div class="bg-white rounded-xl shadow p-6 mb-6">

        <h2 class="text-xl font-bold text-gray-800 mb-4">
            Job Information
        </h2>

        <div class="grid md:grid-cols-2 gap-4">

            <div>
                <p class="text-sm text-gray-500">Job Title</p>
                <p class="font-semibold text-gray-800">
                    {{ $application->job->job_title ?? 'N/A' }}
                </p>
            </div>

            <div>
                <p class="text-sm text-gray-500">Company</p>
                <p class="font-semibold text-gray-800">
                    {{ $application->job->company->company_name ?? 'N/A' }}
                </p>
            </div>

            <div>
                <p class="text-sm text-gray-500">Location</p>
                <p class="font-semibold text-gray-800">
                    {{ $application->job->location ?? 'N/A' }}
                </p>
            </div>

            <div>
                <p class="text-sm text-gray-500">Job Type</p>
                <p class="font-semibold text-gray-800">
                    {{ $application->job->job_type ?? 'N/A' }}
                </p>
            </div>

        </div>

    </div>


    <!-- Application Information -->
    <div class="bg-white rounded-xl shadow p-6">

        <h2 class="text-xl font-bold text-gray-800 mb-4">
            Application Information
        </h2>

        <div class="grid md:grid-cols-2 gap-4">

            <div>
                <p class="text-sm text-gray-500">Status</p>

                <span class="inline-block mt-1 px-3 py-1 rounded-full text-sm
                    @if($application->status === 'Pending')
                        bg-yellow-100 text-yellow-700
                    @elseif($application->status === 'Shortlisted')
                        bg-blue-100 text-blue-700
                    @elseif($application->status === 'Selected')
                        bg-green-100 text-green-700
                    @else
                        bg-red-100 text-red-700
                    @endif
                ">
                    {{ $application->status }}
                </span>
            </div>


            <div>
                <p class="text-sm text-gray-500">Applied On</p>

                <p class="font-semibold text-gray-800">
                    {{ $application->created_at->format('d M Y, h:i A') }}
                </p>
            </div>


            <div>
                <p class="text-sm text-gray-500">Resume</p>

                @if($application->resume)

                    <a href="{{ asset('storage/' . $application->resume) }}"
                       target="_blank"
                       class="inline-block mt-1 text-blue-600 hover:underline">
                        View Resume →
                    </a>

                @else

                    <p class="text-gray-500 mt-1">
                        No resume uploaded
                    </p>

                @endif

            </div>

        </div>

    </div>

</div>

</body>
</html>