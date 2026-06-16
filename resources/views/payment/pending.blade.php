<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Diproses</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-yellow-50 min-h-screen flex items-center justify-center p-4">

    <div class="bg-white rounded-2xl shadow-lg p-8 w-full max-w-md text-center">
        <div class="text-6xl mb-4">&#9203;</div>
        <h1 class="text-2xl font-bold text-yellow-700 mb-2">Menunggu Pembayaran</h1>
        <p class="text-gray-600 mb-4">Pembayaran Anda sedang diproses. Kami akan mengirimkan notifikasi setelah pembayaran dikonfirmasi.</p>

        <div class="bg-gray-50 rounded-lg p-4 text-left mb-6">
            <p class="text-sm text-gray-500">Invoice: <span class="font-mono font-medium">{{ $transaction->invoice_number }}</span></p>
            <p class="text-sm text-gray-500">Paket: <span class="font-medium">{{ $transaction->package->name }}</span></p>
            <p class="text-sm text-gray-500">Total: <span class="font-medium">Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</span></p>
            <p class="text-sm text-gray-500">Status: <span class="text-yellow-600 font-semibold">MENUNGGU</span></p>
        </div>

        <a href="{{ route('packages.index') }}"
           class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg transition">
            Kembali ke Beranda
        </a>
    </div>

</body>
</html>
