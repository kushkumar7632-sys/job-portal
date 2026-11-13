<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Company Registration | JobPortal</title>

    @vite('resources/css/app.css')
</head>

<body class="bg-white text-slate-900 antialiased">

    <!-- Header -->
    <header class="border-b border-slate-200 bg-white">
        <div class="max-w-[1440px] mx-auto px-6 lg:px-12">

            <div class="h-20 flex items-center justify-between">

                <a href="/company/login"
                   class="text-2xl font-bold tracking-tight">
                    Job<span class="text-blue-600">Portal</span>
                </a>

                <div class="flex items-center gap-4">
                    <span class="hidden sm:block text-sm text-slate-500">
                        Already have an account?
                    </span>

                    <a href="/company/login"
                       class="px-5 py-2.5 text-sm font-semibold
                              border border-slate-300 rounded-lg
                              hover:border-blue-600 hover:text-blue-600
                              transition">
                        Sign in
                    </a>
                </div>

            </div>

        </div>
    </header>


    <!-- Main Content -->
    <main class="max-w-[1440px] mx-auto px-6 lg:px-12 py-12 lg:py-16">

        <div class="max-w-6xl">

            <!-- Page Heading -->
            <div class="mb-12">

                <p class="text-xs font-bold uppercase tracking-[0.16em]
                          text-blue-600 mb-4">
                    EMPLOYER REGISTRATION
                </p>

                <h1 class="text-3xl sm:text-4xl lg:text-5xl
                           font-semibold tracking-tight text-slate-900">
                    Build your hiring presence.
                </h1>

                <p class="mt-4 text-base sm:text-lg text-slate-500
                          max-w-2xl leading-7">
                    Create your company account to connect with qualified
                    candidates and manage your recruitment activities.
                </p>

            </div>


            <!-- Success Message -->
            @if(session('success'))
                <div class="mb-8 border-l-4 border-green-600
                            bg-green-50 px-5 py-4">

                    <p class="text-sm font-semibold text-green-800">
                        Registration successful
                    </p>

                    <p class="text-sm text-green-700 mt-1">
                        {{ session('success') }}
                    </p>

                </div>
            @endif


            <!-- Validation Errors -->
            @if($errors->any())
                <div class="mb-8 border-l-4 border-red-500
                            bg-red-50 px-5 py-4">

                    <p class="text-sm font-semibold text-red-800 mb-2">
                        Please review the following errors:
                    </p>

                    <ul class="list-disc pl-5 space-y-1 text-sm text-red-700">

                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach

                    </ul>

                </div>
            @endif


            <!-- Registration Form -->
            <form action="{{ url('/company/register') }}"
                  method="POST">

                @csrf


                <!-- Section 01: Company Information -->
                <section class="pb-12 border-b border-slate-200">

                    <div class="flex items-start gap-5 mb-8">

                        <span class="text-sm font-semibold text-blue-600
                                     border border-blue-200 bg-blue-50
                                     w-9 h-9 flex items-center
                                     justify-center rounded-lg shrink-0">
                            01
                        </span>

                        <div>
                            <h2 class="text-xl font-semibold text-slate-900">
                                Company information
                            </h2>

                            <p class="text-sm text-slate-500 mt-1">
                                Provide the basic details of your organization.
                            </p>
                        </div>

                    </div>


                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-x-8 gap-y-7">

                        <!-- Company Name -->
                        <div>
                            <label class="form-label">Company name</label>

                            <input
                                type="text"
                                name="company_name"
                                value="{{ old('company_name') }}"
                                placeholder="ABC Private Limited"
                                class="form-input">
                        </div>


                        <!-- Owner Name -->
                        <div>
                            <label class="form-label">Owner name</label>

                            <input
                                type="text"
                                name="owner_name"
                                value="{{ old('owner_name') }}"
                                placeholder="Enter owner name"
                                class="form-input">
                        </div>


                        <!-- Email -->
                        <div>
                            <label class="form-label">Business email</label>

                            <input
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                placeholder="name@company.com"
                                class="form-input">
                        </div>


                        <!-- Phone -->
                        <div>
                            <label class="form-label">Phone number</label>

                            <input
                                type="text"
                                name="phone"
                                value="{{ old('phone') }}"
                                placeholder="9876543210"
                                class="form-input">
                        </div>


                        <!-- Website -->
                        <div>
                            <label class="form-label">
                                Company website
                                <span class="optional-label">(Optional)</span>
                            </label>

                            <input
                                type="text"
                                name="website"
                                value="{{ old('website') }}"
                                placeholder="https://company.com"
                                class="form-input">
                        </div>


                        <!-- Industry -->
                        <div>
                            <label class="form-label">Industry</label>

                            <input
                                type="text"
                                name="industry"
                                value="{{ old('industry') }}"
                                placeholder="e.g. Information Technology"
                                class="form-input">
                        </div>

                    </div>

                </section>


                <!-- Section 02: Company Location -->
                <section class="py-12 border-b border-slate-200">

                    <div class="flex items-start gap-5 mb-8">

                        <span class="text-sm font-semibold text-blue-600
                                     border border-blue-200 bg-blue-50
                                     w-9 h-9 flex items-center
                                     justify-center rounded-lg shrink-0">
                            02
                        </span>

                        <div>
                            <h2 class="text-xl font-semibold text-slate-900">
                                Company location
                            </h2>

                            <p class="text-sm text-slate-500 mt-1">
                                Enter the registered or primary office address.
                            </p>
                        </div>

                    </div>


                    <div class="max-w-3xl">

                        <label class="form-label">Complete address</label>

                        <textarea
                            name="address"
                            rows="4"
                            placeholder="Street address, city, state, postal code..."
                            class="form-input resize-none">{{ old('address') }}</textarea>

                    </div>

                </section>


                <!-- Section 03: Account Security -->
                <section class="py-12">

                    <div class="flex items-start gap-5 mb-8">

                        <span class="text-sm font-semibold text-blue-600
                                     border border-blue-200 bg-blue-50
                                     w-9 h-9 flex items-center
                                     justify-center rounded-lg shrink-0">
                            03
                        </span>

                        <div>
                            <h2 class="text-xl font-semibold text-slate-900">
                                Account security
                            </h2>

                            <p class="text-sm text-slate-500 mt-1">
                                Create a password to secure your company account.
                            </p>
                        </div>

                    </div>


                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-7 max-w-4xl">

                        <!-- Password -->
                        <div>
                            <label class="form-label">Password</label>

                            <input
                                type="password"
                                name="password"
                                placeholder="Create a strong password"
                                class="form-input">
                        </div>


                        <!-- Confirm Password -->
                        <div>
                            <label class="form-label">Confirm password</label>

                            <input
                                type="password"
                                name="password_confirmation"
                                placeholder="Re-enter your password"
                                class="form-input">
                        </div>

                    </div>

                </section>


                <!-- Submit Area -->
                <div class="pt-8 border-t border-slate-200">

                    <div class="flex flex-col sm:flex-row
                                sm:items-center sm:justify-between gap-6">

                        <p class="text-sm text-slate-500 max-w-md">
                            By creating an account, you agree to provide
                            accurate company information.
                        </p>

                        <button
                            type="submit"
                            class="inline-flex items-center justify-center
                                   gap-3 px-8 py-4
                                   bg-blue-600 hover:bg-blue-700
                                   text-white text-sm font-semibold
                                   rounded-lg transition duration-200
                                   focus:outline-none focus:ring-4
                                   focus:ring-blue-100">

                            Create company account

                            <span aria-hidden="true">→</span>

                        </button>

                    </div>

                </div>

            </form>

        </div>

    </main>


    <!-- Footer -->
    <footer class="border-t border-slate-200">

        <div class="max-w-[1440px] mx-auto px-6 lg:px-12 py-6">

            <div class="flex flex-col sm:flex-row
                        justify-between gap-3">

                <p class="text-sm text-slate-500">
                    © {{ date('Y') }} JobPortal. All rights reserved.
                </p>

                <p class="text-sm text-slate-400">
                    Professional hiring made simple.
                </p>

            </div>

        </div>

    </footer>


    <!-- Custom Input Styles -->
    <style>
        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #334155;
            margin-bottom: 10px;
        }

        .optional-label {
            font-weight: 400;
            color: #94a3b8;
            margin-left: 4px;
        }

        .form-input {
            display: block;
            width: 100%;
            padding: 13px 15px;
            border: 1px solid #cbd5e1;
            border-radius: 7px;
            background: #fff;
            color: #0f172a;
            font-size: 14px;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .form-input::placeholder {
            color: #94a3b8;
        }

        .form-input:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.09);
        }

        textarea.form-input {
            line-height: 1.7;
        }
    </style>

</body>
</html>