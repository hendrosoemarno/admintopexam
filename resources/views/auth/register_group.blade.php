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
                                    <input type="password" required minlength="8"
                                           :name="'students['+index+'][password]'"
                                           class="w-full border border-gray-300 rounded px-2 py-1.5 text-sm">
                                    <p class="text-xs text-gray-400 mt-0.5">Min 8, ada spesial karakter</p>
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
