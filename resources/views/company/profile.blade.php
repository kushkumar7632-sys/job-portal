<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Company Profile | JobPortal</title>

    @vite('resources/css/app.css')
</head>

<body class="bg-slate-50 min-h-screen">

    <!-- ================= NAVBAR ================= -->
    <nav class="bg-white border-b border-slate-200 sticky top-0 z-50">

        <div class="max-w-7xl mx-auto px-6 lg:px-10 py-4 flex justify-between items-center">

            <!-- Logo -->
            <div class="flex items-center gap-3">

                <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-blue-600 to-indigo-600
                            text-white flex items-center justify-center
                            text-xl font-bold shadow-lg shadow-blue-100">
                    J
                </div>

                <div>
                    <h1 class="text-xl font-bold text-slate-900">
                        Job<span class="text-blue-600">Portal</span>
                    </h1>

                    <p class="text-xs text-slate-400">
                        Employer Portal
                    </p>
                </div>

            </div>


            <!-- Dashboard -->
            <a href="{{ route('company.dashboard') }}"
               class="flex items-center gap-2
                      bg-blue-600 hover:bg-blue-700
                      text-white px-5 py-2.5
                      rounded-xl font-semibold
                      transition shadow-sm">

                <span>←</span>
                Dashboard

            </a>

        </div>

    </nav>



    <!-- ================= MAIN ================= -->
    <main class="max-w-7xl mx-auto px-6 lg:px-10 py-10">

        <!-- Breadcrumb -->
        <div class="mb-8">

            <p class="text-sm text-slate-500">
                Dashboard
                <span class="mx-2">/</span>
                <span class="text-blue-600 font-medium">
                    Company Profile
                </span>
            </p>

        </div>


        <!-- ================= PROFILE HEADER ================= -->
        <div class="bg-gradient-to-r from-blue-600 via-indigo-600 to-indigo-700
                    rounded-3xl p-8 lg:p-10 text-white shadow-xl mb-8">

            <div class="flex flex-col md:flex-row md:items-center gap-6">

                <!-- Company Avatar -->
                <div class="w-24 h-24 rounded-2xl
                            bg-white/15 backdrop-blur
                            border border-white/20
                            flex items-center justify-center
                            text-4xl font-bold shrink-0">

                    {{ strtoupper(substr($company->company_name, 0, 1)) }}

                </div>


                <!-- Company Info -->
                <div class="flex-1">

                    <p class="text-blue-100 text-sm font-medium mb-2">
                        COMPANY PROFILE
                    </p>

                    <h2 class="text-3xl lg:text-4xl font-bold mb-2">
                        {{ $company->company_name }}
                    </h2>

                    <p class="text-blue-100">
                        {{ $company->industry }}
                    </p>

                </div>


                <!-- Status -->
                <div>

                    <span class="inline-flex items-center gap-2
                                 bg-white/15 border border-white/20
                                 px-4 py-2 rounded-full
                                 text-sm font-semibold">

                        <span class="w-2 h-2 bg-green-400 rounded-full"></span>

                        Company Account

                    </span>

                </div>

            </div>

        </div>



        <!-- ================= PROFILE CONTENT ================= -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <!-- LEFT SIDE -->
            <div class="lg:col-span-2">

                <div class="bg-white rounded-3xl border border-slate-200
                            shadow-sm overflow-hidden">

                    <!-- Section Header -->
                    <div class="px-7 py-6 border-b border-slate-200">

                        <h3 class="text-xl font-bold text-slate-900">
                            Company Information
                        </h3>

                        <p class="text-sm text-slate-500 mt-1">
                            Details associated with your company account.
                        </p>

                    </div>


                    <!-- Information Grid -->
                    <div class="p-7 grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-7">


                        <!-- Company Name -->
                        <div class="group">

                            <div class="flex items-center gap-3 mb-2">

                                <div class="w-9 h-9 rounded-lg bg-blue-50
                                            text-blue-600 flex items-center justify-center">
                                    🏢
                                </div>

                                <p class="text-sm text-slate-500">
                                    Company Name
                                </p>

                            </div>

                            <p class="text-lg font-semibold text-slate-900 pl-12">
                                {{ $company->company_name }}
                            </p>

                        </div>


                        <!-- Owner Name -->
                        <div>

                            <div class="flex items-center gap-3 mb-2">

                                <div class="w-9 h-9 rounded-lg bg-indigo-50
                                            text-indigo-600 flex items-center justify-center">
                                    👤
                                </div>

                                <p class="text-sm text-slate-500">
                                    Owner Name
                                </p>

                            </div>

                            <p class="text-lg font-semibold text-slate-900 pl-12">
                                {{ $company->owner_name }}
                            </p>

                        </div>


                        <!-- Email -->
                        <div>

                            <div class="flex items-center gap-3 mb-2">

                                <div class="w-9 h-9 rounded-lg bg-sky-50
                                            text-sky-600 flex items-center justify-center">
                                    ✉
                                </div>

                                <p class="text-sm text-slate-500">
                                    Email Address
                                </p>

                            </div>

                            <p class="text-lg font-semibold text-slate-900 pl-12 break-all">
                                {{ $company->email }}
                            </p>

                        </div>


                        <!-- Phone -->
                        <div>

                            <div class="flex items-center gap-3 mb-2">

                                <div class="w-9 h-9 rounded-lg bg-green-50
                                            text-green-600 flex items-center justify-center">
                                    ☎
                                </div>

                                <p class="text-sm text-slate-500">
                                    Phone Number
                                </p>

                            </div>

                            <p class="text-lg font-semibold text-slate-900 pl-12">
                                {{ $company->phone }}
                            </p>

                        </div>


                        <!-- Industry -->
                        <div>

                            <div class="flex items-center gap-3 mb-2">

                                <div class="w-9 h-9 rounded-lg bg-purple-50
                                            text-purple-600 flex items-center justify-center">
                                    💼
                                </div>

                                <p class="text-sm text-slate-500">
                                    Industry
                                </p>

                            </div>

                            <p class="text-lg font-semibold text-slate-900 pl-12">
                                {{ $company->industry }}
                            </p>

                        </div>


                        <!-- Website -->
                        <div>

                            <div class="flex items-center gap-3 mb-2">

                                <div class="w-9 h-9 rounded-lg bg-orange-50
                                            text-orange-600 flex items-center justify-center">
                                    🌐
                                </div>

                                <p class="text-sm text-slate-500">
                                    Website
                                </p>

                            </div>

                            <p class="text-lg font-semibold text-slate-900 pl-12 break-all">
                                {{ $company->website ?? 'Not provided' }}
                            </p>

                        </div>


                        <!-- Address -->
                        <div class="md:col-span-2">

                            <div class="flex items-center gap-3 mb-2">

                                <div class="w-9 h-9 rounded-lg bg-red-50
                                            text-red-600 flex items-center justify-center">
                                    📍
                                </div>

                                <p class="text-sm text-slate-500">
                                    Company Address
                                </p>

                            </div>

                            <p class="text-lg font-semibold text-slate-900 pl-12">
                                {{ $company->address }}
                            </p>

                        </div>

                    </div>

                </div>

            </div>



            <!-- ================= RIGHT SIDEBAR ================= -->
            <div class="space-y-6">

                <!-- Profile Summary -->
                <div class="bg-white rounded-3xl border border-slate-200
                            shadow-sm p-7">

                    <h3 class="text-lg font-bold text-slate-900 mb-5">
                        Profile Summary
                    </h3>

                    <div class="space-y-5">

                        <div class="flex items-center justify-between">

                            <span class="text-slate-500 text-sm">
                                Profile
                            </span>

                            <span class="text-green-600 bg-green-50
                                         px-3 py-1 rounded-full
                                         text-xs font-semibold">
                                Active
                            </span>

                        </div>


                        <div class="flex items-center justify-between">

                            <span class="text-slate-500 text-sm">
                                Account Type
                            </span>

                            <span class="font-semibold text-slate-800 text-sm">
                                Employer
                            </span>

                        </div>


                        <div class="flex items-center justify-between">

                            <span class="text-slate-500 text-sm">
                                Industry
                            </span>

                            <span class="font-semibold text-slate-800 text-sm text-right">
                                {{ $company->industry }}
                            </span>

                        </div>

                    </div>

                </div>


                <!-- Hiring Card -->
                <div class="bg-gradient-to-br from-blue-600 to-indigo-700
                            rounded-3xl p-7 text-white shadow-lg">

                    <div class="w-12 h-12 rounded-xl bg-white/15
                                flex items-center justify-center text-xl mb-5">
                        💼
                    </div>

                    <h3 class="text-xl font-bold mb-2">
                        Ready to hire?
                    </h3>

                    <p class="text-blue-100 text-sm leading-relaxed">
                        Post your next job opportunity and connect
                        with talented candidates.
                    </p>

                </div>

            </div>

        </div>

    </main>



    <!-- ================= FOOTER ================= -->
    <footer class="border-t border-slate-200 bg-white mt-10">

        <div class="max-w-7xl mx-auto px-6 lg:px-10 py-6
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