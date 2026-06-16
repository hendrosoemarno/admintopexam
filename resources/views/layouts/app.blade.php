<!DOCTYPE html>
<html lang="id" x-data="{ menuOpen: true, siswaOpen: false }">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Moodle')</title>

    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <!-- Alpine.js -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">

    <!-- HEADER -->
    <header class="bg-blue-700 text-white flex justify-between items-center px-4 py-3 shadow-md">
        <div class="flex items-center gap-3">
            <button @click="menuOpen = !menuOpen"
                class="p-2 bg-blue-600 rounded-md hover:bg-blue-800 focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
            <h1 class="text-lg font-bold">Moodle Dashboard</h1>
        </div>

        <a href="{{ route('moodle.logout') }}" class="text-sm hover:underline">Logout</a>
    </header>

    <!-- KONTEN UTAMA -->
    <div class="flex flex-1 overflow-hidden">
        <!-- SIDEBAR MENU -->
        <aside x-show="menuOpen" x-transition.duration.300ms class="w-64 bg-white shadow-md p-4 overflow-y-auto"
            style="display: none;">
            <nav class="space-y-2">
                <a href="{{ route('dashboard') }}" class="block p-2 rounded hover:bg-blue-100 font-medium">
                    🏠 Dashboard
                </a>

                <!-- MENU SISWA -->
                <div x-data="{ open: false }" class="border-t border-gray-200 pt-2">
                    <button @click="open = !open"
                        class="w-full text-left flex justify-between items-center p-2 rounded hover:bg-blue-50 font-medium">
                        👥 Siswa
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transform transition-transform"
                            :class="{ 'rotate-180': open }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <div x-show="open" x-transition.duration.300ms class="ml-5 mt-1 space-y-1" style="display: none;">
                        <a href="{{ route('students.index') }}"
                            class="block px-2 py-1 text-sm text-gray-700 hover:bg-blue-100 rounded">
                            📋 Daftar Siswa
                        </a>
                        <a href="{{ route('students.scores') }}"
                            class="block px-2 py-1 text-sm hover:bg-blue-100 rounded">
                            📊 Nilai Siswa
                        </a>
                        <a href="{{ route('students.tryout_data') }}"
                            class="block px-2 py-1 text-sm hover:bg-blue-100 rounded">
                            📝 Data Try Out
                        </a>
                        <a href="{{ route('students.tryout_complete') }}"
                            class="block px-2 py-1 text-sm hover:bg-blue-100 rounded">
                            ✅ Data Try Out Lengkap
                        </a>
                        <a href="{{ route('students.tryoutwhatsapp') }}"
                            class="block px-2 py-1 text-sm hover:bg-blue-100 rounded">
                            📱 Analisis WhatsApp
                        </a>
                        <a href="{{ route('students.tryoutquick') }}"
                            class="block px-2 py-1 text-sm hover:bg-blue-100 rounded">
                            🚀 Try Out Quick
                        </a>
                        <a href="{{ route('students.tryoutbasic') }}"
                            class="block px-2 py-1 text-sm hover:bg-blue-100 rounded">
                            ⚡ TKA SIAP Basic
                        </a>
                        <a href="{{ route('students.tryoutfull') }}"
                            class="block px-2 py-1 text-sm hover:bg-blue-100 rounded">
                            ⭐ TKA SIAP Full
                        </a>

                    </div>
                </div>

                <!-- MENU LAIN -->
                <a href="{{ route('packages.index') }}" target="_blank" class="block p-2 rounded hover:bg-blue-100 font-medium">📚 Kursus</a>
                <a href="{{ route('settings.index') }}" class="block p-2 rounded hover:bg-blue-100 font-medium">⚙️ Pengaturan</a>
            </nav>
        </aside>

        <!-- AREA KONTEN -->
        <main class="flex-1 p-6 overflow-y-auto">
            <!-- Alet Messages -->
            @if (session('success'))
                <div class="mx-6 mt-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded relative"
                    role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if (session('error'))
                <div class="mx-6 mt-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <!-- FOOTER -->
    <footer class="bg-gray-200 text-center p-2 text-sm text-gray-600">
        &copy; {{ date('Y') }} AI Learning - Moodle Integration
    </footer>

</body>

</html>