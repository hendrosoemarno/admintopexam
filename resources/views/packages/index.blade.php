<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Paket Kursus</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen flex flex-col items-center justify-center p-4">

    <div class="w-full max-w-4xl">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Pilih Paket Kursus Anda</h1>
            <p class="text-gray-600 mt-2">Daftar dan lakukan pembayaran untuk memulai pembelajaran</p>
        </div>

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
                        @if ($package->description)
                            <p class="text-gray-600 text-sm mb-4">{{ $package->description }}</p>
                        @endif
                        <p class="text-3xl font-bold text-blue-600 mb-4">Rp {{ number_format($package->price, 0, ',', '.') }}</p>
                        <a href="{{ route('register.form', $package->id) }}"
                           class="block w-full text-center bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition">
                            Daftar & Bayar
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12 text-gray-500">
                    Belum ada paket tersedia. Silakan hubungi administrator.
                </div>
            @endforelse
        </div>

        <div class="text-center mt-8">
            <a href="{{ route('dashboard') }}" class="text-blue-600 hover:underline">Kembali ke Dashboard</a>
        </div>
    </div>

</body>
</html>
