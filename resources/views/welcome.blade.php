<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>E-Posyandu</title>
        
        <!-- Tailwind CSS -->
        <script src="https://cdn.tailwindcss.com"></script>
        
        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        
        <style>
            body {
                font-family: 'Poppins', sans-serif;
            }

            .bg-grainy {
                position: relative;
                background: inherit;
            }

            .bg-grainy::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noiseFilter'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.65' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noiseFilter)'/%3E%3C/svg%3E");
                opacity: 0.15; /* Adjust for desired grain intensity */
                pointer-events: none;
                z-index: 0;
            }

            .bg-grainy > * {
                position: relative;
                z-index: 1;
            }

        </style>
    </head>
    <body class="bg-gray-50">
        <!-- Navbar -->
        <nav class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <h1 class="text-2xl font-bold text-blue-600">E-Posyandu</h1>
                    </div>
                    
                    <div class="flex items-center">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-gray-900">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-gray-900">Login</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="ml-4 px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700">Register</a>
                            @endif
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <div class="relative bg-white overflow-hidden">
            <div class="max-w-7xl mx-auto">
                <div class="relative z-10 pb-8 bg-white sm:pb-16 md:pb-20 lg:w-full lg:pb-28 xl:pb-32">
                    <main class="mt-10 mx-auto max-w-7xl px-4 sm:mt-12 sm:px-6 md:mt-16 lg:mt-20 lg:px-8 xl:mt-28">
                        <div class="flex flex-col lg:flex-row items-center justify-center space-y-8 lg:space-y-0 lg:space-x-12">
                            <div class="text-center lg:text-left lg:max-w-xl">
                                <h1 class="text-4xl tracking-tight font-extrabold text-gray-900 sm:text-5xl md:text-6xl">
                                    <span class="block">Selamat Datang di</span>
                                    <span class="block text-blue-600">E-Posyandu</span>
                                </h1>
                                <p class="mt-3 text-base text-gray-500 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-0">
                                    Sistem informasi posyandu digital untuk memudahkan pemantauan kesehatan ibu dan anak.
                                </p>
                                <div class="mt-8 flex justify-center lg:justify-start space-x-4">
                                    @auth
                                        <a href="{{ url('/dashboard') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                                            Dashboard
                                        </a>
                                    @else
                                        <a href="{{ route('login') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-blue-600 bg-white hover:bg-gray-50 border-blue-600" Dusk="Login-button1">
                                            Login
                                        </a>
                                        @if (Route::has('register'))
                                            <a href="{{ route('register') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                                                Register
                                            </a>
                                        @endif
                                    @endauth
                                </div>
                            </div>
                            <div class="flex justify-center lg:justify-start">
                                <img class="h-auto w-[500px] object-cover" src="{{ asset('assets/jpg2png/babyandmom.png') }}" alt="E-Posyandu Hero Image">
                            </div>
                        </div>
                    </main>
                </div>
            </div>
        </div>

        <!-- About Section -->
        <div class="py-12 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center bg-blue-600 text-white rounded-xl p-8 shadow-lg bg-grainy">
                    <h2 class="text-3xl font-extrabold">Tentang E-Posyandu</h2>
                    <p class="mt-4 text-lg">
                        E-Posyandu adalah sistem informasi digital yang membantu dalam pencatatan dan pemantauan kesehatan ibu dan anak. Sistem Infromasi ini mencakup role admin, petugas, dan user orangtua. Sistem ini mempermudah petugas kader dan orangtua dalam melihat report dan perkembangan anak secara daily, weekly, monthly, dan yearly.
                    </p>
                </div>
            </div>
        </div>

        <!-- Features Section -->
        <div class="py-12 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h2 class="text-3xl font-extrabold text-gray-900">Fitur Utama</h2>
                    <div class="mt-10">
                        <div class="grid grid-cols-1 gap-10 sm:grid-cols-2 lg:grid-cols-3">
                            <div class="p-6 bg-gray-50 rounded-lg shadow-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <h3 class="text-lg font-medium text-gray-900">Pencatatan Digital</h3>
                                <p class="mt-2 text-base text-gray-500">Pencatatan data kesehatan ibu dan anak secara digital</p>
                            </div>
                            <div class="p-6 bg-gray-50 rounded-lg shadow-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                                </svg>
                                <h3 class="text-lg font-medium text-gray-900">Pemantauan Kesehatan</h3>
                                <p class="mt-2 text-base text-gray-500">Pemantauan tumbuh kembang anak secara berkala</p>
                            </div>
                            <div class="p-6 bg-gray-50 rounded-lg shadow-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <h3 class="text-lg font-medium text-gray-900">Reminder Jadwal</h3>
                                <p class="mt-2 text-base text-gray-500">Pengingat jadwal posyandu dan imunisasi</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Documentation Section -->
        <div class="py-12 bg-blue-600">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-3xl font-extrabold text-white text-center mb-12">Dokumentasi Kegiatan</h2>
                
                <div class="relative">
                    <!-- Timeline Line -->
                    <div class="absolute h-full w-1 bg-white rounded left-1/2 transform -translate-x-1/2"></div>
                    
                    <!-- Timeline Items -->
                    <div class="space-y-12">
                        <!-- Timeline Item 1 -->
                        <div class="flex justify-center items-center">
                            <div class="relative w-full md:w-2/3 flex">
                                <div class="w-full md:w-2/3 p-4">
                                    <div class="bg-white bg-opacity-20 backdrop-blur-lg rounded-xl p-6 shadow-lg">
                                        <img src="{{ asset('assets/jpg2png/profile.jpg') }}" alt="Event 1" class="w-full h-48 object-cover rounded-lg mb-4">
                                        <div class="text-white">
                                            <p class="font-semibold">15 Januari 2024</p>
                                            <h3 class="text-xl font-bold mt-2">Posyandu Balita</h3>
                                            <p class="mt-2">Pemeriksaan kesehatan rutin dan imunisasi balita</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Timeline Item 2 -->
                        <div class="flex justify-center items-center">
                            <div class="relative w-full md:w-2/3 flex md:ml-auto">
                                <div class="w-full md:w-2/3 p-4">
                                    <div class="bg-white bg-opacity-20 backdrop-blur-lg rounded-xl p-6 shadow-lg">
                                        <img src="{{ asset('assets/jpg2png/profile.jpg') }}" alt="Event 2" class="w-full h-48 object-cover rounded-lg mb-4">
                                        <div class="text-white">
                                            <p class="font-semibold">20 Februari 2024</p>
                                            <h3 class="text-xl font-bold mt-2">Penyuluhan Gizi</h3>
                                            <p class="mt-2">Edukasi tentang gizi seimbang untuk ibu dan anak</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Timeline Item 3 -->
                        <div class="flex justify-center items-center">
                            <div class="relative w-full md:w-2/3 flex">
                                <div class="w-full md:w-2/3 p-4">
                                    <div class="bg-white bg-opacity-20 backdrop-blur-lg rounded-xl p-6 shadow-lg">
                                        <img src="{{ asset('assets/jpg2png/profile.jpg') }}" alt="Event 3" class="w-full h-48 object-cover rounded-lg mb-4">
                                        <div class="text-white">
                                            <p class="font-semibold">10 Maret 2024</p>
                                            <h3 class="text-xl font-bold mt-2">Vaksinasi Massal</h3>
                                            <p class="mt-2">Program vaksinasi untuk balita dan ibu hamil</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Team Section -->
        <div class="py-12 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h2 class="text-3xl font-extrabold text-gray-900">Tim Kami</h2>
                    <div class="mt-10">
                        <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                            <div class="text-center p-6 bg-white rounded-lg shadow-lg">
                                <img src="{{ asset('assets/jpg2png/profile.jpg') }}" alt="Bidan Profile" class="w-24 h-24 rounded-full mx-auto mb-4 object-cover shadow-md">
                                <h3 class="mt-2 text-lg font-medium text-gray-900">Maitsa</h3>
                                <p class="mt-1 text-sm text-gray-500">Project Manager</p>
                            </div>
                            <div class="text-center p-6 bg-white rounded-lg shadow-lg">
                                <img src="{{ asset('assets/jpg2png/firstki(1).jpg') }}" alt="Admin Profile" class="w-24 h-24 rounded-full mx-auto mb-4 object-cover shadow-md">
                                <h3 class="mt-2 text-lg font-medium text-gray-900">Firstki Aditya</h3>
                                <p class="mt-1 text-sm text-gray-500">Fullstack Developer</p>
                            </div>
                            <div class="text-center p-6 bg-white rounded-lg shadow-lg">
                                <img src="{{ asset('assets/jpg2png/profile.jpg') }}" alt="Admin Profile" class="w-24 h-24 rounded-full mx-auto mb-4 object-cover shadow-md">
                                <h3 class="mt-2 text-lg font-medium text-gray-900">Dava Ihza</h3>
                                <p class="mt-1 text-sm text-gray-500">Fullstack Developer</p>
                            </div>
                            <div class="text-center p-6 bg-white rounded-lg shadow-lg">
                                <img src="{{ asset('assets/jpg2png/profile.jpg') }}" alt="Kader Profile" class="w-24 h-24 rounded-full mx-auto mb-4 object-cover shadow-md">
                                <h3 class="mt-2 text-lg font-medium text-gray-900">Moses Eliyada</h3>
                                <p class="mt-1 text-sm text-gray-500">Fullstack Developer</p>
                            </div>
                            <div class="text-center p-6 bg-white rounded-lg shadow-lg">
                                <img src="{{ asset('assets/jpg2png/profile.jpg') }}" alt="Admin Profile" class="w-24 h-24 rounded-full mx-auto mb-4 object-cover shadow-md">
                                <h3 class="mt-2 text-lg font-medium text-gray-900">Devi Hermina</h3>
                                <p class="mt-1 text-sm text-gray-500">Fullstack Developer</p>
                            </div>
                            <div class="text-center p-6 bg-white rounded-lg shadow-lg">
                                <img src="{{ asset('assets/jpg2png/profile.jpg') }}" alt="Admin Profile" class="w-24 h-24 rounded-full mx-auto mb-4 object-cover shadow-md">
                                <h3 class="mt-2 text-lg font-medium text-gray-900">Salwa Fadia</h3>
                                <p class="mt-1 text-sm text-gray-500">Fullstack Developer</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="bg-white">
            <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <p class="text-base text-gray-400">&copy; 2025 E-Posyandu. All rights reserved.</p>
                </div>
            </div>
        </footer>
    </body>
</html>
