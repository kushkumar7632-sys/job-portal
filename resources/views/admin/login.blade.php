<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Admin Login | JobPortal</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-slate-50 flex items-center justify-center px-5">

    <div class="w-full max-w-md">

        <!-- Logo / Brand -->
        <div class="text-center mb-8">

            <div
                class="mx-auto w-14 h-14 rounded-2xl
                       bg-blue-600 text-white
                       flex items-center justify-center
                       text-xl font-bold shadow-lg shadow-blue-200">

                JP

            </div>

            <h1 class="text-2xl font-bold text-slate-900 mt-4">
                JobPortal
            </h1>

            <p class="text-sm text-slate-500 mt-1">
                Administration Panel
            </p>

        </div>


        <!-- Login Card -->

        <div
            class="bg-white border border-slate-200
                   rounded-2xl shadow-xl shadow-slate-200/60
                   p-7 sm:p-8">


            <!-- Header -->

            <div class="mb-7">

                <h2 class="text-2xl font-bold text-slate-900">
                    Admin Login
                </h2>

                <p class="text-sm text-slate-500 mt-2">
                    Sign in to manage your JobPortal.
                </p>

            </div>


            <!-- Error Messages -->

            @if ($errors->any())

                <div
                    class="mb-6 flex gap-3
                           rounded-xl bg-red-50
                           border border-red-200
                           p-4">

                    <div
                        class="flex-shrink-0 w-8 h-8 rounded-lg
                               bg-red-100 text-red-600
                               flex items-center justify-center">

                        !

                    </div>

                    <div>

                        <p class="text-sm font-semibold text-red-700">
                            Login failed
                        </p>

                        <ul class="mt-1 text-sm text-red-600 space-y-1">

                            @foreach ($errors->all() as $error)

                                <li>
                                    {{ $error }}
                                </li>

                            @endforeach

                        </ul>

                    </div>

                </div>

            @endif


            <!-- Login Form -->

            <form
                action="{{ route('admin.login.submit') }}"
                method="POST">

                @csrf


                <!-- Email -->

                <div class="mb-5">

                    <label
                        for="email"
                        class="block text-sm font-semibold
                               text-slate-700 mb-2">

                        Email Address

                    </label>


                    <div class="relative">

                        <div
                            class="absolute left-0 top-0 h-full
                                   w-11 flex items-center justify-center
                                   text-slate-400">

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="w-5 h-5"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor">

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M3 8l9 6 9-6M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />

                            </svg>

                        </div>


                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            autofocus
                            autocomplete="email"
                            placeholder="admin@example.com"
                            class="w-full pl-11 pr-4 py-3
                                   border border-slate-300
                                   rounded-xl
                                   text-sm text-slate-800
                                   placeholder-slate-400
                                   outline-none
                                   transition
                                   focus:border-blue-500
                                   focus:ring-4
                                   focus:ring-blue-100">

                    </div>

                </div>


                <!-- Password -->

                <div class="mb-6">

                    <label
                        for="password"
                        class="block text-sm font-semibold
                               text-slate-700 mb-2">

                        Password

                    </label>


                    <div class="relative">

                        <div
                            class="absolute left-0 top-0 h-full
                                   w-11 flex items-center justify-center
                                   text-slate-400">

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="w-5 h-5"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor">

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />

                            </svg>

                        </div>


                        <input
                            type="password"
                            id="password"
                            name="password"
                            required
                            autocomplete="current-password"
                            placeholder="Enter your password"
                            class="w-full pl-11 pr-4 py-3
                                   border border-slate-300
                                   rounded-xl
                                   text-sm text-slate-800
                                   placeholder-slate-400
                                   outline-none
                                   transition
                                   focus:border-blue-500
                                   focus:ring-4
                                   focus:ring-blue-100">

                    </div>

                </div>


                <!-- Login Button -->

                <button
                    type="submit"
                    class="w-full flex items-center justify-center
                           gap-2
                           bg-blue-600
                           hover:bg-blue-700
                           active:bg-blue-800
                           text-white
                           font-semibold
                           py-3.5
                           rounded-xl
                           shadow-sm
                           shadow-blue-200
                           transition
                           duration-200">

                    <span>
                        Sign in to Admin Panel
                    </span>

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="w-5 h-5"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor">

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M13 7l5 5m0 0l-5 5m5-5H6" />

                    </svg>

                </button>

            </form>


            <!-- Security Note -->

            <div
                class="mt-6 pt-5
                       border-t border-slate-100
                       flex items-center justify-center gap-2">

                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="w-4 h-4 text-emerald-500"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor">

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M9 12l2 2 4-4m5-2a9 9 0 11-18 0 9 9 0 0118 0z" />

                </svg>

                <p class="text-xs text-slate-400">
                    Secure administrator access
                </p>

            </div>

        </div>


        <!-- Footer -->

        <p class="text-center text-xs text-slate-400 mt-6">
            © {{ date('Y') }} JobPortal. All rights reserved.
        </p>

    </div>

</body>

</html>