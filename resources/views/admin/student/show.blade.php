<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Student Details</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 min-h-screen">

    <!-- Navbar -->
    <nav class="bg-blue-600 text-white px-6 py-4 flex justify-between items-center">

        <h1 class="text-xl font-bold">
            Admin Panel
        </h1>

        <div class="flex items-center gap-4">

            <a href="{{ route('admin.students') }}"
               class="hover:underline">
                Students
            </a>

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

        <div class="max-w-2xl mx-auto">

            <div class="bg-white rounded-2xl shadow p-8">

                <h2 class="text-3xl font-bold text-gray-800 mb-6">
                    Student Details
                </h2>


                <!-- Student Information -->

                <div class="space-y-5">

                    <div>
                        <p class="text-sm text-gray-500">
                            Name
                        </p>

                        <p class="text-lg font-semibold text-gray-800">
                            {{ $student->name }}
                        </p>
                    </div>


                    <div>
                        <p class="text-sm text-gray-500">
                            Email
                        </p>

                        <p class="text-lg font-semibold text-gray-800">
                            {{ $student->email }}
                        </p>
                    </div>


                    <div>
                        <p class="text-sm text-gray-500">
                            Phone
                        </p>

                        <p class="text-lg font-semibold text-gray-800">
                            {{ $student->phone }}
                        </p>
                    </div>


                    <div>
                        <p class="text-sm text-gray-500">
                            Registered On
                        </p>

                        <p class="text-lg font-semibold text-gray-800">
                            {{ $student->created_at->format('d M Y, h:i A') }}
                        </p>
                    </div>

                </div>


                <!-- Back Button -->

                <div class="mt-8">

                    <a
                        href="{{ route('admin.students') }}"
                        class="inline-block bg-blue-600 hover:bg-blue-700
                               text-white px-5 py-2.5 rounded-lg
                               font-medium"
                    >
                        ← Back to Students
                    </a>

                </div>

            </div>

        </div>

    </main>

</body>

</html>