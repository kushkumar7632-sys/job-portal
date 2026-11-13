<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Company Profile | JobPortal</title>

    @vite('resources/css/app.css')

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: Inter, sans-serif;
        }

        .hero {
            background:
                radial-gradient(circle at 85% 20%, rgba(59,130,246,.25), transparent 30%),
                linear-gradient(115deg, #0f172a, #172554 60%, #1d4ed8);
        }

        .info-card {
            transition: .25s ease;
        }

        .info-card:hover {
            border-color: #bfdbfe;
            background: #f8fbff;
            transform: translateY(-2px);
        }

        .icon-box {
            width: 46px;
            height: 46px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            flex-shrink: 0;
        }
    </style>
</head>

<body class="bg-slate-50 text-slate-800 min-h-screen">

    <!-- NAVBAR -->
    <nav class="bg-white border-b border-slate-200 sticky top-0 z-50">

        <div class="w-full px-5 lg:px-10 xl:px-14 h-20
                    flex items-center justify-between">

            <a href="{{ route('company.dashboard') }}"
               class="flex items-center gap-3">

                <div class="w-12 h-12 bg-blue-600 rounded-xl
                            flex items-center justify-center
                            text-white text-2xl font-bold shadow-lg">
                    J
                </div>

                <div>
                    <h1 class="text-2xl font-bold text-slate-900">
                        Job<span class="text-blue-600">Portal</span>
                    </h1>
                    <p class="text-xs tracking-widest text-slate-400 font-semibold">
                        EMPLOYER PORTAL
                    </p>
                </div>

            </a>

            <div class="flex items-center gap-5">

                <span class="hidden md:block text-sm text-slate-500">
                    Company Account
                </span>

                <a href="{{ route('company.dashboard') }}"
                   class="bg-slate-900 hover:bg-blue-700 text-white
                          px-6 py-3 rounded-xl font-semibold text-sm
                          transition flex items-center gap-2">

                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>

                    Dashboard
                </a>

            </div>

        </div>
    </nav>


    <!-- MAIN -->
    <main class="w-full px-5 lg:px-10 xl:px-14 py-9">

        <!-- PAGE TITLE -->
        <div class="flex flex-col md:flex-row md:items-end
                    justify-between gap-4 mb-8">

            <div>
                <div class="text-sm text-slate-400 mb-3">
                    <a href="{{ route('company.dashboard') }}"
                       class="hover:text-blue-600">Dashboard</a>
                    <span class="mx-2">/</span>
                    <span class="text-blue-600 font-medium">Company Profile</span>
                </div>

                <h2 class="text-3xl lg:text-4xl font-bold text-slate-900">
                    Company Profile
                </h2>

                <p class="text-slate-500 mt-2">
                    View your registered company information and account details.
                </p>
            </div>

            <span class="inline-flex items-center gap-2 bg-green-50
                         text-green-700 border border-green-100
                         px-5 py-3 rounded-xl text-sm font-semibold">

                <span class="w-2 h-2 rounded-full bg-green-500"></span>
                Active Account

            </span>

        </div>


        <!-- HERO -->
        <section class="hero rounded-3xl p-7 lg:p-10 text-white
                        relative overflow-hidden mb-8">

            <div class="relative z-10 flex flex-col md:flex-row
                        md:items-center gap-7">

                <div class="w-24 h-24 lg:w-28 lg:h-28 rounded-2xl
                            bg-white/10 border border-white/20
                            flex items-center justify-center
                            text-5xl font-bold shrink-0">

                    {{ strtoupper(substr($company->company_name, 0, 1)) }}

                </div>

                <div class="flex-1">

                    <p class="text-blue-200 text-xs tracking-widest
                              font-bold mb-3">
                        REGISTERED COMPANY
                    </p>

                    <h1 class="text-3xl lg:text-5xl font-bold mb-3">
                        {{ $company->company_name }}
                    </h1>

                    <p class="text-blue-100 text-base lg:text-lg">
                        {{ $company->industry }}
                    </p>

                </div>

                <div class="md:text-right">
                    <p class="text-blue-200 text-xs uppercase tracking-wider mb-2">
                        Account Type
                    </p>

                    <span class="inline-block bg-white/10 border
                                 border-white/20 rounded-xl
                                 px-5 py-3 font-semibold">
                        Employer Account
                    </span>
                </div>

            </div>

            <div class="absolute -right-20 -bottom-40
                        w-96 h-96 rounded-full border border-white/10"></div>

        </section>


        <!-- FULL WIDTH CONTENT GRID -->
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-7">


            <!-- COMPANY INFORMATION: 75% -->
            <section class="lg:col-span-3 bg-white rounded-2xl
                            border border-slate-200 overflow-hidden">

                <div class="px-7 lg:px-9 py-7 border-b border-slate-100">

                    <h3 class="text-xl lg:text-2xl font-bold text-slate-900">
                        Company Information
                    </h3>

                    <p class="text-sm text-slate-400 mt-2">
                        Your registered company details and contact information.
                    </p>

                </div>


                <div class="p-6 lg:p-9 grid grid-cols-1 md:grid-cols-2
                            xl:grid-cols-3 gap-5">


                    <!-- COMPANY NAME -->
                    <div class="info-card border border-slate-100
                                rounded-2xl p-5">

                        <div class="icon-box bg-blue-50 text-blue-600 mb-5">
                            <svg class="w-6 h-6" fill="none"
                                 stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-width="1.8"
                                      d="M3 21h18M5 21V7l8-4v18m6 0V11l-6-4"/>
                            </svg>
                        </div>

                        <p class="text-sm text-slate-400 mb-2">
                            Company Name
                        </p>

                        <p class="font-bold text-lg text-slate-900 break-words">
                            {{ $company->company_name }}
                        </p>

                    </div>


                    <!-- OWNER -->
                    <div class="info-card border border-slate-100
                                rounded-2xl p-5">

                        <div class="icon-box bg-indigo-50 text-indigo-600 mb-5">
                            <svg class="w-6 h-6" fill="none"
                                 stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-width="1.8"
                                      d="M16 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2m12-13a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                        </div>

                        <p class="text-sm text-slate-400 mb-2">
                            Owner Name
                        </p>

                        <p class="font-bold text-lg text-slate-900">
                            {{ $company->owner_name }}
                        </p>

                    </div>


                    <!-- EMAIL -->
                    <div class="info-card border border-slate-100
                                rounded-2xl p-5">

                        <div class="icon-box bg-sky-50 text-sky-600 mb-5">
                            <svg class="w-6 h-6" fill="none"
                                 stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-width="1.8"
                                      d="M3 8l9 6 9-6M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>

                        <p class="text-sm text-slate-400 mb-2">
                            Email Address
                        </p>

                        <p class="font-bold text-lg text-slate-900 break-all">
                            {{ $company->email }}
                        </p>

                    </div>


                    <!-- PHONE -->
                    <div class="info-card border border-slate-100
                                rounded-2xl p-5">

                        <div class="icon-box bg-green-50 text-green-600 mb-5">
                            <svg class="w-6 h-6" fill="none"
                                 stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-width="1.8"
                                      d="M3 5a2 2 0 012-2h3.28a1 1 0 01.95.68l1.5 4.49a1 1 0 01-.5 1.21l-2.1 1.05a11 11 0 005.42 5.42l1.05-2.1a1 1 0 011.21-.5l4.49 1.5a1 1 0 01.68.95V19a2 2 0 01-2 2h-1C9.16 21 3 14.84 3 7V5z"/>
                            </svg>
                        </div>

                        <p class="text-sm text-slate-400 mb-2">
                            Phone Number
                        </p>

                        <p class="font-bold text-lg text-slate-900">
                            {{ $company->phone }}
                        </p>

                    </div>


                    <!-- INDUSTRY -->
                    <div class="info-card border border-slate-100
                                rounded-2xl p-5">

                        <div class="icon-box bg-purple-50 text-purple-600 mb-5">
                            <svg class="w-6 h-6" fill="none"
                                 stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-width="1.8"
                                      d="M4 21V5a2 2 0 012-2h12a2 2 0 012 2v16M4 21h16M8 7h2m4 0h2M8 11h2m4 0h2M8 15h2m4 0h2"/>
                            </svg>
                        </div>

                        <p class="text-sm text-slate-400 mb-2">
                            Industry
                        </p>

                        <p class="font-bold text-lg text-slate-900">
                            {{ $company->industry }}
                        </p>

                    </div>


                    <!-- WEBSITE -->
                    <div class="info-card border border-slate-100
                                rounded-2xl p-5">

                        <div class="icon-box bg-orange-50 text-orange-600 mb-5">
                            <svg class="w-6 h-6" fill="none"
                                 stroke="currentColor" viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="9"
                                        stroke-width="1.8"/>
                                <path stroke-linecap="round"
                                      stroke-width="1.8"
                                      d="M3 12h18m-9-9a14 14 0 010 18"/>
                            </svg>
                        </div>

                        <p class="text-sm text-slate-400 mb-2">
                            Website
                        </p>

                        <p class="font-bold text-lg text-slate-900 break-all">
                            {{ $company->website ?? 'Not provided' }}
                        </p>

                    </div>


                    <!-- ADDRESS -->
                    <div class="info-card border border-slate-100
                                rounded-2xl p-5 md:col-span-2 xl:col-span-3">

                        <div class="icon-box bg-rose-50 text-rose-600 mb-5">
                            <svg class="w-6 h-6" fill="none"
                                 stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-width="1.8"
                                      d="M20 10c0 5-8 11-8 11S4 15 4 10a8 8 0 1116 0z"/>
                                <circle cx="12" cy="10" r="2.5"
                                        stroke-width="1.8"/>
                            </svg>
                        </div>

                        <p class="text-sm text-slate-400 mb-2">
                            Company Address
                        </p>

                        <p class="font-bold text-lg text-slate-900 leading-relaxed">
                            {{ $company->address }}
                        </p>

                    </div>

                </div>

            </section>



            <!-- RIGHT SIDEBAR: 25% -->
            <aside class="lg:col-span-1 space-y-6">


                <!-- ACCOUNT SUMMARY -->
                <div class="bg-white border border-slate-200
                            rounded-2xl p-6 lg:p-7">

                    <h3 class="text-xl font-bold text-slate-900">
                        Account Overview
                    </h3>

                    <p class="text-sm text-slate-400 mt-2 mb-7">
                        Your account summary.
                    </p>


                    <div class="space-y-6">

                        <div>
                            <p class="text-sm text-slate-400 mb-2">
                                Account Status
                            </p>

                            <span class="inline-flex items-center gap-2
                                         bg-green-50 text-green-700
                                         px-4 py-2 rounded-lg text-sm font-semibold">

                                <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                                Active

                            </span>
                        </div>

                        <div class="border-t border-slate-100"></div>

                        <div>
                            <p class="text-sm text-slate-400 mb-2">
                                Account Type
                            </p>

                            <p class="font-bold text-slate-800">
                                Employer
                            </p>
                        </div>

                        <div class="border-t border-slate-100"></div>

                        <div>
                            <p class="text-sm text-slate-400 mb-2">
                                Registered Industry
                            </p>

                            <p class="font-bold text-slate-800">
                                {{ $company->industry }}
                            </p>
                        </div>

                    </div>

                </div>


                <!-- HIRING CARD -->
                <div class="bg-gradient-to-br from-blue-600 to-indigo-800
                            rounded-2xl p-7 text-white">

                    <div class="w-12 h-12 bg-white/15 rounded-xl
                                flex items-center justify-center mb-6">

                        <svg class="w-6 h-6" fill="none"
                             stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M12 4v16m8-8H4"/>
                        </svg>

                    </div>

                    <h3 class="text-2xl font-bold mb-3">
                        Start Hiring
                    </h3>

                    <p class="text-blue-100 text-sm leading-7">
                        Publish job opportunities and connect with
                        qualified candidates through JobPortal.
                    </p>

                    <a href="{{ url('/company/job/create') }}"
                       class="mt-7 w-full flex justify-center items-center
                              bg-white text-blue-700 hover:bg-blue-50
                              py-3.5 rounded-xl font-bold transition">

                        Post a Job

                    </a>

                </div>


                <!-- PROFILE NOTE -->
                <div class="bg-white border border-slate-200
                            rounded-2xl p-6">

                    <h3 class="font-bold text-slate-900 mb-3">
                        Profile Information
                    </h3>

                    <p class="text-sm text-slate-500 leading-7">
                        Keep your company information accurate and
                        updated to build trust with potential candidates.
                    </p>

                </div>

            </aside>

        </div>

    </main>


    <!-- FOOTER -->
    <footer class="bg-white border-t border-slate-200 mt-12">

        <div class="w-full px-5 lg:px-10 xl:px-14 py-7
                    flex flex-col md:flex-row
                    justify-between items-center gap-3">

            <p class="text-sm text-slate-500">
                © {{ date('Y') }} JobPortal. All rights reserved.
            </p>

            <p class="text-sm text-slate-400">
                Professional hiring made simple.
            </p>

        </div>

    </footer>

</body>
</html>