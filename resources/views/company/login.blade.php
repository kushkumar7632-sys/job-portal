<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Company Login | JobPortal</title>

    @vite('resources/css/app.css')
</head>

<body class="bg-slate-50 min-h-screen">

    <!-- ================= HEADER ================= -->
    <header class="bg-white border-b border-slate-200">

        <div class="w-full px-6 lg:px-12 py-5 flex items-center justify-between">

            <!-- Logo -->
            <div class="flex items-center gap-3">

                <div class="w-11 h-11 rounded-xl bg-blue-600
                            text-white flex items-center justify-center
                            text-xl font-bold">
                    J
                </div>

                <span class="text-2xl font-bold text-slate-900">
                    Job<span class="text-blue-600">Portal</span>
                </span>

            </div>


            <!-- Register -->
            <div class="flex items-center gap-3">

                <span class="hidden sm:block text-sm text-slate-500">
                    Don't have an account?
                </span>

                <a href="/company/register"
                   class="px-5 py-2.5 rounded-xl
                          border border-blue-600
                          text-blue-600 font-semibold
                          hover:bg-blue-600 hover:text-white
                          transition">

                    Register

                </a>

            </div>

        </div>

    </header>


    <!-- ================= LOGIN ================= -->
    <main class="min-h-[calc(100vh-81px)]
                 flex items-center justify-center
                 px-6 sm:px-12 lg:px-24
                 py-12">

        <div class="w-full max-w-2xl">

            <!-- Heading -->
            <div class="text-center mb-10">

                <p class="text-sm font-bold text-blue-600
                          uppercase tracking-wider mb-3">

                    Company Login

                </p>

                <h1 class="text-4xl lg:text-5xl
                           font-bold text-slate-900">

                    Sign in to your account

                </h1>

                <p class="text-slate-500 text-lg mt-3">

                    Login to manage your company and job postings.

                </p>

            </div>


            <!-- ================= ERROR ================= -->
            @if(session('error'))

                <div class="mb-6 bg-red-50
                            border border-red-200
                            rounded-xl p-4">

                    <div class="flex gap-3">

                        <span class="text-red-500">
                            ⚠️
                        </span>

                        <div>

                            <p class="font-semibold text-red-700">
                                Login failed
                            </p>

                            <p class="text-sm text-red-600 mt-1">
                                {{ session('error') }}
                            </p>

                        </div>

                    </div>

                </div>

            @endif


            <!-- ================= SUCCESS ================= -->
            @if(session('success'))

                <div class="mb-6 bg-green-50
                            border border-green-200
                            rounded-xl p-4">

                    <div class="flex gap-3">

                        <span class="text-green-600">
                            ✓
                        </span>

                        <div>

                            <p class="font-semibold text-green-700">
                                Success
                            </p>

                            <p class="text-sm text-green-600 mt-1">
                                {{ session('success') }}
                            </p>

                        </div>

                    </div>

                </div>

            @endif


            <!-- ================= FORM ================= -->
            <form action="/company/login"
                  method="POST"
                  class="space-y-7">

                @csrf


                <!-- Email -->
                <div>

                    <label class="block text-sm font-semibold
                                  text-slate-700 mb-2">

                        Email Address

                    </label>

                    <input
                        type="email"
                        name="email"
                        placeholder="company@example.com"
                        class="w-full px-5 py-4
                               border border-slate-300
                               rounded-xl
                               bg-white
                               text-slate-800
                               outline-none
                               focus:border-blue-500
                               focus:ring-4
                               focus:ring-blue-100
                               transition"
                        required>

                </div>


                <!-- Password -->
                <div>

                    <label class="block text-sm font-semibold
                                  text-slate-700 mb-2">

                        Password

                    </label>

                    <input
                        type="password"
                        name="password"
                        placeholder="Enter your password"
                        class="w-full px-5 py-4
                               border border-slate-300
                               rounded-xl
                               bg-white
                               text-slate-800
                               outline-none
                               focus:border-blue-500
                               focus:ring-4
                               focus:ring-blue-100
                               transition"
                        required>

                </div>


                <!-- Login Button -->
                <button
                    type="submit"
                    class="w-full py-4
                           rounded-xl
                           bg-gradient-to-r
                           from-blue-600
                           to-indigo-600
                           text-white
                           font-semibold
                           text-lg
                           shadow-lg
                           shadow-blue-200
                           hover:from-blue-700
                           hover:to-indigo-700
                           hover:-translate-y-0.5
                           transition duration-200">

                    Login to Employer Portal →

                </button>

            </form>


            <!-- Register -->
            <div class="mt-10 pt-7
                        border-t border-slate-200
                        text-center">

                <p class="text-slate-500">

                    Don't have a company account?

                    <a href="/company/register"
                       class="text-blue-600
                              font-semibold
                              hover:text-blue-700
                              hover:underline">

                        Create Company Account →

                    </a>

                </p>

            </div>


            <!-- Security -->
            <div class="mt-6 text-center
                        text-sm text-slate-400">

                🔒 Your information is securely protected.

            </div>

        </div>

    </main>


    <!-- ================= FOOTER ================= -->
    <footer class="border-t border-slate-200 bg-white">

        <div class="w-full px-6 lg:px-12 py-5
                    flex flex-col sm:flex-row
                    justify-between items-center gap-2">

            <p class="text-sm text-slate-500">
                © {{ date('Y') }} JobPortal
            </p>

            <p class="text-sm text-slate-400">
                Professional hiring made simple.
            </p>

        </div>

    </footer>

</body>

</html>