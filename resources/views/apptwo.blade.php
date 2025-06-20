<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Plus</title>
    
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/all.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="..." crossorigin="anonymous" referrerpolicy="no-referrer" />

    <script>
        function toggleSidebar() {
            document.getElementById("sidebar").classList.toggle("hidden");
        }
    </script>

    <script>
    window.pageUrls = {
        dashboard: "{{ route('dashboardAdmin') }}",
        register: "{{ route('register') }}",
        courseView: "{{ route('course.view') }}",
        jadwalIndex: "{{ route('jadwal.index') }}",
        reportsIndex: "{{ route('reports.index') }}"
    };
    </script>

    <script src="{{ asset('js/app.js') }}"></script>


</head>
<body class="bg-gray-100 flex flex-col min-h-screen">

    <!-- Header Navbar
    <header class="bg-nav w-full">
        <div class="flex justify-between items-center p-3">
            <div class="flex items-center">
                <button onclick="toggleSidebar()" class="text-white p-2 focus:outline-none md:hidden">
                    <i class="fas fa-bars"></i>
                </button>
                <img src="{{ asset('img/logo.png') }}" alt="Logo" class="h-10">
                <h1 class="text-blue p-2">SMART PLUS</h1>
            </div>
            <div class="hidden md:flex flex-grow mx-4">
                <input type="text" placeholder="Search..." class="w-full px-3 py-1 rounded-lg text-black focus:outline-none">
            </div>
            <div class="flex items-center">
                <img onclick="profileToggle()" class="h-8 w-8 rounded-full cursor-pointer" src="{{ asset('img/user.png') }}" alt="User">
                <a href="#" onclick="profileToggle()" class="text-blue p-2 hidden md:block">Farianti</a>
            </div>
        </div>
    </header> -->

<header class="bg-blue-800 w-full"> <!-- bg-nav diganti jadi bg-blue-800 -->
    <div class="flex justify-between items-center p-3">
        <div class="flex items-center">
            <button onclick="toggleSidebar()" class="text-white p-2 focus:outline-none md:hidden">
                <i class="fas fa-bars"></i>
            </button>
            <img src="{{ asset('img/logo.png') }}" alt="Logo" class="h-10">
            <h1 class="text-white p-2">SMART PLUS</h1> <!-- Tulisan putih -->
        </div>
         <div class="flex flex-grow mx-4">
            <input type="text" id="searchInput" placeholder="Search..." class="w-full px-3 py-1 rounded-lg text-black focus:outline-none" />
        </div>
        <div class="flex items-center space-x-6">
            <a href="{{ route('profileadmin.edit') }}" class="text-blue-200 p-2 hidden md:block hover:underline">
                {{ session('username') ?? 'Guest' }}
            </a>
            <form method="POST" action="{{ route('logout') }}" class="mt-6">
                @csrf
                <button type="submit" class="bg-blue-500 text-white p-2 rounded-lg hover:bg-blue-700 transition-colors">
                    Logout
                </button>
            </form>
        </div>
    </div>
</header>
     <!-- Wrapper utama -->
     <div class="container">
        <!-- Sidebar -->
        <aside id="sidebar" class="bg-side-nav w-64 hidden md:block">
            <ul class="list-reset flex flex-col">
            <li class="border-b p-3">
                    <a href="{{ route('dashboardAdmin') }}" class="text-nav-item hover:font-bold flex items-center">
                        <i class="fas fa-chart-line mr-2"></i> Dashboard
                    </a>
                </li>
                <li class="border-b p-3">
                    <a href="{{ route('register') }}" class="text-nav-item hover:font-bold flex items-center">
                        <i class="fas fa-user-tie mr-2"></i> Teacher
                    </a>
                </li>
                <li class="border-b p-3">
                    <a href="{{ route('course.view') }}" class="text-nav-item hover:font-bold flex items-center">
                        <i class="fas fa-book-open mr-2"></i> Course 
                    </a>
                </li>

                <li class="border-b p-3">
                    <a href="{{ route('jadwal.index') }}" class="text-nav-item hover:font-bold flex items-center">
                        <i class="fas fa-calendar-alt mr-2"></i> Schedule
                    </a>
                </li>
                <li class="border-b p-3">
                    <a href="{{ route('reports.index') }}" class="text-nav-item hover:font-bold flex items-center">
                        <i class="fas fa-file-alt mr-2"></i> Report
                    </a>
                </li>
            </ul>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-6">
            @yield('content')
        </main>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white text-center p-3 mt-auto">
        <p>&copy; 2024 Smart Plus. All rights reserved.</p>
    </footer>

</body>
</html>
