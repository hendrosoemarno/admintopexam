<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Top Exam — Try Out TKA SD & SMP</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">

    <!-- NAVBAR -->
    <nav class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-6xl mx-auto px-4 py-3 flex justify-between items-center">
            <div class="flex items-center gap-2">
                <span class="text-2xl font-extrabold text-blue-700">Top <span class="text-orange-500">Exam</span></span>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('dashboard') }}" class="text-sm text-gray-600 hover:text-blue-700">Dashboard</a>
                <a href="{{ route('moodle.login') }}" class="text-sm bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">Login</a>
            </div>
        </div>
    </nav>

    <!-- HERO -->
    <header class="bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800 text-white">
        <div class="max-w-6xl mx-auto px-4 py-16 md:py-24 text-center">
            <p class="text-orange-300 font-semibold text-sm md:text-base tracking-widest uppercase mb-4">🎉 Launching 10.10.25</p>
            <h1 class="text-3xl md:text-5xl font-extrabold leading-tight mb-6">
                Aplikasi Web Try Out<br>
                <span class="text-orange-300">TKA SD & SMP</span>
            </h1>
            <p class="text-lg md:text-xl text-blue-100 max-w-3xl mx-auto mb-8">
                dari <strong>Top Exam</strong> — bantu Ananda belajar lebih terarah, terukur, dan percaya diri! 💪
            </p>
            <div class="flex flex-wrap gap-4 justify-center">
                <a href="#paket" class="bg-orange-500 hover:bg-orange-600 text-white font-bold py-3 px-8 rounded-full shadow-lg transition transform hover:scale-105">
                    Daftar Sekarang
                </a>
            </div>
        </div>
    </header>

    <!-- TENTANG -->
    <section class="max-w-6xl mx-auto px-4 py-16">
        <div class="text-center mb-12">
            <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-3">Apa itu TKA?</h2>
            <p class="text-gray-600 max-w-3xl mx-auto text-lg">
                <strong>Tes Kompetensi Akademik (TKA)</strong> adalah sarana penting untuk mengukur kemampuan akademik sesuai standar nasional.
                Dengan berlatih secara rutin, InsyaAllah Ananda bisa mengenali keunggulan dan memperbaiki area yang perlu ditingkatkan. 🌱
            </p>
        </div>

        <div class="grid md:grid-cols-3 gap-8">
            <div class="bg-white rounded-2xl shadow-md p-6 text-center">
                <div class="text-4xl mb-4">📘</div>
                <h3 class="font-bold text-gray-800 mb-2">Platform Terlengkap & Modern</h3>
                <p class="text-gray-600 text-sm">Latihan Tes Kompetensi Akademik paling lengkap dan modern, dirancang sesuai kisi-kisi resmi pemerintah.</p>
            </div>
            <div class="bg-white rounded-2xl shadow-md p-6 text-center">
                <div class="text-4xl mb-4">📖</div>
                <h3 class="font-bold text-gray-800 mb-2">Kisi-Kisi Resmi</h3>
                <p class="text-gray-600 text-sm">Soal-soal disusun berdasarkan kisi-kisi resmi pemerintah untuk hasil belajar yang optimal.</p>
            </div>
            <div class="bg-white rounded-2xl shadow-md p-6 text-center">
                <div class="text-4xl mb-4">📊</div>
                <h3 class="font-bold text-gray-800 mb-2">Rapor Kompetensi Otomatis</h3>
                <p class="text-gray-600 text-sm">Setiap sesi try out dilengkapi rapor kompetensi otomatis untuk melihat hasil belajar per indikator.</p>
            </div>
        </div>
    </section>

    <!-- FITUR -->
    <section class="bg-white py-16">
        <div class="max-w-6xl mx-auto px-4">
            <h2 class="text-2xl md:text-3xl font-bold text-gray-800 text-center mb-12">Fitur Unggulan</h2>
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-blue-50 rounded-xl p-5">
                    <span class="text-2xl">📚</span>
                    <h4 class="font-bold text-gray-800 mt-2 mb-1">Try Out TKA SD & SMP</h4>
                    <p class="text-gray-600 text-sm">Berbasis kompetensi sesuai jenjang pendidikan.</p>
                </div>
                <div class="bg-blue-50 rounded-xl p-5">
                    <span class="text-2xl">📊</span>
                    <h4 class="font-bold text-gray-800 mt-2 mb-1">Rapor Hasil Belajar</h4>
                    <p class="text-gray-600 text-sm">Per indikator untuk melihat area yang perlu ditingkatkan.</p>
                </div>
                <div class="bg-blue-50 rounded-xl p-5">
                    <span class="text-2xl">⭐</span>
                    <h4 class="font-bold text-gray-800 mt-2 mb-1">Analisis Kekuatan</h4>
                    <p class="text-gray-600 text-sm">Identifikasi area yang sudah kuat dan perlu ditingkatkan.</p>
                </div>
                <div class="bg-blue-50 rounded-xl p-5">
                    <span class="text-2xl">💡</span>
                    <h4 class="font-bold text-gray-800 mt-2 mb-1">Tampilan Interaktif</h4>
                    <p class="text-gray-600 text-sm">Mudah digunakan, pengalaman try out yang realistis dan menyenangkan.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- MANFAAT -->
    <section class="max-w-6xl mx-auto px-4 py-16">
        <h2 class="text-2xl md:text-3xl font-bold text-gray-800 text-center mb-3">Dengan Aplikasi Ini, Ayah Bunda dan Ananda Bisa:</h2>
        <div class="grid md:grid-cols-3 gap-6 mt-10">
            <div class="flex items-start gap-4 bg-green-50 rounded-xl p-5">
                <span class="text-green-600 text-2xl flex-shrink-0">✅</span>
                <p class="text-gray-700 font-medium">Mengetahui kemampuan akademik sejak dini</p>
            </div>
            <div class="flex items-start gap-4 bg-green-50 rounded-xl p-5">
                <span class="text-green-600 text-2xl flex-shrink-0">✅</span>
                <p class="text-gray-700 font-medium">Melatih pemahaman sesuai standar nasional</p>
            </div>
            <div class="flex items-start gap-4 bg-green-50 rounded-xl p-5">
                <span class="text-green-600 text-2xl flex-shrink-0">✅</span>
                <p class="text-gray-700 font-medium">Belajar mandiri dengan pengalaman try out yang realistis dan menyenangkan</p>
            </div>
        </div>
        <p class="text-center text-gray-500 mt-8 text-sm">
            🚀 Ayo mulai perjalanan sukses TKA Tahun Ajaran 2025/2026 dari sekarang!
        </p>
    </section>

    <!-- PAKET KURSUS -->
    <section id="paket" class="bg-gray-100 py-16">
        <div class="max-w-6xl mx-auto px-4">
            <h2 class="text-2xl md:text-3xl font-bold text-gray-800 text-center mb-2">Pilih Paket Kursus</h2>
            <p class="text-gray-600 text-center mb-8">Daftar dan lakukan pembayaran untuk memulai pembelajaran</p>

            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">{{ session('success') }}</div>
            @endif

            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">{{ session('error') }}</div>
            @endif

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($packages as $package)
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden transform transition hover:scale-105 hover:shadow-xl">
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $package->name }}</h3>
                            @if ($package->max_students > 1)
                                <p class="text-orange-600 text-sm font-semibold mb-1">Group &bull; Max {{ $package->max_students }} siswa</p>
                            @endif
                            @if ($package->description)
                                <p class="text-gray-600 text-sm mb-4">{{ $package->description }}</p>
                            @endif
                            <p class="text-3xl font-bold text-blue-600 mb-4">Rp {{ number_format($package->price, 0, ',', '.') }}</p>
                            @if ($package->max_students > 1)
                                <a href="{{ route('register.group.form', $package->id) }}"
                                   class="block w-full text-center bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-lg transition">
                                    Daftar Group
                                </a>
                            @else
                                <a href="{{ route('register.form', $package->id) }}"
                                   class="block w-full text-center bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition">
                                    Daftar & Bayar
                                </a>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12 text-gray-500">
                        Belum ada paket tersedia. Silakan hubungi administrator.
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="bg-gray-800 text-gray-300 py-8">
        <div class="max-w-6xl mx-auto px-4 text-center">
            <p class="font-bold text-white">Top Exam</p>
            <p class="text-sm mt-1">Platform Try Out TKA SD & SMP — Persiapan Sukses TKA Tahun Ajaran 2025/2026</p>
            <p class="text-xs mt-4">&copy; {{ date('Y') }} Top Exam. All rights reserved.</p>
        </div>
    </footer>

</body>
</html>
