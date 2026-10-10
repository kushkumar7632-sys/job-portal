<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard | Job Portal</title>

    @vite('resources/css/app.css')
</head>

<body class="bg-slate-50 text-slate-800">

    <!-- Navbar -->
    <nav class="bg-white border-b border-slate-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="h-16 flex items-center justify-between">

                <!-- Logo -->
                <a href="{{ route('student.jobs') }}"
                   class="flex items-center gap-2">

                    <div class="w-9 h-9 bg-blue-600 rounded-lg flex items-center justify-center">
                        <span class="text-white font-bold text-lg">J</span>
                    </div>

                    <span class="text-xl font-bold text-slate-900">
                        Job<span class="text-blue-600">Portal</span>
                    </span>

                </a>

                <!-- Right Side -->
                <div class="flex items-center gap-4">

                    <div class="hidden sm:block text-right">
                        <p class="text-xs text-slate-500">
                            Welcome back
                        </p>

                        <p class="font-semibold text-slate-800">
                            {{ session('student_name') }}
                        </p>
                    </div>

                    <!-- Profile Circle -->
                    <div class="w-10 h-10 bg-blue-100 text-blue-600
                                rounded-full flex items-center justify-center
                                font-bold">
                        {{ strtoupper(substr(session('student_name'), 0, 1)) }}
                    </div>

                    <!-- Logout -->
                    <a href="{{ route('student.logout') }}"
                       class="hidden sm:inline-flex items-center
                              px-4 py-2 rounded-lg
                              border border-red-200
                              text-red-600
                              hover:bg-red-50
                              transition duration-200">

                        Logout
                    </a>

                </div>

            </div>

        </div>
    </nav>


    <!-- Main Dashboard -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <!-- Welcome Section -->
        <div class="bg-gradient-to-r from-blue-600 to-indigo-600
                    rounded-2xl p-6 md:p-8 text-white
                    shadow-lg mb-8">

            <div class="flex flex-col md:flex-row
                        md:items-center md:justify-between gap-6">

                <div>

                    <p class="text-blue-100 text-sm font-medium mb-2">
                        STUDENT DASHBOARD
                    </p>

                    <h1 class="text-2xl md:text-3xl font-bold">
                        Welcome back, {{ session('student_name') }} 👋
                    </h1>

                    <p class="text-blue-100 mt-2">
                        Find the right opportunity and take the next step
                        in your career.
                    </p>

                </div>

                <!-- Browse Jobs -->
                <a href="{{ route('student.jobs') }}"
                   class="inline-flex items-center justify-center
                          bg-white text-blue-600
                          font-semibold
                          px-6 py-3
                          rounded-xl
                          hover:bg-blue-50
                          transition duration-200
                          shadow-sm">

                    Browse Jobs
                    <span class="ml-2">→</span>

                </a>

            </div>

        </div>


        <!-- Quick Stats -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-8">

            <!-- Profile -->
            <div class="bg-white border border-slate-200
                        rounded-xl p-5 shadow-sm">

                <div class="flex items-center gap-4">

                    <div class="w-12 h-12 rounded-xl
                                bg-blue-100 text-blue-600
                                flex items-center justify-center
                                text-xl">

                        👤

                    </div>

                    <div>

                        <p class="text-sm text-slate-500">
                            Profile
                        </p>

                        <p class="text-lg font-bold text-slate-800">
                            Student Profile
                        </p>

                    </div>

                </div>

            </div>


            <!-- Resume -->
            <div class="bg-white border border-slate-200
                        rounded-xl p-5 shadow-sm">

                <div class="flex items-center gap-4">

                    <div class="w-12 h-12 rounded-xl
                                bg-green-100 text-green-600
                                flex items-center justify-center
                                text-xl">

                        📄

                    </div>

                    <div>

                        <p class="text-sm text-slate-500">
                            Resume
                        </p>

                        <p class="text-lg font-bold text-slate-800">
                            Manage Resume
                        </p>

                    </div>

                </div>

            </div>


            <!-- Applications -->
            <div class="bg-white border border-slate-200
                        rounded-xl p-5 shadow-sm">

                <div class="flex items-center gap-4">

                    <div class="w-12 h-12 rounded-xl
                                bg-purple-100 text-purple-600
                                flex items-center justify-center
                                text-xl">

                        💼

                    </div>

                    <div>

                        <p class="text-sm text-slate-500">
                            Applications
                        </p>

                        <p class="text-lg font-bold text-slate-800">
                            My Applications
                        </p>

                    </div>

                </div>

            </div>

        </div>


        <!-- Dashboard Cards -->
        <div class="mb-5">

            <h2 class="text-xl font-bold text-slate-900">
                Quick Actions
            </h2>

            <p class="text-sm text-slate-500 mt-1">
                Manage your job search from here.
            </p>

        </div>


        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">


            <!-- Profile Card -->
            <div class="bg-white border border-slate-200
                        rounded-2xl p-6
                        hover:shadow-lg hover:-translate-y-1
                        transition duration-300">

                <div class="w-12 h-12 rounded-xl
                            bg-blue-50 text-blue-600
                            flex items-center justify-center
                            text-xl mb-5">

                    👤

                </div>

                <h3 class="text-lg font-bold text-slate-900">
                    Your Profile
                </h3>

                <p class="text-sm text-slate-500 mt-2 leading-6">
                    Keep your personal and professional information
                    updated for better job opportunities.
                </p>

                <button
                    class="mt-5 w-full border border-blue-200
                           text-blue-600 font-semibold
                           py-2.5 rounded-lg
                           hover:bg-blue-50 transition">

                    View Profile

                </button>

            </div>


            <!-- Resume Card -->
            <div class="bg-white border border-slate-200
                        rounded-2xl p-6
                        hover:shadow-lg hover:-translate-y-1
                        transition duration-300">

                <div class="w-12 h-12 rounded-xl
                            bg-green-50 text-green-600
                            flex items-center justify-center
                            text-xl mb-5">

                    📄

                </div>

                <h3 class="text-lg font-bold text-slate-900">
                    Resume
                </h3>

                <p class="text-sm text-slate-500 mt-2 leading-6">
                    Keep your latest resume ready so you can apply
                    to jobs quickly.
                </p>

                <button
                    class="mt-5 w-full border border-green-200
                           text-green-600 font-semibold
                           py-2.5 rounded-lg
                           hover:bg-green-50 transition">

                    Manage Resume

                </button>

            </div>


            <!-- Applications Card -->
            <div class="bg-white border border-slate-200
                        rounded-2xl p-6
                        hover:shadow-lg hover:-translate-y-1
                        transition duration-300">

                <div class="w-12 h-12 rounded-xl
                            bg-purple-50 text-purple-600
                            flex items-center justify-center
                            text-xl mb-5">

                    💼

                </div>

                <h3 class="text-lg font-bold text-slate-900">
                    Applied Jobs
                </h3>

                <p class="text-sm text-slate-500 mt-2 leading-6">
                    Track the jobs you have applied for and check
                    your application status.
                </p>

                <a href="{{ route('student.applications') }}"
                   class="mt-5 block w-full text-center
                          bg-purple-600
                          hover:bg-purple-700
                          text-white font-semibold
                          py-2.5 rounded-lg
                          transition duration-200">

                    My Applications

                </a>

            </div>

        </div>


        <!-- Browse Jobs CTA -->
        <div class="mt-8 bg-white border border-slate-200
                    rounded-2xl p-6
                    flex flex-col md:flex-row
                    md:items-center md:justify-between gap-5">

            <div>

                <h3 class="text-lg font-bold text-slate-900">
                    Looking for your next opportunity?
                </h3>

                <p class="text-sm text-slate-500 mt-1">
                    Explore the latest jobs and find the right role for you.
                </p>

            </div>

            <a href="{{ route('student.jobs') }}"
               class="inline-flex items-center justify-center
                      bg-blue-600 hover:bg-blue-700
                      text-white font-semibold
                      px-6 py-3 rounded-lg
                      transition duration-200">

                Explore Jobs →
                
            </a>

        </div>

    </main>


    <!-- Footer -->
    <footer class="border-t border-slate-200 mt-10">

        <div class="max-w-7xl mx-auto px-4 py-6 text-center">

            <p class="text-sm text-slate-500">
                © {{ date('Y') }} JobPortal. All rights reserved.
            </p>

        </div>

    </footer>

</body>
</html>