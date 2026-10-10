<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Company Dashboard | JobPortal</title>

    @vite('resources/css/app.css')

</head>


<body class="bg-slate-50 min-h-screen text-slate-800">


<!-- ================= NAVBAR ================= -->

<nav class="bg-white border-b border-slate-200 sticky top-0 z-50">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="h-16 flex items-center justify-between">


            <!-- Logo -->

            <a href="/company/dashboard"
               class="flex items-center gap-2">

                <div class="w-9 h-9 bg-blue-600
                            rounded-lg
                            flex items-center justify-center">

                    <span class="text-white font-bold text-lg">
                        J
                    </span>

                </div>

                <span class="text-xl font-bold text-slate-900">

                    Job<span class="text-blue-600">Portal</span>

                </span>

            </a>


            <!-- Right -->

            <div class="flex items-center gap-4">


                <div class="hidden sm:block text-right">

                    <p class="text-xs text-slate-400">
                        Company Account
                    </p>

                    <p class="text-sm font-semibold text-slate-700">

                        {{ session('company_name') }}

                    </p>

                </div>


                <!-- Company Avatar -->

                <div class="w-10 h-10 rounded-full
                            bg-blue-100 text-blue-600
                            flex items-center justify-center
                            font-bold">

                    {{ strtoupper(substr(session('company_name'), 0, 1)) }}

                </div>


                <!-- Logout -->

                <form action="/company/logout" method="POST">

                    @csrf

                    <button
                        class="hidden sm:inline-flex
                               bg-red-50
                               hover:bg-red-100
                               text-red-600
                               border border-red-200
                               px-4 py-2
                               rounded-lg
                               font-medium
                               transition">

                        Logout

                    </button>

                </form>

            </div>

        </div>

    </div>

</nav>



<!-- ================= MAIN ================= -->

