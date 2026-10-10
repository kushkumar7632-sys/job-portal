<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Manage Students</title>

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
                Manage Students
            </h2>

            <p class="text-gray-500 mt-1">
                View and manage registered students.
            </p>

        </div>


        <!-- Success Message -->
        @if(session('success'))

            <div class="mb-6 bg-green-100 border border-green-300
                        text-green-700 px-4 py-3 rounded-lg">

                {{ session('success') }}

            </div>

        @endif


        <!-- Students Table -->
        <div class="bg-white rounded-xl shadow overflow-x-auto">

            <table class="w-full text-left">

                <thead class="bg-gray-50 border-b">

                    <tr>

                        <th class="px-6 py-4">
                            Name
                        </th>

                        <th class="px-6 py-4">
                            Email
                        </th>

                        <th class="px-6 py-4">
                            Phone
                        </th>

                        <th class="px-6 py-4">
                            Action
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y">

                    @forelse($students as $student)

                        <tr class="hover:bg-gray-50">

                            <!-- Name -->
                            <td class="px-6 py-4 font-semibold">
                                {{ $student->name }}
                            </td>


                            <!-- Email -->
                            <td class="px-6 py-4">
                                {{ $student->email }}
                            </td>


                            <!-- Phone -->
                            <td class="px-6 py-4">
                                {{ $student->phone }}
                            </td>


                            <!-- Actions -->
                            <td class="px-6 py-4">

                                <div class="flex gap-2">

                                    <!-- View -->
                                    <a
                                        href="{{ route('admin.students.show', $student->id) }}"
                                        class="bg-blue-600 hover:bg-blue-700
                                               text-white px-4 py-2 rounded-lg
                                               text-sm font-medium"
                                    >
                                        View
                                    </a>


                                    <!-- Delete -->
                                    <form
                                        action="{{ route('admin.students.delete', $student->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this student?');"
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
                                colspan="4"
                                class="px-6 py-10 text-center text-gray-500"
                            >
                                No students registered yet.
                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </main>

</body>

</html>