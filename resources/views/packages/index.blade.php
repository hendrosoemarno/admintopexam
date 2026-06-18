<!DOCTYPE html>
<html lang="id" x-data="{ dark: true }" x-init="dark = JSON.parse(localStorage.getItem('dark') ?? 'true'); $watch('dark', v => localStorage.setItem('dark', v))" :class="dark ? '' : 'light'">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Top Exam — Try Out TKA SD, SMP & SMA</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <style>
        :root {
            --bg: #0b0e1a;
            --bg-card: #11152a;
            --bg-card-hover: #161c36;
            --bg-section: transparent;
            --text: #ffffff;
            --text-dim: #9ca3af;
            --text-muted: #6b7280;
            --border: rgba(255,255,255,.08);
            --border-hover: rgba(59,130,246,.4);
            --badge-bg: rgba(59,130,246,.15);
            --badge-text: #60a5fa;
            --badge-border: rgba(59,130,246,.25);
            --badge-group-bg: rgba(251,146,60,.2);
            --badge-group-text: #fb923c;
            --badge-group-border: rgba(251,146,60,.3);
            --badge-ind-bg: rgba(96,165,250,.2);
            --badge-ind-text: #93c5fd;
            --badge-ind-border: rgba(96,165,250,.3);
            --btn-group: #fb923c;
            --nav-bg: rgba(11,14,26,.85);
            --nav-border: rgba(255,255,255,.06);
            --footer-bg: transparent;
            --footer-border: rgba(255,255,255,.06);
            --feature-icon-bg: rgba(59,130,246,.1);
            --feature-icon-border: rgba(59,130,246,.15);
            --cta-card-bg: #11152a;
            --alert-success-bg: rgba(22,163,74,.15);
            --alert-success-text: #86efac;
            --alert-success-border: rgba(34,197,94,.3);
            --alert-error-bg: rgba(239,68,68,.15);
            --alert-error-text: #fca5a5;
            --alert-error-border: rgba(239,68,68,.3);
            --glass-bg: rgba(255,255,255,.04);
            --glass-border: rgba(255,255,255,.06);
        }
        .light {
            --bg: #f8fafc;
            --bg-card: #ffffff;
            --bg-card-hover: #f1f5f9;
            --bg-section: #f1f5f9;
            --text: #0f172a;
            --text-dim: #475569;
            --text-muted: #94a3b8;
            --border: #e2e8f0;
            --border-hover: #3b82f6;
            --badge-bg: #dbeafe;
            --badge-text: #2563eb;
            --badge-border: #bfdbfe;
            --badge-group-bg: #fff7ed;
            --badge-group-text: #ea580c;
            --badge-group-border: #fed7aa;
            --badge-ind-bg: #eff6ff;
            --badge-ind-text: #3b82f6;
            --badge-ind-border: #bfdbfe;
            --btn-group: #f97316;
            --nav-bg: rgba(255,255,255,.85);
            --nav-border: #e2e8f0;
            --footer-bg: #f1f5f9;
            --footer-border: #e2e8f0;
            --feature-icon-bg: #e0e7ff;
            --feature-icon-border: #c7d2fe;
            --cta-card-bg: #ffffff;
            --alert-success-bg: #f0fdf4;
            --alert-success-text: #15803d;
            --alert-success-border: #bbf7d0;
            --alert-error-bg: #fef2f2;
            --alert-error-text: #b91c1c;
            --alert-error-border: #fecaca;
            --glass-bg: rgba(255,255,255,.6);
            --glass-border: #e2e8f0;
        }
        body { background: var(--bg); color: var(--text); transition: background .3s, color .3s; }
        .glow-blue { box-shadow: 0 0 30px rgba(59,130,246,.25); }
        .glow-orange { box-shadow: 0 0 30px rgba(251,146,60,.2); }
        .glass { background: var(--nav-bg); backdrop-filter: blur(12px); border-bottom: 1px solid var(--nav-border); }
        .glass-card { background: var(--bg-card); border: 1px solid var(--border); border-radius: 1rem; transition: all .3s ease; }
        .glass-card:hover { background: var(--bg-card-hover); border-color: var(--border-hover); transform: translateY(-4px); box-shadow: 0 20px 60px rgba(0,0,0,.3); }
        .gradient-text { background: linear-gradient(135deg,#3b82f6,#06b6d4); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .light .gradient-text { background: linear-gradient(135deg,#2563eb,#0891b2); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .gradient-text-orange { background: linear-gradient(135deg,#f97316,#ea580c); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .light .gradient-text-orange { background: linear-gradient(135deg,#ea580c,#c2410c); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .bg-grid { background-image: radial-gradient(rgba(255,255,255,.04) 1px,transparent 0); background-size: 40px 40px; }
        .light .bg-grid { background-image: radial-gradient(rgba(0,0,0,.04) 1px,transparent 0); background-size: 40px 40px; }
        .hero-glow { position: relative; overflow: hidden; }
        .hero-glow::before { content: ''; position: absolute; top: -50%; left: -50%; width: 200%; height: 200%; background: radial-gradient(ellipse at 30% 20%,rgba(59,130,246,.12) 0%,transparent 50%), radial-gradient(ellipse at 70% 80%,rgba(251,146,60,.08) 0%,transparent 50%); pointer-events: none; }
        .light .hero-glow::before { background: radial-gradient(ellipse at 30% 20%,rgba(59,130,246,.06) 0%,transparent 50%), radial-gradient(ellipse at 70% 80%,rgba(251,146,60,.04) 0%,transparent 50%); }
        .btn-primary { background: linear-gradient(135deg,#2563eb,#1d4ed8); transition: all .3s ease; }
        .btn-primary:hover { background: linear-gradient(135deg,#3b82f6,#2563eb); transform: translateY(-2px); box-shadow: 0 8px 30px rgba(37,99,235,.35); }
        .btn-accent { background: linear-gradient(135deg,#ea580c,#c2410c); transition: all .3s ease; }
        .btn-accent:hover { background: linear-gradient(135deg,#f97316,#ea580c); transform: translateY(-2px); box-shadow: 0 8px 30px rgba(234,88,12,.35); }
        .badge { background: var(--badge-bg); color: var(--badge-text); border: 1px solid var(--badge-border); }
        .feature-icon { width: 48px; height: 48px; border-radius: 16px; display: flex; align-items: center; justify-content: center; font-size: 1.25rem; background: var(--feature-icon-bg); border: 1px solid var(--feature-icon-border); }
        .section-alt { background: var(--bg-section); }
    </style>
</head>
<body>

    <!-- NAVBAR -->
    <nav class="fixed top-0 left-0 right-0 z-50 glass">
        <div class="max-w-6xl mx-auto px-4 py-3 flex justify-between items-center">
            <span class="text-xl font-extrabold tracking-tight" style="color:var(--text)">
                top<span class="gradient-text-orange">exam</span>
            </span>
            <div class="flex items-center gap-3">
                <button @click="dark = !dark" class="p-2 rounded-lg transition" style="background:var(--glass-bg);border:1px solid var(--glass-border)" title="Toggle mode">
                    <svg x-show="dark" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="#fbbf24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    <svg x-show="!dark" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="#6366f1"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                </button>
                <a href="https://lms.topexam.id/login" class="btn-primary text-white text-sm font-semibold px-5 py-2 rounded-full">Login</a>
            </div>
        </div>
    </nav>

    <!-- HERO + PAKET -->
    <section class="hero-glow min-h-screen flex items-center pt-16">
        <div class="max-w-6xl mx-auto px-4 py-16 md:py-24 w-full">
            <div class="text-center mb-16">
                <h1 class="text-4xl md:text-6xl font-extrabold leading-tight mb-4" style="color:var(--text)">
                    Try Out <span class="gradient-text-orange">TKA</span><br>
                    <span style="color:var(--text-dim)">SD, SMP & SMA</span>
                </h1>
                <p style="color:var(--text-dim)" class="text-lg max-w-2xl mx-auto">
                    Platform latihan <strong style="color:var(--text)">Tes Kompetensi Akademik</strong> paling lengkap dan modern. 
                    Ukur kemampuan, dapatkan rapor otomatis, dan raih prestasi terbaik.
                </p>
                <div class="flex flex-wrap gap-3 justify-center mt-8">
                    <a href="#paket" class="btn-accent text-white font-bold px-8 py-3 rounded-full">Daftar Sekarang</a>
                    <a href="#tentang" class="glass-card font-medium px-8 py-3 rounded-full" style="color:var(--text-dim)">Pelajari Lebih Lanjut</a>
                </div>
            </div>

            <!-- PAKET KURSUS -->
            <div id="paket">
                <div class="text-center mb-10">
                    <h2 class="text-2xl md:text-3xl font-bold" style="color:var(--text)">Pilih Paket Kursus</h2>
                    <p style="color:var(--text-muted)" class="mt-1">Daftar dan lakukan pembayaran untuk memulai pembelajaran</p>
                </div>

                @if (session('success'))
                    <div class="max-w-lg mx-auto mb-6 px-4 py-3 rounded-xl text-center text-sm" style="background:var(--alert-success-bg);color:var(--alert-success-text);border:1px solid var(--alert-success-border)">{{ session('success') }}</div>
                @endif
                @if (session('error'))
                    <div class="max-w-lg mx-auto mb-6 px-4 py-3 rounded-xl text-center text-sm" style="background:var(--alert-error-bg);color:var(--alert-error-text);border:1px solid var(--alert-error-border)">{{ session('error') }}</div>
                @endif

                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse ($packages as $i => $package)
                        <div class="glass-card rounded-2xl overflow-hidden glow-{{ $i % 2 === 0 ? 'blue' : 'orange' }}">
                            <div class="p-6">
                                <div class="flex justify-between items-start mb-3">
                                    <h3 class="text-lg font-bold" style="color:var(--text)">{{ $package->name }}</h3>
                                    @if ($package->max_students > 1)
                                        <span class="text-xs font-medium px-2.5 py-0.5 rounded-full" style="background:var(--badge-group-bg);color:var(--badge-group-text);border:1px solid var(--badge-group-border)">Group</span>
                                    @else
                                        <span class="text-xs font-medium px-2.5 py-0.5 rounded-full" style="background:var(--badge-ind-bg);color:var(--badge-ind-text);border:1px solid var(--badge-ind-border)">Individual</span>
                                    @endif
                                </div>
                                @if ($package->max_students > 1)
                                    <p class="text-xs mb-3 font-medium" style="color:var(--badge-group-text)">Max {{ $package->max_students }} siswa</p>
                                @endif
                                @if ($package->description)
                                    <p style="color:var(--text-dim)" class="text-sm mb-4">{{ $package->description }}</p>
                                @endif
                                <p class="text-3xl font-bold gradient-text mb-6">Rp {{ number_format($package->price, 0, ',', '.') }}</p>
                                @if ($package->max_students > 1)
                                    <a href="{{ route('register.group.form', $package->id) }}"
                                       class="block w-full text-center text-white font-bold py-3 px-4 rounded-xl transition" style="background:var(--btn-group)">
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
                        <div class="col-span-full text-center py-12" style="color:var(--text-muted)">Belum ada paket tersedia. Silakan hubungi administrator.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </section>

    <!-- TENTANG -->
    <section id="tentang" class="py-20 bg-grid section-alt">
        <div class="max-w-6xl mx-auto px-4">
            <div class="text-center mb-14">
                <span class="badge text-xs font-semibold px-4 py-1.5 rounded-full inline-block mb-4">Tentang</span>
                <h2 class="text-2xl md:text-3xl font-bold" style="color:var(--text)">Apa itu <span class="gradient-text-orange">TKA</span>?</h2>
                <p style="color:var(--text-dim)" class="max-w-3xl mx-auto mt-3 text-lg">
                    <strong style="color:var(--text)">Tes Kompetensi Akademik</strong> adalah sarana penting untuk mengukur kemampuan akademik sesuai standar nasional.
                    Dengan berlatih secara rutin, Ananda bisa mengenali keunggulan dan memperbaiki area yang perlu ditingkatkan.
                </p>
            </div>
            <div class="grid md:grid-cols-3 gap-6">
                <div class="glass-card rounded-2xl p-6 text-center">
                    <div class="feature-icon mx-auto mb-4">📘</div>
                    <h3 class="font-bold mb-2" style="color:var(--text)">Platform Terlengkap & Modern</h3>
                    <p style="color:var(--text-dim)" class="text-sm">Latihan TKA paling lengkap dan modern, sesuai kisi-kisi resmi pemerintah.</p>
                </div>
                <div class="glass-card rounded-2xl p-6 text-center">
                    <div class="feature-icon mx-auto mb-4">📖</div>
                    <h3 class="font-bold mb-2" style="color:var(--text)">Kisi-Kisi Resmi</h3>
                    <p style="color:var(--text-dim)" class="text-sm">Soal disusun berdasarkan kisi-kisi resmi pemerintah untuk hasil optimal.</p>
                </div>
                <div class="glass-card rounded-2xl p-6 text-center">
                    <div class="feature-icon mx-auto mb-4">📊</div>
                    <h3 class="font-bold mb-2" style="color:var(--text)">Rapor Kompetensi Otomatis</h3>
                    <p style="color:var(--text-dim)" class="text-sm">Rapor otomatis di setiap try out untuk lihat hasil per indikator.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- FITUR -->
    <section class="py-20">
        <div class="max-w-6xl mx-auto px-4">
            <div class="text-center mb-14">
                <span class="badge text-xs font-semibold px-4 py-1.5 rounded-full inline-block mb-4">Fitur</span>
                <h2 class="text-2xl md:text-3xl font-bold" style="color:var(--text)">Fitur Unggulan</h2>
            </div>
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="glass-card rounded-xl p-5 flex items-start gap-4">
                    <span class="text-2xl flex-shrink-0">📚</span>
                    <div>
                        <h4 class="font-bold text-sm" style="color:var(--text)">Try Out TKA SD, SMP & SMA</h4>
                        <p style="color:var(--text-dim)" class="text-xs mt-1">Berbasis kompetensi sesuai jenjang.</p>
                    </div>
                </div>
                <div class="glass-card rounded-xl p-5 flex items-start gap-4">
                    <span class="text-2xl flex-shrink-0">📊</span>
                    <div>
                        <h4 class="font-bold text-sm" style="color:var(--text)">Rapor Hasil Belajar</h4>
                        <p style="color:var(--text-dim)" class="text-xs mt-1">Per indikator, lihat area perlu ditingkatkan.</p>
                    </div>
                </div>
                <div class="glass-card rounded-xl p-5 flex items-start gap-4">
                    <span class="text-2xl flex-shrink-0">⭐</span>
                    <div>
                        <h4 class="font-bold text-sm" style="color:var(--text)">Analisis Kekuatan</h4>
                        <p style="color:var(--text-dim)" class="text-xs mt-1">Identifikasi area kuat & perlu perbaikan.</p>
                    </div>
                </div>
                <div class="glass-card rounded-xl p-5 flex items-start gap-4">
                    <span class="text-2xl flex-shrink-0">💡</span>
                    <div>
                        <h4 class="font-bold text-sm" style="color:var(--text)">Tampilan Interaktif</h4>
                        <p style="color:var(--text-dim)" class="text-xs mt-1">Mudah digunakan, realistis & menyenangkan.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- MANFAAT -->
    <section class="py-20 bg-grid section-alt">
        <div class="max-w-6xl mx-auto px-4">
            <div class="text-center mb-14">
                <span class="badge text-xs font-semibold px-4 py-1.5 rounded-full inline-block mb-4">Manfaat</span>
                <h2 class="text-2xl md:text-3xl font-bold" style="color:var(--text)">Ayah Bunda & Ananda Bisa:</h2>
            </div>
            <div class="grid md:grid-cols-3 gap-5">
                <div class="glass-card rounded-xl p-5 flex items-start gap-4">
                    <span style="color:var(--alert-success-text)" class="text-xl flex-shrink-0 mt-0.5">✓</span>
                    <p style="color:var(--text)" class="font-medium">Mengetahui kemampuan akademik sejak dini</p>
                </div>
                <div class="glass-card rounded-xl p-5 flex items-start gap-4">
                    <span style="color:var(--alert-success-text)" class="text-xl flex-shrink-0 mt-0.5">✓</span>
                    <p style="color:var(--text)" class="font-medium">Melatih pemahaman sesuai standar nasional</p>
                </div>
                <div class="glass-card rounded-xl p-5 flex items-start gap-4">
                    <span style="color:var(--alert-success-text)" class="text-xl flex-shrink-0 mt-0.5">✓</span>
                    <p style="color:var(--text)" class="font-medium">Belajar mandiri dengan pengalaman try out realistis</p>
                </div>
            </div>
            <div class="text-center mt-10">
                <p style="color:var(--text-muted)">🚀 Ayo mulai perjalanan sukses TKA Tahun Ajaran 2025/2026 dari sekarang!</p>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="py-20">
        <div class="max-w-3xl mx-auto px-4 text-center">
            <div class="glass-card rounded-3xl p-10">
                <h2 class="text-2xl md:text-3xl font-bold mb-4" style="color:var(--text)">Siap Mulai Belajar?</h2>
                <p style="color:var(--text-dim)" class="mb-8">Daftar sekarang dan dapatkan akses ke semua try out TKA SD, SMP & SMA.</p>
                <a href="#paket" class="btn-accent text-white font-bold px-10 py-3.5 rounded-full inline-block">Daftar Sekarang</a>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer style="background:var(--footer-bg);border-top:1px solid var(--footer-border)" class="py-10">
        <div class="max-w-6xl mx-auto px-4 text-center">
            <p class="text-xl font-extrabold tracking-tight">
                <span style="color:var(--text)">top</span><span class="gradient-text-orange">exam</span>
            </p>
            <p style="color:var(--text-dim)" class="text-sm mt-2">Platform Try Out TKA SD, SMP & SMA — Persiapan Sukses TA 2025/2026</p>
            <p style="color:var(--text-muted)" class="text-xs mt-6">&copy; {{ date('Y') }} Top Exam. All rights reserved.</p>
        </div>
    </footer>

</body>
</html>
