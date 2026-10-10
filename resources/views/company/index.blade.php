<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Manage Companies | Admin Panel</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>


<body class="bg-slate-50 min-h-screen text-slate-800">


    <!-- ================= NAVBAR ================= -->

    <nav class="bg-white border-b border-slate-200 sticky top-0 z-50">

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="h-16 flex items-center justify-between">


                <!-- Logo -->

                <a href="{{ route('admin.dashboard') }}"
                   class="flex items-center gap-3">

                    <div class="w-9 h-9 bg-blue-600
                                rounded-lg
                                flex items-center justify-center">

                        <span class="text-white font-bold">
                            J
                        </span>

                    </div>

                    <div>

                        <span class="text-xl font-bold text-slate-900">
                            Job<span class="text-blue-600">Portal</span>
                        </span>

                        <span class="hidden sm:inline-block
                                     ml-2 px-2 py-0.5
                                     bg-slate-100
                                     text-slate-500
                                     rounded text-xs font-medium">

                            ADMIN

                        </span>

                    </div>

                </a>


                <!-- Right -->

                <div class="flex items-center gap-4">

                    <a href="{{ route('admin.dashboard') }}"
                       class="hidden sm:inline-flex
                              items-center
                              text-slate-600
                              hover:text-blue-600
                              font-medium
                              transition">

                        Dashboard

                    </a>


                    <form action="{{ route('admin.logout') }}"
                          method="POST">

                        @csrf

                        <button
                            type="submit"
                            class="bg-red-50
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


        <!-- Page Header -->

        <div class="flex flex-col
                    md:flex-row
                    md:items-center
                    md:justify-between
                    gap-4 mb-8">


            <div>

                <div class="flex items-center gap-2
                            text-sm text-slate-500 mb-2">

                    <a href="{{ route('admin.dashboard') }}"
                       class="hover:text-blue-600">

                        Dashboard

                    </a>

                    <span>›</span>

                    <span class="text-slate-700">
                        Companies
                    </span>

                </div>


                <h1 class="text-3xl font-bold
                           text-slate-900">

                    Manage Companies

                </h1>


                <p class="text-slate-500 mt-2">

                    Review, approve and manage registered companies.

                </p>

            </div>


            <!-- Company Count -->

            <div class="inline-flex items-center gap-3
                        bg-white
                        border border-slate-200
                        rounded-xl
                        px-4 py-3
                        shadow-sm">

                <div class="w-9 h-9
                            bg-blue-50
                            text-blue-600
                            rounded-lg
                            flex items-center
                            justify-center">

                    🏢

                </div>

                <div>

                    <p class="text-xs text-slate-400">
                        Registered Companies
                    </p>

                    <p class="font-bold text-slate-900">
                        {{ $companies->count() }}
                    </p>

                </div>

            </div>

        </div>



        <!-- Success Message -->

        @if(session('success'))

            <div class="mb-6
                        flex items-center gap-3
                        bg-green-50
                        border border-green-200
                        text-green-700
                        px-5 py-4
                        rounded-xl">

                <div class="w-8 h-8
                            bg-green-100
                            rounded-lg
                            flex items-center
                            justify-center">

                    ✓

                </div>

                <span class="text-sm font-medium">

                    {{ session('success') }}

                </span>

            </div>

        @endif



        <!-- ================= COMPANY TABLE ================= -->

        <div class="bg-white
                    border border-slate-200
                    rounded-2xl
                    shadow-sm
                    overflow-hidden">


            <!-- Table Header -->

            <div class="px-6 py-5
                        border-b border-slate-200
                        flex items-center
                        justify-between">

                <div>

                    <h2 class="text-lg font-bold
                               text-slate-900">

                        Registered Companies

                    </h2>

                    <p class="text-sm text-slate-500 mt-1">

                        Manage company approval status.

                    </p>

                </div>

            </div>



            <!-- Responsive Table -->

            <div class="overflow-x-auto">

                <table class="w-full text-left">


                    <!-- Head -->

                    <thead class="bg-slate-50
                                  border-b
                                  border-slate-200">

                        <tr>

                            <th class="px-6 py-4
                                       text-xs font-semibold
                                       uppercase tracking-wider
                                       text-slate-500">

                                Company

                            </th>


                            <th class="px-6 py-4
                                       text-xs font-semibold
                                       uppercase tracking-wider
                                       text-slate-500">

                                Owner

                            </th>


                            <th class="px-6 py-4
                                       text-xs font-semibold
                                       uppercase tracking-wider
                                       text-slate-500">

                                Email

                            </th>


                            <th class="px-6 py-4
                                       text-xs font-semibold
                                       uppercase tracking-wider
                                       text-slate-500">

                                Industry

                            </th>


                            <th class="px-6 py-4
                                       text-xs font-semibold
                                       uppercase tracking-wider
                                       text-slate-500">

                                Status

                            </th>


                            <th class="px-6 py-4
                                       text-xs font-semibold
                                       uppercase tracking-wider
                                       text-slate-500">

                                Action

                            </th>

                        </tr>

                    </thead>



                    <!-- Body -->

                    <tbody class="divide-y divide-slate-100">


                        @forelse($companies as $company)


                            <tr class="hover:bg-slate-50
                                       transition">


                                <!-- Company -->

                                <td class="px-6 py-5">

                                    <div class="flex items-center gap-3">


                                        <div class="w-10 h-10
                                                    flex-shrink-0
                                                    bg-blue-50
                                                    text-blue-600
                                                    rounded-xl
                                                    flex items-center
                                                    justify-center
                                                    font-bold">

                                            {{ strtoupper(substr($company->company_name, 0, 1)) }}

                                        </div>


                                        <div>

                                            <p class="font-semibold
                                                      text-slate-900">

                                                {{ $company->company_name }}

                                            </p>

                                            <p class="text-xs
                                                      text-slate-400
                                                      mt-0.5">

                                                Company

                                            </p>

                                        </div>

                                    </div>

                                </td>



                                <!-- Owner -->

                                <td class="px-6 py-5">

                                    <span class="text-sm
                                                 text-slate-700">

                                        {{ $company->owner_name }}

                                    </span>

                                </td>



                                <!-- Email -->

                                <td class="px-6 py-5">

                                    <span class="text-sm
                                                 text-slate-600">

                                        {{ $company->email }}

                                    </span>

                                </td>



                                <!-- Industry -->

                                <td class="px-6 py-5">

                                    <span class="inline-flex
                                                 px-3 py-1
                                                 bg-slate-100
                                                 text-slate-600
                                                 rounded-full
                                                 text-xs
                                                 font-medium">

                                        {{ $company->industry }}

                                    </span>

                                </td>



                                <!-- Status -->

                                <td class="px-6 py-5">


                                    @if($company->is_approved)

                                        <span class="inline-flex
                                                     items-center
                                                     gap-2
                                                     px-3 py-1.5
                                                     rounded-full
                                                     bg-green-50
                                                     border
                                                     border-green-200
                                                     text-green-700
                                                     text-sm
                                                     font-semibold">

                                            <span class="w-2 h-2
                                                         bg-green-500
                                                         rounded-full">
                                            </span>

                                            Approved

                                        </span>

                                    @else

                                        <span class="inline-flex
                                                     items-center
                                                     gap-2
                                                     px-3 py-1.5
                                                     rounded-full
                                                     bg-amber-50
                                                     border
                                                     border-amber-200
                                                     text-amber-700
                                                     text-sm
                                                     font-semibold">

                                            <span class="w-2 h-2
                                                         bg-amber-500
                                                         rounded-full">
                                            </span>

                                            Pending

                                        </span>

                                    @endif

                                </td>



                                <!-- Actions -->

                                <td class="px-6 py-5">


                                    @if(!$company->is_approved)


                                        <!-- Approve -->

                                        <form
                                            action="{{ route('admin.companies.approve', $company->id) }}"
                                            method="POST">

                                            @csrf

                                            @method('PATCH')


                                            <button
                                                type="submit"
                                                class="inline-flex
                                                       items-center
                                                       gap-2
                                                       bg-green-600
                                                       hover:bg-green-700
                                                       text-white
                                                       px-4 py-2
                                                       rounded-lg
                                                       text-sm
                                                       font-semibold
                                                       transition">

                                                ✓ Approve

                                            </button>

                                        </form>


                                    @else


                                        <!-- Reject -->

                                        <form
                                            action="{{ route('admin.companies.reject', $company->id) }}"
                                            method="POST">

                                            @csrf

                                            @method('PATCH')


                                            <button
                                                type="submit"
                                                class="inline-flex
                                                       items-center
                                                       gap-2
                                                       bg-red-50
                                                       hover:bg-red-100
                                                       text-red-600
                                                       border
                                                       border-red-200
                                                       px-4 py-2
                                                       rounded-lg
                                                       text-sm
                                                       font-semibold
                                                       transition">

                                                ✕ Reject

                                            </button>

                                        </form>


                                    @endif

                                </td>

                            </tr>


                        @empty


                            <!-- Empty State -->

                            <tr>

                                <td colspan="6"
                                    class="px-6 py-16">


                                    <div class="text-center">


                                        <div class="mx-auto
                                                    w-16 h-16
                                                    bg-slate-100
                                                    rounded-2xl
                                                    flex items-center
                                                    justify-center
                                                    text-3xl">

                                            🏢

                                        </div>


                                        <h3 class="text-xl
                                                   font-bold
                                                   text-slate-800
                                                   mt-5">

                                            No Companies Registered

                                        </h3>


                                        <p class="text-slate-500
                                                  text-sm
                                                  mt-2">

                                            There are currently no
                                            companies to manage.

                                        </p>

                                    </div>

                                </td>

                            </tr>


                        @endforelse


                    </tbody>

                </table>

            </div>

        </div>


    </main>



    <!-- ================= FOOTER ================= -->

    <footer class="border-t border-slate-200 mt-10">

        <div class="max-w-7xl mx-auto
                    px-4 sm:px-6
                    py-6
                    text-center">

            <p class="text-sm text-slate-400">

                © {{ date('Y') }} JobPortal Admin Panel.
                All rights reserved.

            </p>

        </div>

    </footer>


</body>

</html>