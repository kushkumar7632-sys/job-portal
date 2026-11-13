<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Student Login | JobPortal</title>

    @vite('resources/css/app.css')
</head>

<body class="min-h-screen bg-white antialiased">

    <main class="grid min-h-screen lg:grid-cols-2">

        <!-- LEFT PANEL -->
        <section class="relative hidden overflow-hidden bg-[#101b35] lg:flex lg:flex-col lg:justify-between">

            <!-- BRAND -->
            <div class="relative z-10 px-14 pt-12 xl:px-20">

                <a href="{{ route('student.login') }}"
                   class="inline-flex items-center gap-3">

                    <div class="flex h-10 w-10 items-center justify-center bg-white text-xl font-bold text-[#101b35]">
                        J
                    </div>

                    <span class="text-2xl font-bold tracking-tight text-white">
                        JobPortal
                    </span>

                </a>

            </div>


            <!-- MAIN CONTENT -->
            <div class="relative z-10 max-w-xl px-14 py-12 xl:px-20">

                <p class="mb-5 text-xs font-semibold uppercase tracking-[0.2em] text-blue-300">
                    YOUR CAREER STARTS HERE
                </p>

                <h1 class="text-4xl font-semibold leading-[1.2] tracking-tight text-white xl:text-5xl">

                    Find opportunities.
                    <span class="text-blue-300">
                        Build your future.
                    </span>

                </h1>

                <p class="mt-6 max-w-md text-base leading-8 text-slate-300">

                    Connect with employers, explore career opportunities
                    and manage your job applications from one place.

                </p>


                <!-- FEATURES -->
                <div class="mt-12 space-y-6">

                    <div class="flex items-center gap-4">

                        <div class="flex h-9 w-9 items-center justify-center border border-white/20 text-blue-300">

                            <svg class="h-5 w-5" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="1.7">

                                <rect x="3" y="5" width="18" height="14" rx="2"/>
                                <path d="M7 9h10M7 13h6"/>

                            </svg>

                        </div>

                        <span class="text-sm text-slate-200">
                            Discover relevant job opportunities
                        </span>

                    </div>


                    <div class="flex items-center gap-4">

                        <div class="flex h-9 w-9 items-center justify-center border border-white/20 text-blue-300">

                            <svg class="h-5 w-5" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="1.7">

                                <path d="M8 5H5a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-3"/>
                                <rect x="8" y="3" width="8" height="5" rx="1"/>
                                <path d="M8 13h8M8 17h5"/>

                            </svg>

                        </div>

                        <span class="text-sm text-slate-200">
                            Apply and manage applications
                        </span>

                    </div>


                    <div class="flex items-center gap-4">

                        <div class="flex h-9 w-9 items-center justify-center border border-white/20 text-blue-300">

                            <svg class="h-5 w-5" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="1.7">

                                <circle cx="12" cy="12" r="9"/>
                                <path d="M12 7v5l3 2"/>

                            </svg>

                        </div>

                        <span class="text-sm text-slate-200">
                            Track your application progress
                        </span>

                    </div>

                </div>

            </div>


            <!-- FOOTER -->
            <div class="relative z-10 border-t border-white/10 px-14 py-7 xl:px-20">

                <p class="text-xs text-slate-400">
                    © {{ date('Y') }} JobPortal. All rights reserved.
                </p>

            </div>

        </section>



        <!-- RIGHT LOGIN SECTION -->
        <section class="flex min-h-screen items-center justify-center bg-[#f8fafc] px-5 py-12 sm:px-10">

            <div class="w-full max-w-[430px]">


                <!-- MOBILE BRAND -->
                <div class="mb-12 lg:hidden">

                    <a href="{{ route('student.login') }}"
                       class="inline-flex items-center gap-3">

                        <div class="flex h-10 w-10 items-center justify-center bg-[#101b35] text-xl font-bold text-white">
                            J
                        </div>

                        <span class="text-2xl font-bold text-[#101b35]">
                            JobPortal
                        </span>

                    </a>

                </div>



                <!-- HEADING -->
                <div class="mb-9">

                    <p class="mb-3 text-xs font-semibold uppercase tracking-[0.16em] text-blue-700">
                        STUDENT ACCOUNT
                    </p>

                    <h2 class="text-3xl font-semibold tracking-tight text-[#17243b] sm:text-4xl">

                        Welcome back

                    </h2>

                    <p class="mt-3 text-sm leading-6 text-slate-500">

                        Sign in to access your account and continue your career journey.

                    </p>

                </div>



                <!-- SUCCESS MESSAGE -->
                @if(session('success'))

                    <div class="mb-5 flex items-start gap-3 border border-green-200 bg-green-50 p-4 text-sm text-green-700">

                        <svg class="mt-0.5 h-5 w-5 shrink-0"
                             viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2">

                            <path d="m5 12 4 4L19 6"/>

                        </svg>

                        <span>{{ session('success') }}</span>

                    </div>

                @endif



                <!-- ERROR MESSAGE -->
                @if(session('error'))

                    <div class="mb-5 flex items-start gap-3 border border-red-200 bg-red-50 p-4 text-sm text-red-700">

                        <svg class="mt-0.5 h-5 w-5 shrink-0"
                             viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2">

                            <circle cx="12" cy="12" r="9"/>
                            <path d="M12 8v5M12 16h.01"/>

                        </svg>

                        <span>{{ session('error') }}</span>

                    </div>

                @endif



                <!-- VALIDATION ERRORS -->
                @if($errors->any())

                    <div class="mb-5 border border-red-200 bg-red-50 p-4 text-sm text-red-700">

                        <ul class="list-inside list-disc space-y-1">

                            @foreach($errors->all() as $error)

                                <li>{{ $error }}</li>

                            @endforeach

                        </ul>

                    </div>

                @endif



                <!-- LOGIN FORM -->
                <form action="{{ route('student.login.submit') }}"
                      method="POST"
                      class="space-y-6">

                    @csrf


                    <!-- EMAIL -->
                    <div>

                        <label for="email"
                               class="mb-2 block text-sm font-semibold text-slate-700">

                            Email address

                        </label>

                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="name@example.com"
                            autocomplete="email"
                            required

                            class="h-12 w-full border border-slate-300 bg-white px-4 text-sm text-slate-800 outline-none transition placeholder:text-slate-400 hover:border-slate-400 focus:border-blue-700 focus:ring-2 focus:ring-blue-700/10"
                        >

                    </div>



                    <!-- PASSWORD -->
                    <div>

                        <div class="mb-2 flex items-center justify-between">

                            <label for="password"
                                   class="block text-sm font-semibold text-slate-700">

                                Password

                            </label>

                        </div>


                        <div class="relative">

                            <input
                                type="password"
                                id="password"
                                name="password"
                                placeholder="Enter your password"
                                autocomplete="current-password"
                                required

                                class="h-12 w-full border border-slate-300 bg-white px-4 pr-12 text-sm text-slate-800 outline-none transition placeholder:text-slate-400 hover:border-slate-400 focus:border-blue-700 focus:ring-2 focus:ring-blue-700/10"
                            >


                            <!-- PASSWORD VISIBILITY -->
                            <button
                                type="button"
                                id="togglePassword"
                                aria-label="Show password"

                                class="absolute inset-y-0 right-0 flex w-12 items-center justify-center text-slate-400 transition hover:text-slate-700">

                                <svg id="eyeIcon"
                                     class="h-5 w-5"
                                     viewBox="0 0 24 24"
                                     fill="none"
                                     stroke="currentColor"
                                     stroke-width="1.7">

                                    <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12Z"/>
                                    <circle cx="12" cy="12" r="3"/>

                                </svg>

                            </button>

                        </div>

                    </div>



                    <!-- SUBMIT BUTTON -->
                    <button
                        type="submit"

                        class="flex h-12 w-full items-center justify-center gap-3 bg-[#1746a2] px-5 text-sm font-semibold text-white transition hover:bg-[#123982] focus:outline-none focus:ring-4 focus:ring-blue-700/20">

                        Sign in

                        <svg class="h-4 w-4"
                             viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="1.8">

                            <path d="M5 12h14M13 6l6 6-6 6"/>

                        </svg>

                    </button>

                </form>



                <!-- REGISTER LINK -->
                <div class="mt-8 border-t border-slate-200 pt-7 text-center">

                    <p class="text-sm text-slate-500">

                        Don't have an account?

                        <a href="{{ route('student.register') }}"
                           class="ml-1 font-semibold text-blue-700 transition hover:text-blue-900">

                            Create an account

                        </a>

                    </p>

                </div>



                <!-- FOOTER -->
                <div class="mt-12 text-center">

                    <p class="text-xs text-slate-400">

                        © {{ date('Y') }} JobPortal. All rights reserved.

                    </p>

                </div>


            </div>

        </section>

    </main>



    <!-- PASSWORD TOGGLE -->
    <script>

        const passwordInput = document.getElementById('password');

        const togglePassword = document.getElementById('togglePassword');

        const eyeIcon = document.getElementById('eyeIcon');


        togglePassword.addEventListener('click', function () {

            const isPassword = passwordInput.type === 'password';

            passwordInput.type = isPassword ? 'text' : 'password';

            togglePassword.setAttribute(
                'aria-label',
                isPassword ? 'Hide password' : 'Show password'
            );

            eyeIcon.innerHTML = isPassword

                ? `<path d="M3 3l18 18M10.6 10.6a2 2 0 0 0 2.8 2.8"/>
                   <path d="M9.9 5.2A10.7 10.7 0 0 1 12 5c6.5 0 10 7 10 7a16 16 0 0 1-4 4.8"/>
                   <path d="M6.2 6.2A16 16 0 0 0 2 12s3.5 7 10 7a10.7 10.7 0 0 0 2.1-.2"/>`

                : `<path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12Z"/>
                   <circle cx="12" cy="12" r="3"/>`;

        });

    </script>

</body>
</html>