<main class="max-w-7xl mx-auto
             px-4 sm:px-6 lg:px-8
             py-8">


    <!-- Welcome Banner -->

    <div class="bg-gradient-to-r
                from-blue-600
                to-indigo-600
                rounded-2xl
                p-6 md:p-8
                text-white
                shadow-lg
                mb-8">


        <div class="flex flex-col
                    md:flex-row
                    md:items-center
                    md:justify-between
                    gap-6">


            <div>

                <p class="text-blue-100
                          text-sm
                          font-medium
                          mb-2">

                    COMPANY DASHBOARD

                </p>


                <h1 class="text-2xl md:text-3xl
                           font-bold">

                    Welcome, {{ session('company_name') }} 👋

                </h1>


                <p class="text-blue-100
                          mt-2">

                    Manage your job postings and
                    find the right talent for your team.

                </p>

            </div>


            <!-- Post Job -->

            <a href="/company/job/create"
               class="inline-flex
                      items-center
                      justify-center
                      bg-white
                      text-blue-600
                      font-semibold
                      px-6 py-3
                      rounded-xl
                      hover:bg-blue-50
                      transition
                      shadow-sm">

                + Post New Job

            </a>

        </div>

    </div>



    <!-- ================= STATS ================= -->

    <div class="grid grid-cols-1
                sm:grid-cols-3
                gap-5 mb-8">


        <!-- Total Jobs -->

        <div class="bg-white
                    border border-slate-200
                    rounded-2xl
                    p-6
                    shadow-sm
                    hover:shadow-md
                    transition">


            <div class="flex items-center
                        justify-between">


                <div>

                    <p class="text-sm
                              text-slate-500">

                        Total Jobs

                    </p>


                    <p class="text-3xl
                              font-bold
                              text-slate-900
                              mt-2">

                        {{ $totalJobs }}

                    </p>


                    <p class="text-xs
                              text-blue-600
                              font-medium
                              mt-2">

                        Job postings

                    </p>

                </div>


                <div class="w-12 h-12
                            bg-blue-50
                            text-blue-600
                            rounded-xl
                            flex items-center
                            justify-center
                            text-xl">

                    💼

                </div>

            </div>

        </div>



        <!-- Applications -->

        <div class="bg-white
                    border border-slate-200
                    rounded-2xl
                    p-6
                    shadow-sm
                    hover:shadow-md
                    transition">


            <div class="flex items-center
                        justify-between">


                <div>

                    <p class="text-sm
                              text-slate-500">

                        Applications

                    </p>


                    <p class="text-3xl
                              font-bold
                              text-slate-900
                              mt-2">

                        0

                    </p>


                    <p class="text-xs
                              text-green-600
                              font-medium
                              mt-2">

                        Candidate applications

                    </p>

                </div>


                <div class="w-12 h-12
                            bg-green-50
                            text-green-600
                            rounded-xl
                            flex items-center
                            justify-center
                            text-xl">

                    👥

                </div>

            </div>

        </div>



        <!-- Company Status -->

        <div class="bg-white
                    border border-slate-200
                    rounded-2xl
                    p-6
                    shadow-sm
                    hover:shadow-md
                    transition">


            <div class="flex items-center
                        justify-between">


                <div>

                    <p class="text-sm
                              text-slate-500">

                        Company Status

                    </p>


                    <p class="text-xl
                              font-bold
                              text-green-600
                              mt-3">

                        Approved

                    </p>


                    <p class="text-xs
                              text-slate-400
                              mt-2">

                        Account verified

                    </p>

                </div>


                <div class="w-12 h-12
                            bg-green-50
                            text-green-600
                            rounded-xl
                            flex items-center
                            justify-center
                            text-xl">

                    ✓

                </div>

            </div>

        </div>

    </div>



    <!-- ================= QUICK ACTIONS ================= -->

    <div class="mb-5">

        <h2 class="text-xl
                   font-bold
                   text-slate-900">

            Quick Actions

        </h2>


        <p class="text-sm
                  text-slate-500
                  mt-1">

            Manage your recruitment activities from one place.

        </p>

    </div>



    <div class="grid grid-cols-1
                md:grid-cols-2
                lg:grid-cols-4
                gap-5">


        <!-- Post Job -->

        <a href="/company/job/create"
           class="group bg-white
                  border border-slate-200
                  rounded-2xl
                  p-6
                  shadow-sm
                  hover:shadow-lg
                  hover:-translate-y-1
                  transition duration-300">


            <div class="w-12 h-12
                        bg-blue-50
                        text-blue-600
                        rounded-xl
                        flex items-center
                        justify-center
                        text-xl
                        mb-5
                        group-hover:bg-blue-600
                        group-hover:text-white
                        transition">

                +

            </div>


            <h3 class="font-bold
                       text-slate-900">

                Post New Job

            </h3>


            <p class="text-sm
                      text-slate-500
                      mt-2
                      leading-6">

                Create and publish a new job opening.

            </p>


            <span class="inline-block
                         mt-4
                         text-blue-600
                         text-sm
                         font-semibold">

                Create Job →

            </span>

        </a>



        <!-- Manage Jobs -->

        <a href="{{ route('company.jobs') }}"
           class="group bg-white
                  border border-slate-200
                  rounded-2xl
                  p-6
                  shadow-sm
                  hover:shadow-lg
                  hover:-translate-y-1
                  transition duration-300">


            <div class="w-12 h-12
                        bg-purple-50
                        text-purple-600
                        rounded-xl
                        flex items-center
                        justify-center
                        text-xl
                        mb-5
                        group-hover:bg-purple-600
                        group-hover:text-white
                        transition">

                💼

            </div>


            <h3 class="font-bold
                       text-slate-900">

                Manage Jobs

            </h3>


            <p class="text-sm
                      text-slate-500
                      mt-2
                      leading-6">

                View and manage your existing job postings.

            </p>


            <span class="inline-block
                         mt-4
                         text-purple-600
                         text-sm
                         font-semibold">

                View Jobs →

            </span>

        </a>



        <!-- Applications -->

        <a href="#"
           class="group bg-white
                  border border-slate-200
                  rounded-2xl
                  p-6
                  shadow-sm
                  hover:shadow-lg
                  hover:-translate-y-1
                  transition duration-300">


            <div class="w-12 h-12
                        bg-green-50
                        text-green-600
                        rounded-xl
                        flex items-center
                        justify-center
                        text-xl
                        mb-5
                        group-hover:bg-green-600
                        group-hover:text-white
                        transition">

                👥

            </div>


            <h3 class="font-bold
                       text-slate-900">

                Applications

            </h3>


            <p class="text-sm
                      text-slate-500
                      mt-2
                      leading-6">

                Review applications from potential candidates.

            </p>


            <span class="inline-block
                         mt-4
                         text-green-600
                         text-sm
                         font-semibold">

                View Applications →

            </span>

        </a>



        <!-- Company Profile -->

        <a href="{{ route('company.profile') }}"
           class="group bg-white
                  border border-slate-200
                  rounded-2xl
                  p-6
                  shadow-sm
                  hover:shadow-lg
                  hover:-translate-y-1
                  transition duration-300">


            <div class="w-12 h-12
                        bg-orange-50
                        text-orange-600
                        rounded-xl
                        flex items-center
                        justify-center
                        text-xl
                        mb-5
                        group-hover:bg-orange-500
                        group-hover:text-white
                        transition">

                🏢

            </div>


            <h3 class="font-bold
                       text-slate-900">

                Company Profile

            </h3>


            <p class="text-sm
                      text-slate-500
                      mt-2
                      leading-6">

                Manage your company information and profile.

            </p>


            <span class="inline-block
                         mt-4
                         text-orange-600
                         text-sm
                         font-semibold">

                View Profile →

            </span>

        </a>

    </div>



    <!-- ================= RECRUITMENT CTA ================= -->

    <div class="mt-8
                bg-white
                border border-slate-200
                rounded-2xl
                p-6
                flex flex-col
                md:flex-row
                md:items-center
                md:justify-between
                gap-5">


        <div>

            <h3 class="text-lg
                       font-bold
                       text-slate-900">

                Ready to find great talent?

            </h3>


            <p class="text-sm
                      text-slate-500
                      mt-1">

                Post a job and connect with qualified candidates.

            </p>

        </div>


        <a href="/company/job/create"
           class="inline-flex
                  items-center
                  justify-center
                  bg-blue-600
                  hover:bg-blue-700
                  text-white
                  font-semibold
                  px-6 py-3
                  rounded-xl
                  transition">

            Post a Job →

        </a>

    </div>


</main>



<!-- ================= FOOTER ================= -->

<footer class="border-t border-slate-200 mt-10">

    <div class="max-w-7xl mx-auto
                px-4 sm:px-6
                py-6
                text-center">

        <p class="text-sm text-slate-400">

            © {{ date('Y') }} JobPortal. All rights reserved.

        </p>

    </div>

</footer>


</body>
</html>