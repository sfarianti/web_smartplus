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
</head>
<body class="bg-gray-100 flex flex-col min-h-screen">

<!-- Header Navbar -->
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

            <!-- Profil User -->
            <div class="flex items-center">
                <!-- Foto User -->
                <a href="{{ route('profile.edit') }}" class="inline-block">
                    <img 
                        src="{{ session('foto_tentor') ? asset('storage/' . session('foto_tentor')) : asset('img/user.png') }}" 
                        alt="User" 
                        class="h-8 w-8 rounded-full cursor-pointer hover:scale-110 transition duration-200"
                    >
                </a>

                <!-- Nama User -->
                <a href="{{ route('profile.edit') }}" class="text-blue p-2 hidden md:block hover:underline">
                    {{ session('nama_tentor') ?? 'Guest' }}
                </a>
            </div>
        </div>
    </header>

    

     <!-- Wrapper utama -->
     <div class="container">
        <!-- Sidebar -->
        <aside id="sidebar" class="bg-side-nav w-64 hidden md:block">
            <ul class="list-reset flex flex-col">
                <li class="border-b p-3">
                    <a href="{{ route('dashboard') }}" class="text-nav-item hover:font-bold flex items-center">
                        <i class="fas fa-chart-line mr-2"></i> Dashboard
                    </a>
                </li>
                <li class="border-b p-3">
                    <a href="{{ route('jadwals.myschedule') }}" class="text-nav-item hover:font-bold flex items-center">
                        <i class="fas fa-calendar-plus mr-2"></i> My Schedule
                    </a>
                </li>
                <li class="border-b p-3">
                    <a href="{{ route('today.course') }}" class="text-nav-item hover:font-bold flex items-center">
                        <i class="fas fa-calendar-day mr-2"></i> Today's Course
                    </a>
                </li>
                <li class="border-b p-3">
                    <a href="{{ route('history.course') }}" class="text-nav-item hover:font-bold flex items-center">
                        <i class="fas fa-history mr-2"></i> History Course
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