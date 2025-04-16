<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>{{ $title ?? 'SMART PLUS' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
</head>
<body class="bg-gray-100">
    <div class="flex">
        <!-- Sidebar -->
        <div class="w-1/5 bg-blue-800 text-white min-h-screen">
            <div class="flex items-center p-4">
                <img alt="Logo" class="mr-2" src="https://placehold.co/50x50"/>
                <div>
                    <h1 class="text-lg font-bold">SMART PLUS</h1>
                    <p class="text-sm">Learning</p>
                </div>
            </div>
            <nav class="mt-4">
                <a class="block py-2.5 px-4 {{ request()->routeIs('dashboard') ? 'bg-blue-700' : 'hover:bg-blue-700' }}"
                   href="{{ route('dashboard') }}">
                    Dashboard
                </a>
                <a class="block py-2.5 px-4 {{ request()->routeIs('jadwals.myschedule') ? 'bg-blue-700' : 'hover:bg-blue-700' }}"
                    href="{{ route('jadwals.myschedule') }}">
                    My Schedule
                </a>
                <a class="block py-2.5 px-4 {{ request()->routeIs('today.course') ? 'bg-blue-700' : 'hover:bg-blue-700' }}"
                   href="{{ route('today.course') }}">
                    Today's Course
                </a>
                <a class="block py-2.5 px-4 {{ request()->routeIs('history.course') ? 'bg-blue-700' : 'hover:bg-blue-700' }}"
                   href="{{ route('history.course') }}">
                    History of Course
                </a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="w-4/5 p-6">
            <div class="flex justify-between items-center mb-4">
                {{-- Optional search or user icon --}}
            </div>

            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')

            <footer class="mt-4 text-center text-gray-500">
                © 2025 LBB SMART PLUS All Rights Reserved.
            </footer>
        </div>
    </div>

    @yield('scripts')
</body>
</html>
