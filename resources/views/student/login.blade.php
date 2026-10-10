<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Login | JobPortal</title>

    @vite('resources/css/app.css')
</head>

<body class="min-h-screen bg-slate-50">

    <!-- Main Container -->
    <div class="min-h-screen flex">

        <!-- Left Section -->
        <div class="hidden lg:flex lg:w-1/2
                    bg-gradient-to-br from-blue-700 via-blue-600 to-indigo-700
                    relative overflow-hidden
                    items-center justify-center">

            <!-- Decorative Circles -->
            <div class="absolute -top-20 -left-20 w-72 h-72
                        bg-white/10 rounded-full"></div>

            <div class="absolute -bottom-32 -right-20 w-96 h-96
                        bg-white/10 rounded-full"></div>

            <div class="relative z-10 max-w-lg px-10 text-white">

                <!-- Logo -->
                <div class="flex items-center gap-3 mb-10">

                    <div class="w-12 h-12 bg-white rounded-xl
                                flex items-center justify-center
                                shadow-lg">

                        <span class="text-blue-600 font-bold text-2xl">
                            J
                        </span>

                    </div>

                    <span class="text-3xl font-bold">
                        Job<span class="text-blue-200">Portal</span>
                    </span>

                </div>


                <h1 class="text-4xl xl:text-5xl font-bold leading-tight">
                    Find your next
                    <span class="text-blue-200">
                        career opportunity.
                    </span>
                </h1>

                <p class="mt-6 text-blue-100 text-lg leading-8">
                    Discover jobs, connect with companies and take
                    the next step toward your dream career.
                </p>


                <!-- Features -->
                <div class="mt-10 space-y-5">

                    <div class="flex items-center gap-4">

                        <div class="w-10 h-10 rounded-lg
                                    bg-white/15
                                    flex items-center justify-center">

                            ✓

                        </div>

                        <span class="text-blue-50">
                            Explore thousands of opportunities
                        </span>

                    </div>


                    <div class="flex items-center gap-4">

                        <div class="w-10 h-10 rounded-lg
                                    bg-white/15
                                    flex items-center justify-center">

                            ✓

                        </div>

                        <span class="text-blue-50">
                            Apply to jobs with ease
                        </span>

                    </div>


                    <div class="flex items-center gap-4">

                        <div class="w-10 h-10 rounded-lg
                                    bg-white/15
                                    flex items-center justify-center">

                            ✓

                        </div>

                        <span class="text-blue-50">
                            Track your applications
                        </span>

                    </div>

                </div>

            </div>

        </div>


        <!-- Right Section -->
        <div class="w-full lg:w-1/2
                    flex items-center justify-center
                    px-5 py-10">

            <div class="w-full max-w-md">


                <!-- Mobile Logo -->
                <div class="lg:hidden flex justify-center mb-8">

                    <a href="{{ route('student.login') }}"
                       class="flex items-center gap-2">

                        <div class="w-10 h-10 bg-blue-600
                                    rounded-lg
                                    flex items-center justify-center">

                            <span class="text-white font-bold text-lg">
                                J
                            </span>

                        </div>

                        <span class="text-2xl font-bold text-slate-900">
                            Job<span class="text-blue-600">Portal</span>
                        </span>

                    </a>

                </div>


                <!-- Login Card -->
                <div class="bg-white rounded-2xl
                            border border-slate-200
                            shadow-xl
                            p-7 sm:p-9">


                    <!-- Heading -->
                    <div class="mb-8">

                        <div class="w-12 h-12
                                    bg-blue-100
                                    text-blue-600
                                    rounded-xl
                                    flex items-center justify-center
                                    text-xl mb-5">

                            🔐

                        </div>

                        <h2 class="text-2xl sm:text-3xl
                                   font-bold text-slate-900">

                            Welcome back

                        </h2>

                        <p class="text-slate-500 mt-2">
                            Login to continue to your JobPortal account.
                        </p>

                    </div>


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


                    <!-- Error Message -->
                    @if(session('error'))

                        <div class="mb-5 p-4 rounded-xl
                                    bg-red-50
                                    border border-red-200
                                    text-red-700 text-sm">

                            <div class="flex gap-2">

                                <span>⚠</span>

                                <span>
                                    {{ session('error') }}
                                </span>

                            </div>

                        </div>

                    @endif


                    <!-- Validation Errors -->
                    @if($errors->any())

                        <div class="mb-5 p-4 rounded-xl
                                    bg-red-50
                                    border border-red-200
                                    text-red-700 text-sm">

                            <ul class="space-y-1 list-disc list-inside">

                                @foreach($errors->all() as $error)

                                    <li>
                                        {{ $error }}
                                    </li>

                                @endforeach

                            </ul>

                        </div>

                    @endif


                    <!-- Login Form -->
                    <form action="{{ route('student.login.submit') }}"
                          method="POST"
                          class="space-y-5">

                        @csrf


                        <!-- Email -->
                        <div>

                            <label
                                class="block text-sm font-semibold
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
                                    value="{{ old('email') }}"
                                    placeholder="you@example.com"
                                    class="w-full pl-11 pr-4 py-3.5
                                           border border-slate-300
                                           rounded-xl
                                           text-slate-800
                                           placeholder-slate-400
                                           focus:ring-2
                                           focus:ring-blue-500
                                           focus:border-blue-500
                                           focus:outline-none
                                           transition"
                                >

                            </div>

                        </div>


                        <!-- Password -->
                        <div>

                            <div class="flex items-center
                                        justify-between mb-2">

                                <label
                                    class="block text-sm font-semibold
                                           text-slate-700">

                                    Password

                                </label>

                            </div>

                            <div class="relative">

                                <span class="absolute left-4 top-1/2
                                             -translate-y-1/2
                                             text-slate-400">

                                    🔒

                                </span>

                                <input
                                    type="password"
                                    name="password"
                                    placeholder="Enter your password"
                                    class="w-full pl-11 pr-4 py-3.5
                                           border border-slate-300
                                           rounded-xl
                                           text-slate-800
                                           placeholder-slate-400
                                           focus:ring-2
                                           focus:ring-blue-500
                                           focus:border-blue-500
                                           focus:outline-none
                                           transition"
                                >

                            </div>

                        </div>


                        <!-- Login Button -->
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

                            Login to Account →

                        </button>

                    </form>


                    <!-- Register -->
                    <div class="mt-7 pt-6
                                border-t border-slate-200
                                text-center">

                        <p class="text-sm text-slate-500">

                            Don't have an account?

                            <a href="{{ route('student.register') }}"
                               class="text-blue-600
                                      font-semibold
                                      hover:text-blue-700
                                      hover:underline">

                                Create an account

                            </a>

                        </p>

                    </div>

                </div>


                <!-- Bottom Text -->
                <p class="text-center text-xs
                          text-slate-400 mt-6">

                    © {{ date('Y') }} JobPortal. All rights reserved.

                </p>

            </div>

        </div>

    </div>

</body>
</html>