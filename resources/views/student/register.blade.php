<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration | JobPortal</title>

    @vite(['resources/css/app.css','resources/js/app.js'])
</head>

<body class="min-h-screen bg-slate-50">

    <div class="min-h-screen flex">

        <!-- ================= LEFT SECTION ================= -->
        <div class="hidden lg:flex lg:w-1/2
                    bg-gradient-to-br from-blue-700 via-blue-600 to-indigo-700
                    relative overflow-hidden
                    items-center justify-center">

            <!-- Decorative circles -->
            <div class="absolute -top-24 -left-24
                        w-80 h-80 bg-white/10 rounded-full"></div>

            <div class="absolute -bottom-32 -right-20
                        w-96 h-96 bg-white/10 rounded-full"></div>

            <div class="relative z-10 max-w-lg px-10 text-white">

                <!-- Logo -->
                <div class="flex items-center gap-3 mb-10">

                    <div class="w-12 h-12 bg-white rounded-xl
                                flex items-center justify-center shadow-lg">

                        <span class="text-blue-600 font-bold text-2xl">
                            J
                        </span>

                    </div>

                    <span class="text-3xl font-bold">
                        Job<span class="text-blue-200">Portal</span>
                    </span>

                </div>


                <!-- Main Heading -->
                <h1 class="text-4xl xl:text-5xl
                           font-bold leading-tight">

                    Start your
                    <span class="text-blue-200">
                        career journey.
                    </span>

                </h1>


                <p class="mt-6 text-blue-100
                          text-lg leading-8">

                    Create your student account and discover
                    exciting career opportunities from companies
                    looking for talented people like you.

                </p>


                <!-- Benefits -->
                <div class="mt-10 space-y-5">

                    <div class="flex items-center gap-4">

                        <div class="w-10 h-10 rounded-lg
                                    bg-white/15
                                    flex items-center justify-center
                                    text-lg">

                            ✓

                        </div>

                        <span class="text-blue-50">
                            Discover relevant job opportunities
                        </span>

                    </div>


                    <div class="flex items-center gap-4">

                        <div class="w-10 h-10 rounded-lg
                                    bg-white/15
                                    flex items-center justify-center
                                    text-lg">

                            ✓

                        </div>

                        <span class="text-blue-50">
                            Apply to jobs easily
                        </span>

                    </div>


                    <div class="flex items-center gap-4">

                        <div class="w-10 h-10 rounded-lg
                                    bg-white/15
                                    flex items-center justify-center
                                    text-lg">

                            ✓

                        </div>

                        <span class="text-blue-50">
                            Track your applications
                        </span>

                    </div>

                </div>

            </div>

        </div>


        <!-- ================= RIGHT SECTION ================= -->
        <div class="w-full lg:w-1/2
                    flex items-center justify-center
                    px-5 py-10">

            <div class="w-full max-w-md">


                <!-- Mobile Logo -->
                <div class="lg:hidden flex justify-center mb-7">

                    <a href="{{ route('student.login') }}"
                       class="flex items-center gap-2">

                        <div class="w-10 h-10 bg-blue-600
                                    rounded-lg flex items-center
                                    justify-center">

                            <span class="text-white font-bold text-lg">
                                J
                            </span>

                        </div>

                        <span class="text-2xl font-bold text-slate-900">
                            Job<span class="text-blue-600">Portal</span>
                        </span>

                    </a>

                </div>


                <!-- Registration Card -->
                <div class="bg-white
                            border border-slate-200
                            rounded-2xl
                            shadow-xl
                            p-7 sm:p-9">


                    <!-- Heading -->
                    <div class="mb-7">

                        <div class="w-12 h-12
                                    bg-blue-100
                                    text-blue-600
                                    rounded-xl
                                    flex items-center justify-center
                                    text-xl mb-5">

                            👨‍🎓

                        </div>


                        <h2 class="text-2xl sm:text-3xl
                                   font-bold text-slate-900">

                            Create your account

                        </h2>


                        <p class="text-slate-500 mt-2">

                            Join JobPortal and start exploring
                            career opportunities.

                        </p>

                    </div>


                    <!-- Validation Errors -->
                    @if($errors->any())

                        <div class="mb-5 p-4 rounded-xl
                                    bg-red-50
                                    border border-red-200
                                    text-red-700 text-sm">

                            <div class="font-semibold mb-2">
                                Please fix the following:
                            </div>

                            <ul class="list-disc list-inside space-y-1">

                                @foreach($errors->all() as $error)

                                    <li>
                                        {{ $error }}
                                    </li>

                                @endforeach

                            </ul>

                        </div>

                    @endif


                    <!-- Success Message -->
                    @if(session('success'))

                        <div class="mb-5 p-4 rounded-xl
                                    bg-green-50
                                    border border-green-200
                                    text-green-700 text-sm">

                            <div class="flex gap-2">

                                <span>✓</span>

                                <span>
                                    {{ session('success') }}
                                </span>

                            </div>

                        </div>

                    @endif


                    <!-- ================= FORM ================= -->
                    <form action="/student/store"
                          method="POST"
                          class="space-y-5">

                        @csrf


                        <!-- Full Name -->
                        <div>

                            <label class="block text-sm
                                          font-semibold
                                          text-slate-700 mb-2">

                                Full Name

                            </label>

                            <div class="relative">

                                <span class="absolute left-4 top-1/2
                                             -translate-y-1/2
                                             text-slate-400">

                                    👤

                                </span>

                                <input
                                    type="text"
                                    name="name"
                                    placeholder="Enter your full name"
                                    class="w-full pl-11 pr-4 py-3.5
                                           border border-slate-300
                                           rounded-xl
                                           focus:ring-2
                                           focus:ring-blue-500
                                           focus:border-blue-500
                                           focus:outline-none
                                           transition">

                            </div>

                        </div>


                        <!-- Email -->
                        <div>

                            <label class="block text-sm
                                          font-semibold
                                          text-slate-700 mb-2">

                                Email Address

                            </label>

                            <div class="relative">

                                <span class="absolute left-4 top-1/2
                                             -translate-y-1/2
                                             text-slate-400">

                                    ✉

                                </span>

                                <input
                                    type="email"
                                    name="email"
                                    placeholder="you@example.com"
                                    class="w-full pl-11 pr-4 py-3.5
                                           border border-slate-300
                                           rounded-xl
                                           focus:ring-2
                                           focus:ring-blue-500
                                           focus:border-blue-500
                                           focus:outline-none
                                           transition">

                            </div>

                        </div>


                        <!-- Phone -->
                        <div>

                            <label class="block text-sm
                                          font-semibold
                                          text-slate-700 mb-2">

                                Phone Number

                            </label>

                            <div class="relative">

                                <span class="absolute left-4 top-1/2
                                             -translate-y-1/2
                                             text-slate-400">

                                    📱

                                </span>

                                <input
                                    type="text"
                                    name="phone"
                                    placeholder="Enter your phone number"
                                    class="w-full pl-11 pr-4 py-3.5
                                           border border-slate-300
                                           rounded-xl
                                           focus:ring-2
                                           focus:ring-blue-500
                                           focus:border-blue-500
                                           focus:outline-none
                                           transition">

                            </div>

                        </div>


                        <!-- Password -->
                        <div>

                            <label class="block text-sm
                                          font-semibold
                                          text-slate-700 mb-2">

                                Password

                            </label>

                            <div class="relative">

                                <span class="absolute left-4 top-1/2
                                             -translate-y-1/2
                                             text-slate-400">

                                    🔒

                                </span>

                                <input
                                    type="password"
                                    name="password"
                                    placeholder="Create a password"
                                    class="w-full pl-11 pr-4 py-3.5
                                           border border-slate-300
                                           rounded-xl
                                           focus:ring-2
                                           focus:ring-blue-500
                                           focus:border-blue-500
                                           focus:outline-none
                                           transition">

                            </div>

                        </div>


                        <!-- Confirm Password -->
                        <div>

                            <label class="block text-sm
                                          font-semibold
                                          text-slate-700 mb-2">

                                Confirm Password

                            </label>

                            <div class="relative">

                                <span class="absolute left-4 top-1/2
                                             -translate-y-1/2
                                             text-slate-400">

                                    🔒

                                </span>

                                <input
                                    type="password"
                                    name="password_confirmation"
                                    placeholder="Confirm your password"
                                    class="w-full pl-11 pr-4 py-3.5
                                           border border-slate-300
                                           rounded-xl
                                           focus:ring-2
                                           focus:ring-blue-500
                                           focus:border-blue-500
                                           focus:outline-none
                                           transition">

                            </div>

                        </div>


                        <!-- Register Button -->
                        <button
                            type="submit"
                            class="w-full
                                   bg-blue-600
                                   hover:bg-blue-700
                                   active:bg-blue-800
                                   text-white
                                   font-semibold
                                   py-3.5
                                   rounded-xl
                                   shadow-md
                                   hover:shadow-lg
                                   transition duration-200">

                            Create Account →

                        </button>

                    </form>


                    <!-- Login Link -->
                    <div class="mt-7 pt-6
                                border-t border-slate-200
                                text-center">

                        <p class="text-sm text-slate-500">

                            Already have an account?

                            <a href="{{ route('student.login') }}"
                               class="text-blue-600
                                      font-semibold
                                      hover:text-blue-700
                                      hover:underline">

                                Login here

                            </a>

                        </p>

                    </div>

                </div>


                <!-- Footer -->
                <p class="text-center text-xs
                          text-slate-400 mt-6">

                    © {{ date('Y') }} JobPortal. All rights reserved.

                </p>

            </div>

        </div>

    </div>

</body>
</html>