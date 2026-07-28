<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Group - {{ $package->name }}</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen p-4" x-data="groupForm()">

    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-2xl shadow-lg p-8">
            <div class="text-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Registrasi Group</h1>
                <p class="text-gray-600 mt-1">{{ $package->name }}</p>
                <p class="text-lg text-gray-500 mt-1">Max {{ $package->max_students }} siswa</p>
                <p class="text-xl font-bold text-blue-600 mt-1">Rp {{ number_format($package->price, 0, ',', '.') }} <span class="text-sm font-normal text-gray-500">/group</span></p>
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

            <form action="{{ route('register.group.submit') }}" method="POST">
                @csrf
                <input type="hidden" name="package_id" value="{{ $package->id }}">

                <div class="space-y-6" id="studentRows">
                    <template x-for="(student, index) in students" :key="index">
                        <div class="border border-gray-200 rounded-lg p-4 relative bg-gray-50">
                            <div class="flex justify-between items-center mb-3">
                                <h4 class="font-semibold text-gray-700" x-text="'Siswa ' + (index + 1)"></h4>
                                <button type="button" @click="removeStudent(index)"
                                        x-show="students.length > 1"
                                        class="text-red-500 hover:text-red-700 text-sm">&times; Hapus</button>
                            </div>
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs font-semibold text-gray-600 mb-1">Username</label>
                                    <input type="text" required minlength="3"
                                           :name="'students['+index+'][username]'"
                                           class="w-full border border-gray-300 rounded px-2 py-1.5 text-sm">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-gray-600 mb-1">Password</label>
                                    <div class="relative">
                                        <input :type="showPwd[index] ? 'text' : 'password'" required minlength="8"
                                               :name="'students['+index+'][password]'"
                                               class="w-full border border-gray-300 rounded px-2 py-1.5 text-sm pr-8">
                                        <button type="button" @click="showPwd[index] = !showPwd[index]"
                                                class="absolute inset-y-0 right-0 flex items-center pr-2 text-gray-400 hover:text-gray-600">
                                            <svg x-show="!showPwd[index]" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            <svg x-show="showPwd[index]" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                                        </button>
                                    </div>
                                    <p class="text-xs text-gray-400 mt-0.5">Min 8, wajib: besar, kecil, angka, spesial</p>
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-gray-600 mb-1">First Name</label>
                                    <input type="text" required
                                           :name="'students['+index+'][first_name]'"
                                           class="w-full border border-gray-300 rounded px-2 py-1.5 text-sm">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-gray-600 mb-1">Last Name</label>
                                    <input type="text" required
                                           :name="'students['+index+'][last_name]'"
                                           class="w-full border border-gray-300 rounded px-2 py-1.5 text-sm">
                                </div>
                                <div class="col-span-2">
                                    <label class="block text-xs font-semibold text-gray-600 mb-1">Email</label>
                                    <input type="email" required
                                           :name="'students['+index+'][email]'"
                                           class="w-full border border-gray-300 rounded px-2 py-1.5 text-sm">
                                </div>
                            </div>
                        </div>
                    </template>
                </div>

                <div class="mt-4">
                    <button type="button" @click="addStudent"
                            x-show="students.length < maxStudents"
                            class="text-blue-600 hover:text-blue-800 text-sm font-semibold">
                        + Tambah Siswa
                    </button>
                    <p x-show="students.length >= maxStudents"
                            class="text-gray-400 text-sm">Maksimal {{ $package->max_students }} siswa tercapai</p>
                </div>

                <hr class="my-4">

                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Metode Pembayaran</label>
                    <select name="payment_method" required
                            class="w-full border border-gray-300 rounded-lg px-3 py-2">
                        <option value="">Pilih metode...</option>
                        @foreach ($paymentMethods as $pm)
                            <option value="{{ $pm['paymentMethod'] }}">{{ $pm['paymentName'] }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Kode Kupon (opsional)</label>
                    <input type="text" name="coupon_code" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                </div>

                <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-4 rounded-lg transition">
                    Lanjutkan ke Pembayaran — Rp {{ number_format($package->price, 0, ',', '.') }}
                </button>
            </form>

            <div class="text-center mt-4">
                <a href="{{ route('packages.index') }}" class="text-sm text-blue-600 hover:underline">Kembali ke pilihan paket</a>
            </div>
        </div>
    </div>

<script>
    function groupForm() {
        return {
            maxStudents: {{ $package->max_students }},
            showPwd: [],
            students: {!! json_encode([['username' => '', 'password' => '', 'first_name' => '', 'last_name' => '', 'email' => '']]) !!},

            addStudent() {
                if (this.students.length < this.maxStudents) {
                    this.students.push({ username: '', password: '', first_name: '', last_name: '', email: '' });
                }
            },

            removeStudent(index) {
                if (this.students.length > 1) {
                    this.students.splice(index, 1);
                }
            }
        }
    }
</script>
</body>
</html>
