<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Company Registration | JobPortal</title>

    @vite('resources/css/app.css')
</head>

<body class="bg-slate-50">

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


            <!-- Login -->
            <div class="flex items-center gap-3">

                <span class="hidden sm:block text-sm text-slate-500">
                    Already have an account?
                </span>

                <a href="/company/login"
                   class="px-5 py-2.5 rounded-xl
                          border border-blue-600
                          text-blue-600 font-semibold
                          hover:bg-blue-600 hover:text-white
                          transition">

                    Login

                </a>

            </div>

        </div>

    </header>



    <!-- ================= MAIN ================= -->
    <main class="w-full px-6 lg:px-12 xl:px-20 py-10 lg:py-14">


        <!-- Heading -->
        <div class="mb-10">

            <p class="text-sm font-bold text-blue-600
                      uppercase tracking-wider mb-2">

                Employer Registration

            </p>

            <h1 class="text-4xl lg:text-5xl font-bold text-slate-900">

                Create your company account

            </h1>

            <p class="text-slate-500 text-lg mt-3">

                Register your company and start hiring talented candidates.

            </p>

        </div>



        <!-- ================= SUCCESS ================= -->
        @if(session('success'))

            <div class="mb-8 bg-green-50 border border-green-200
                        text-green-700 p-4 rounded-xl">

                <div class="flex items-start gap-3">

                    <span class="text-lg">
                        ✓
                    </span>

                    <div>

                        <p class="font-semibold">
                            Registration Successful
                        </p>

                        <p class="text-sm mt-1">
                            {{ session('success') }}
                        </p>

                    </div>

                </div>

            </div>

        @endif



        <!-- ================= ERRORS ================= -->
        @if($errors->any())

            <div class="mb-8 bg-red-50 border border-red-200
                        text-red-700 p-4 rounded-xl">

                <p class="font-semibold mb-2">
                    Please fix the following errors:
                </p>

                <ul class="list-disc pl-5 text-sm space-y-1">

                    @foreach($errors->all() as $error)

                        <li>
                            {{ $error }}
                        </li>

                    @endforeach

                </ul>

            </div>

        @endif



        <!-- ================= FORM ================= -->
        <form action="{{ url('/company/register') }}"
              method="POST">

            @csrf


            <!-- ================= COMPANY INFORMATION ================= -->
            <section class="mb-12">

                <div class="flex items-center gap-4 mb-7">

                    <div class="w-10 h-10 rounded-xl
                                bg-blue-100 text-blue-600
                                flex items-center justify-center
                                font-bold">

                        1

                    </div>

                    <div>

                        <h2 class="text-2xl font-bold text-slate-900">
                            Company Information
                        </h2>

                        <p class="text-sm text-slate-500">
                            Enter your company's basic information.
                        </p>

                    </div>

                </div>


                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">


                    <!-- Company Name -->
                    <div>

                        <label class="block text-sm font-semibold
                                      text-slate-700 mb-2">

                            Company Name

                        </label>

                        <input
                            type="text"
                            name="company_name"
                            value="{{ old('company_name') }}"
                            placeholder="ABC Pvt Ltd"
                            class="w-full px-4 py-3.5
                                   border border-slate-300
                                   rounded-xl
                                   bg-white
                                   outline-none
                                   focus:border-blue-500
                                   focus:ring-4
                                   focus:ring-blue-100
                                   transition">

                    </div>



                    <!-- Owner Name -->
                    <div>

                        <label class="block text-sm font-semibold
                                      text-slate-700 mb-2">

                            Owner Name

                        </label>

                        <input
                            type="text"
                            name="owner_name"
                            value="{{ old('owner_name') }}"
                            placeholder="John Doe"
                            class="w-full px-4 py-3.5
                                   border border-slate-300
                                   rounded-xl
                                   bg-white
                                   outline-none
                                   focus:border-blue-500
                                   focus:ring-4
                                   focus:ring-blue-100
                                   transition">

                    </div>



                    <!-- Email -->
                    <div>

                        <label class="block text-sm font-semibold
                                      text-slate-700 mb-2">

                            Email Address

                        </label>

                        <input
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="company@gmail.com"
                            class="w-full px-4 py-3.5
                                   border border-slate-300
                                   rounded-xl
                                   bg-white
                                   outline-none
                                   focus:border-blue-500
                                   focus:ring-4
                                   focus:ring-blue-100
                                   transition">

                    </div>



                    <!-- Phone -->
                    <div>

                        <label class="block text-sm font-semibold
                                      text-slate-700 mb-2">

                            Phone Number

                        </label>

                        <input
                            type="text"
                            name="phone"
                            value="{{ old('phone') }}"
                            placeholder="9876543210"
                            class="w-full px-4 py-3.5
                                   border border-slate-300
                                   rounded-xl
                                   bg-white
                                   outline-none
                                   focus:border-blue-500
                                   focus:ring-4
                                   focus:ring-blue-100
                                   transition">

                    </div>



                    <!-- Website -->
                    <div>

                        <label class="block text-sm font-semibold
                                      text-slate-700 mb-2">

                            Website

                        </label>

                        <input
                            type="text"
                            name="website"
                            value="{{ old('website') }}"
                            placeholder="https://example.com"
                            class="w-full px-4 py-3.5
                                   border border-slate-300
                                   rounded-xl
                                   bg-white
                                   outline-none
                                   focus:border-blue-500
                                   focus:ring-4
                                   focus:ring-blue-100
                                   transition">

                    </div>



                    <!-- Industry -->
                    <div>

                        <label class="block text-sm font-semibold
                                      text-slate-700 mb-2">

                            Industry

                        </label>

                        <input
                            type="text"
                            name="industry"
                            value="{{ old('industry') }}"
                            placeholder="Software, Finance etc."
                            class="w-full px-4 py-3.5
                                   border border-slate-300
                                   rounded-xl
                                   bg-white
                                   outline-none
                                   focus:border-blue-500
                                   focus:ring-4
                                   focus:ring-blue-100
                                   transition">

                    </div>

                </div>

            </section>



            <!-- ================= ADDRESS ================= -->
            <section class="mb-12">

                <div class="flex items-center gap-4 mb-7">

                    <div class="w-10 h-10 rounded-xl
                                bg-indigo-100 text-indigo-600
                                flex items-center justify-center
                                font-bold">

                        2

                    </div>

                    <div>

                        <h2 class="text-2xl font-bold text-slate-900">
                            Company Location
                        </h2>

                        <p class="text-sm text-slate-500">
                            Add your company's complete address.
                        </p>

                    </div>

                </div>


                <div>

                    <label class="block text-sm font-semibold
                                  text-slate-700 mb-2">

                        Company Address

                    </label>

                    <textarea
                        name="address"
                        rows="4"
                        placeholder="Enter company address"
                        class="w-full px-4 py-3.5
                               border border-slate-300
                               rounded-xl
                               bg-white
                               outline-none
                               resize-none
                               focus:border-blue-500
                               focus:ring-4
                               focus:ring-blue-100
                               transition">{{ old('address') }}</textarea>

                </div>

            </section>



            <!-- ================= SECURITY ================= -->
            <section class="mb-12">

                <div class="flex items-center gap-4 mb-7">

                    <div class="w-10 h-10 rounded-xl
                                bg-purple-100 text-purple-600
                                flex items-center justify-center
                                font-bold">

                        3

                    </div>

                    <div>

                        <h2 class="text-2xl font-bold text-slate-900">
                            Account Security
                        </h2>

                        <p class="text-sm text-slate-500">
                            Set a secure password for your account.
                        </p>

                    </div>

                </div>


                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">


                    <!-- Password -->
                    <div>

                        <label class="block text-sm font-semibold
                                      text-slate-700 mb-2">

                            Password

                        </label>

                        <input
                            type="password"
                            name="password"
                            placeholder="Create password"
                            class="w-full px-4 py-3.5
                                   border border-slate-300
                                   rounded-xl
                                   bg-white
                                   outline-none
                                   focus:border-blue-500
                                   focus:ring-4
                                   focus:ring-blue-100
                                   transition">

                    </div>



                    <!-- Confirm Password -->
                    <div>

                        <label class="block text-sm font-semibold
                                      text-slate-700 mb-2">

                            Confirm Password

                        </label>

                        <input
                            type="password"
                            name="password_confirmation"
                            placeholder="Confirm password"
                            class="w-full px-4 py-3.5
                                   border border-slate-300
                                   rounded-xl
                                   bg-white
                                   outline-none
                                   focus:border-blue-500
                                   focus:ring-4
                                   focus:ring-blue-100
                                   transition">

                    </div>

                </div>

            </section>



            <!-- ================= SUBMIT ================= -->
            <div class="border-t border-slate-200 pt-8">

                <button
                    type="submit"
                    class="w-full lg:w-auto lg:min-w-[320px]
                           px-10 py-4
                           bg-gradient-to-r from-blue-600 to-indigo-600
                           text-white
                           font-semibold
                           text-lg
                           rounded-xl
                           shadow-lg shadow-blue-200
                           hover:from-blue-700
                           hover:to-indigo-700
                           hover:-translate-y-0.5
                           transition">

                    Create Company Account →

                </button>

            </div>

        </form>

    </main>



    <!-- ================= FOOTER ================= -->
    <footer class="border-t border-slate-200 bg-white">

        <div class="w-full px-6 lg:px-12 py-6
                    flex flex-col sm:flex-row
                    justify-between items-center gap-3">

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