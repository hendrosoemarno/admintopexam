<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Top Exam — Try Out TKA SD & SMP</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <style>
        body { background: #0b0e1a; }
        .glow-blue { box-shadow: 0 0 30px rgba(59,130,246,.25); }
        .glow-orange { box-shadow: 0 0 30px rgba(251,146,60,.2); }
        .glass { background: rgba(11,14,26,.7); backdrop-filter: blur(12px); border-bottom: 1px solid rgba(255,255,255,.06); }
        .glass-card { background: #11152a; border: 1px solid rgba(255,255,255,.08); border-radius: 1rem; transition: all .3s ease; }
        .glass-card:hover { background: #161c36; border-color: rgba(59,130,246,.4); transform: translateY(-4px); box-shadow: 0 20px 60px rgba(0,0,0,.5); }
        .gradient-text { background: linear-gradient(135deg,#60a5fa,#38bdf8); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .gradient-text-orange { background: linear-gradient(135deg,#fb923c,#f97316); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .bg-grid { background-image: radial-gradient(rgba(255,255,255,.04) 1px,transparent 0); background-size: 40px 40px; }
        .hero-glow { position: relative; overflow: hidden; }
        .hero-glow::before { content: ''; position: absolute; top: -50%; left: -50%; width: 200%; height: 200%; background: radial-gradient(ellipse at 30% 20%,rgba(59,130,246,.12) 0%,transparent 50%), radial-gradient(ellipse at 70% 80%,rgba(251,146,60,.08) 0%,transparent 50%); pointer-events: none; }
        .btn-primary { background: linear-gradient(135deg,#2563eb,#1d4ed8); transition: all .3s ease; }
        .btn-primary:hover { background: linear-gradient(135deg,#3b82f6,#2563eb); transform: translateY(-2px); box-shadow: 0 8px 30px rgba(37,99,235,.35); }
        .btn-accent { background: linear-gradient(135deg,#ea580c,#c2410c); transition: all .3s ease; }
        .btn-accent:hover { background: linear-gradient(135deg,#f97316,#ea580c); transform: translateY(-2px); box-shadow: 0 8px 30px rgba(234,88,12,.35); }
        .badge { background: rgba(59,130,246,.15); color: #60a5fa; border: 1px solid rgba(59,130,246,.25); }
        .feature-icon { width: 48px; height: 48px; border-radius: 16px; display: flex; align-items: center; justify-content: center; font-size: 1.25rem; background: rgba(59,130,246,.1); border: 1px solid rgba(59,130,246,.15); }
        .divider { height: 1px; background: linear-gradient(90deg,transparent,rgba(255,255,255,.06),transparent); }
    </style>
</head>
<body>

    <!-- NAVBAR -->
    <nav class="fixed top-0 left-0 right-0 z-50 glass" x-data="{ scrolled: false }" x-init="window.addEventListener('scroll',()=>scrolled=window.scrollY>20)">
        <div class="max-w-6xl mx-auto px-4 py-3 flex justify-between items-center">
            <span class="text-xl font-extrabold tracking-tight">
                <span class="text-white">top</span><span class="text-orange-400">exam</span>
                <span class="text-xs text-gray-500 ml-1 font-normal">.id</span>
            </span>
            <div class="flex items-center gap-4">
                <a href="{{ route('dashboard') }}" class="text-sm text-gray-400 hover:text-white transition">Dashboard</a>
                <a href="{{ route('moodle.login') }}" class="btn-primary text-white text-sm font-semibold px-5 py-2 rounded-full">Login</a>
            </div>
        </div>
    </nav>

    <!-- HERO + PAKET -->
    <section class="hero-glow min-h-screen flex items-center pt-16">
        <div class="max-w-6xl mx-auto px-4 py-16 md:py-24 w-full">
            <div class="text-center mb-16">
                <h1 class="text-4xl md:text-6xl font-extrabold text-white leading-tight mb-4">
                    Try Out <span class="gradient-text-orange">TKA</span><br>
                    <span class="text-gray-300">SD & SMP</span>
                </h1>
                <p class="text-gray-400 text-lg max-w-2xl mx-auto">
                    Platform latihan <strong class="text-white">Tes Kompetensi Akademik</strong> paling lengkap dan modern. 
                    Ukur kemampuan, dapatkan rapor otomatis, dan raih prestasi terbaik.
                </p>
                <div class="flex flex-wrap gap-3 justify-center mt-8">
                    <a href="#paket" class="btn-accent text-white font-bold px-8 py-3 rounded-full">Daftar Sekarang</a>
                    <a href="#tentang" class="glass text-gray-300 font-medium px-8 py-3 rounded-full hover:text-white transition">Pelajari Lebih Lanjut</a>
                </div>
            </div>

            <!-- PAKET KURSUS -->
            <div id="paket">
                <div class="text-center mb-10">
                    <h2 class="text-2xl md:text-3xl font-bold text-white">Pilih Paket Kursus</h2>
                    <p class="text-gray-500 mt-1">Daftar dan lakukan pembayaran untuk memulai pembelajaran</p>
                </div>

                @if (session('success'))
                    <div class="max-w-lg mx-auto mb-6 bg-green-900/30 border border-green-700/40 text-green-300 px-4 py-3 rounded-xl text-center text-sm">{{ session('success') }}</div>
                @endif
                @if (session('error'))
                    <div class="max-w-lg mx-auto mb-6 bg-red-900/30 border border-red-700/40 text-red-300 px-4 py-3 rounded-xl text-center text-sm">{{ session('error') }}</div>
                @endif

                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse ($packages as $i => $package)
                        <div class="glass-card rounded-2xl overflow-hidden glow-{{ $i % 2 === 0 ? 'blue' : 'orange' }}">
                            <div class="p-6">
                                <div class="flex justify-between items-start mb-3">
                                    <h3 class="text-lg font-bold text-white">{{ $package->name }}</h3>
                                    @if ($package->max_students > 1)
                                        <span class="text-xs font-medium px-2.5 py-0.5 rounded-full" style="background:rgba(251,146,60,.2);color:#fb923c;border:1px solid rgba(251,146,60,.3)">Group</span>
                                    @else
                                        <span class="text-xs font-medium px-2.5 py-0.5 rounded-full" style="background:rgba(96,165,250,.2);color:#93c5fd;border:1px solid rgba(96,165,250,.3)">Individual</span>
                                    @endif
                                </div>
                                @if ($package->max_students > 1)
                                    <p class="text-xs mb-3 font-medium" style="color:#fb923c">Max {{ $package->max_students }} siswa</p>
                                @endif
                                @if ($package->description)
                                    <p class="text-gray-400 text-sm mb-4">{{ $package->description }}</p>
                                @endif
                                <p class="text-3xl font-bold gradient-text mb-6">Rp {{ number_format($package->price, 0, ',', '.') }}</p>
                                @if ($package->max_students > 1)
                                    <a href="{{ route('register.group.form', $package->id) }}"
                                       class="block w-full text-center text-white font-bold py-3 px-4 rounded-xl transition" style="background:#fb923c">
                                        Daftar Group
                                    </a>
                                @else
                                    <a href="{{ route('register.form', $package->id) }}"
                                       class="block w-full text-center btn-primary text-white font-semibold py-2.5 px-4 rounded-xl transition">
                                        Daftar & Bayar
                                    </a>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full text-center py-12 text-gray-500">Belum ada paket tersedia. Silakan hubungi administrator.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </section>

    <!-- TENTANG -->
    <section id="tentang" class="py-20 bg-grid">
        <div class="max-w-6xl mx-auto px-4">
            <div class="text-center mb-14">
                <span class="badge text-xs font-semibold px-4 py-1.5 rounded-full inline-block mb-4">Tentang</span>
                <h2 class="text-2xl md:text-3xl font-bold text-white">Apa itu <span class="gradient-text-orange">TKA</span>?</h2>
                <p class="text-gray-400 max-w-3xl mx-auto mt-3 text-lg">
                    <strong class="text-white">Tes Kompetensi Akademik</strong> adalah sarana penting untuk mengukur kemampuan akademik sesuai standar nasional.
                    Dengan berlatih secara rutin, Ananda bisa mengenali keunggulan dan memperbaiki area yang perlu ditingkatkan.
                </p>
            </div>
            <div class="grid md:grid-cols-3 gap-6">
                <div class="glass-card rounded-2xl p-6 text-center">
                    <div class="feature-icon mx-auto mb-4">📘</div>
                    <h3 class="font-bold text-white mb-2">Platform Terlengkap & Modern</h3>
                    <p class="text-gray-400 text-sm">Latihan TKA paling lengkap dan modern, sesuai kisi-kisi resmi pemerintah.</p>
                </div>
                <div class="glass-card rounded-2xl p-6 text-center">
                    <div class="feature-icon mx-auto mb-4">📖</div>
                    <h3 class="font-bold text-white mb-2">Kisi-Kisi Resmi</h3>
                    <p class="text-gray-400 text-sm">Soal disusun berdasarkan kisi-kisi resmi pemerintah untuk hasil optimal.</p>
                </div>
                <div class="glass-card rounded-2xl p-6 text-center">
                    <div class="feature-icon mx-auto mb-4">📊</div>
                    <h3 class="font-bold text-white mb-2">Rapor Kompetensi Otomatis</h3>
                    <p class="text-gray-400 text-sm">Rapor otomatis di setiap try out untuk lihat hasil per indikator.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- FITUR -->
    <section class="py-20">
        <div class="max-w-6xl mx-auto px-4">
            <div class="text-center mb-14">
                <span class="badge text-xs font-semibold px-4 py-1.5 rounded-full inline-block mb-4">Fitur</span>
                <h2 class="text-2xl md:text-3xl font-bold text-white">Fitur Unggulan</h2>
            </div>
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="glass-card rounded-xl p-5 flex items-start gap-4">
                    <span class="text-2xl flex-shrink-0">📚</span>
                    <div>
                        <h4 class="font-bold text-white text-sm">Try Out TKA SD & SMP</h4>
                        <p class="text-gray-400 text-xs mt-1">Berbasis kompetensi sesuai jenjang.</p>
                    </div>
                </div>
                <div class="glass-card rounded-xl p-5 flex items-start gap-4">
                    <span class="text-2xl flex-shrink-0">📊</span>
                    <div>
                        <h4 class="font-bold text-white text-sm">Rapor Hasil Belajar</h4>
                        <p class="text-gray-400 text-xs mt-1">Per indikator, lihat area perlu ditingkatkan.</p>
                    </div>
                </div>
                <div class="glass-card rounded-xl p-5 flex items-start gap-4">
                    <span class="text-2xl flex-shrink-0">⭐</span>
                    <div>
                        <h4 class="font-bold text-white text-sm">Analisis Kekuatan</h4>
                        <p class="text-gray-400 text-xs mt-1">Identifikasi area kuat & perlu perbaikan.</p>
                    </div>
                </div>
                <div class="glass-card rounded-xl p-5 flex items-start gap-4">
                    <span class="text-2xl flex-shrink-0">💡</span>
                    <div>
                        <h4 class="font-bold text-white text-sm">Tampilan Interaktif</h4>
                        <p class="text-gray-400 text-xs mt-1">Mudah digunakan, realistis & menyenangkan.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- MANFAAT -->
    <section class="py-20 bg-grid">
        <div class="max-w-6xl mx-auto px-4">
            <div class="text-center mb-14">
                <span class="badge text-xs font-semibold px-4 py-1.5 rounded-full inline-block mb-4">Manfaat</span>
                <h2 class="text-2xl md:text-3xl font-bold text-white">Ayah Bunda & Ananda Bisa:</h2>
            </div>
            <div class="grid md:grid-cols-3 gap-5">
                <div class="glass-card rounded-xl p-5 flex items-start gap-4">
                    <span class="text-green-400 text-xl flex-shrink-0 mt-0.5">✓</span>
                    <p class="text-gray-300 font-medium">Mengetahui kemampuan akademik sejak dini</p>
                </div>
                <div class="glass-card rounded-xl p-5 flex items-start gap-4">
                    <span class="text-green-400 text-xl flex-shrink-0 mt-0.5">✓</span>
                    <p class="text-gray-300 font-medium">Melatih pemahaman sesuai standar nasional</p>
                </div>
                <div class="glass-card rounded-xl p-5 flex items-start gap-4">
                    <span class="text-green-400 text-xl flex-shrink-0 mt-0.5">✓</span>
                    <p class="text-gray-300 font-medium">Belajar mandiri dengan pengalaman try out realistis</p>
                </div>
            </div>
            <div class="text-center mt-10">
                <p class="text-gray-500">🚀 Ayo mulai perjalanan sukses TKA Tahun Ajaran 2025/2026 dari sekarang!</p>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="py-20">
        <div class="max-w-3xl mx-auto px-4 text-center">
            <div class="glass-card rounded-3xl p-10">
                <h2 class="text-2xl md:text-3xl font-bold text-white mb-4">Siap Mulai Belajar?</h2>
                <p class="text-gray-400 mb-8">Daftar sekarang dan dapatkan akses ke semua try out TKA SD & SMP.</p>
                <a href="#paket" class="btn-accent text-white font-bold px-10 py-3.5 rounded-full inline-block">Daftar Sekarang</a>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="border-t border-gray-800 py-10">
        <div class="max-w-6xl mx-auto px-4 text-center">
            <p class="text-xl font-extrabold tracking-tight"><span class="text-white">top</span><span class="text-orange-400">exam</span></p>
            <p class="text-gray-500 text-sm mt-2">Platform Try Out TKA SD & SMP — Persiapan Sukses TA 2025/2026</p>
            <p class="text-gray-600 text-xs mt-6">&copy; {{ date('Y') }} Top Exam. All rights reserved.</p>
        </div>
    </footer>

</body>
</html>
