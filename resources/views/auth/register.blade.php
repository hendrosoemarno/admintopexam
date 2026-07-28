<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi - {{ $package->name }}</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen flex items-center justify-center p-4">

    <div class="bg-white rounded-2xl shadow-lg p-8 w-full max-w-lg">
        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Registrasi</h1>
            <p class="text-gray-600 mt-1">{{ $package->name }}</p>
            <p class="text-xl font-bold text-blue-600 mt-1">Rp {{ number_format($package->price, 0, ',', '.') }}</p>
        </div>

        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <p>{{ session('error') }}</p>
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form action="{{ route('register.submit') }}" method="POST">
            @csrf
            <input type="hidden" name="package_id" value="{{ $package->id }}">

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">First Name</label>
                    <input type="text" name="first_name" value="{{ old('first_name') }}" required
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Last Name</label>
                    <input type="text" name="last_name" value="{{ old('last_name') }}" required
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Username</label>
                <input type="text" name="username" value="{{ old('username') }}" required minlength="3"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Password</label>
                <div class="relative">
                    <input type="password" name="password" id="password" required minlength="8"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 pr-10 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <button type="button" onclick="togglePassword()"
                            class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500 hover:text-gray-700">
                        <svg id="eye-off" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                        <svg id="eye-on" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    </button>
                </div>
                <p class="text-xs text-gray-500 mt-1">Min 8 karakter, wajib ada huruf besar, huruf kecil, angka, dan karakter spesial (*, -, #, dll)</p>
            </div>

            <script>
                function togglePassword() {
                    const input = document.getElementById('password');
                    const eyeOff = document.getElementById('eye-off');
                    const eyeOn = document.getElementById('eye-on');
                    if (input.type === 'password') {
                        input.type = 'text';
                        eyeOff.classList.add('hidden');
                        eyeOn.classList.remove('hidden');
                    } else {
                        input.type = 'password';
                        eyeOn.classList.add('hidden');
                        eyeOff.classList.remove('hidden');
                    }
                }
            </script>

            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Metode Pembayaran</label>
                <select name="payment_method" required
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Pilih metode...</option>
                    @foreach ($paymentMethods as $pm)
                        <option value="{{ $pm['paymentMethod'] }}" {{ old('payment_method') == $pm['paymentMethod'] ? 'selected' : '' }}>
                            {{ $pm['paymentName'] }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Kode Kupon (opsional)</label>
                <input type="text" name="coupon_code" value="{{ old('coupon_code') }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-4 rounded-lg transition">
                Lanjutkan ke Pembayaran
            </button>
        </form>

        <div class="text-center mt-4">
            <a href="{{ route('packages.index') }}" class="text-sm text-blue-600 hover:underline">Kembali ke pilihan paket</a>
        </div>
    </div>

</body>
</html>
