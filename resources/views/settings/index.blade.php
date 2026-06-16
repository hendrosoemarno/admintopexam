@extends('layouts.app')

@section('title', 'Pengaturan')

@section('content')
<div x-data="{ tab: 'packages' }">
    <h2 class="text-2xl font-bold text-gray-800 mb-4">Pengaturan</h2>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">{{ session('success') }}</div>
    @endif

    <!-- Tab Navigation -->
    <div class="flex space-x-1 mb-6 bg-gray-200 rounded-lg p-1">
        <button @click="tab = 'packages'"
                :class="{ 'bg-white shadow': tab === 'packages', 'hover:bg-gray-300': tab !== 'packages' }"
                class="flex-1 py-2 px-4 rounded-md font-medium text-sm transition">
            Paket Kursus
        </button>
        <button @click="tab = 'coupons'"
                :class="{ 'bg-white shadow': tab === 'coupons', 'hover:bg-gray-300': tab !== 'coupons' }"
                class="flex-1 py-2 px-4 rounded-md font-medium text-sm transition">
            Kupon
        </button>
        <button @click="tab = 'general'"
                :class="{ 'bg-white shadow': tab === 'general', 'hover:bg-gray-300': tab !== 'general' }"
                class="flex-1 py-2 px-4 rounded-md font-medium text-sm transition">
            Pengaturan Umum
        </button>
    </div>

    <!-- TAB: Packages -->
    <div x-show="tab === 'packages'" x-transition.duration.300ms>
        <div class="mb-4 flex justify-end">
            <button onclick="openAddPackage()"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-semibold">
                + Tambah Paket
            </button>
        </div>

        <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-200">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Harga</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Course ID</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aktif</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($packages as $pkg)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-sm font-medium">{{ $pkg->name }}</td>
                            <td class="px-4 py-3 text-sm">Rp {{ number_format($pkg->price, 0, ',', '.') }}</td>
                            <td class="px-4 py-3 text-sm">{{ $pkg->course_id }}</td>
                            <td class="px-4 py-3 text-sm">{{ $pkg->is_active ? 'Ya' : 'Tidak' }}</td>
                            <td class="px-4 py-3 text-sm space-x-1">
                                <button onclick="editPackage({{ $pkg->id }})"
                                        class="text-blue-600 hover:text-blue-800">Edit</button>
                                <form action="{{ route('settings.packages.destroy', $pkg) }}" method="POST" class="inline"
                                      onsubmit="return confirm('Hapus paket ini?')">
                                    @csrf
                                    <button class="text-red-600 hover:text-red-800">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Add/Edit Package Modal (Native, not Alpine) -->
        <dialog id="packageModal" class="rounded-2xl shadow-2xl p-0 w-full max-w-lg">
            <form id="packageForm" method="POST" class="p-6">
                @csrf
                <h3 class="text-xl font-bold mb-4" id="packageModalTitle">Tambah Paket</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-semibold mb-1">Nama Paket</label>
                        <input type="text" name="name" id="pkg_name" required
                               class="w-full border border-gray-300 rounded-lg px-3 py-2">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold mb-1">Harga (Rp)</label>
                        <input type="number" name="price" id="pkg_price" step="0.01" required
                               class="w-full border border-gray-300 rounded-lg px-3 py-2">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold mb-1">Course ID (Moodle)</label>
                        <input type="number" name="course_id" id="pkg_course_id" required
                               class="w-full border border-gray-300 rounded-lg px-3 py-2">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold mb-1">Nama Course</label>
                        <input type="text" name="course_name" id="pkg_course_name"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold mb-1">Deskripsi</label>
                        <textarea name="description" id="pkg_description" rows="2"
                                  class="w-full border border-gray-300 rounded-lg px-3 py-2"></textarea>
                    </div>
                    <div class="flex items-center gap-2">
                        <input type="checkbox" name="is_active" checked id="pkg_active">
                        <label for="pkg_active" class="text-sm font-semibold">Aktif</label>
                    </div>
                </div>
                <div class="flex justify-end gap-2 mt-6">
                    <button type="button" onclick="document.getElementById('packageModal').close()"
                            class="px-4 py-2 text-gray-600 hover:text-gray-800">Batal</button>
                    <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">Simpan</button>
                </div>
            </form>
        </dialog>
    </div>

    <!-- TAB: Coupons -->
    <div x-show="tab === 'coupons'" x-transition.duration.300ms>
        <div class="mb-4 flex justify-end">
            <button onclick="openAddCoupon()"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-semibold">
                + Tambah Kupon
            </button>
        </div>

        <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-200">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kode</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tipe</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nilai</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Terpakai</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Maks</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aktif</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($coupons as $cpn)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-sm font-mono font-medium">{{ $cpn->code }}</td>
                            <td class="px-4 py-3 text-sm">{{ $cpn->discount_type === 'percentage' ? '%' : 'Rp' }}</td>
                            <td class="px-4 py-3 text-sm">{{ $cpn->discount_type === 'percentage' ? $cpn->discount_value . '%' : 'Rp ' . number_format($cpn->discount_value, 0, ',', '.') }}</td>
                            <td class="px-4 py-3 text-sm">{{ $cpn->used_count }}</td>
                            <td class="px-4 py-3 text-sm">{{ $cpn->max_uses ?? '&#8734;' }}</td>
                            <td class="px-4 py-3 text-sm">{{ $cpn->is_active ? 'Ya' : 'Tidak' }}</td>
                            <td class="px-4 py-3 text-sm space-x-1">
                                <button onclick="editCoupon({{ $cpn->id }})"
                                        class="text-blue-600 hover:text-blue-800">Edit</button>
                                <form action="{{ route('settings.coupons.destroy', $cpn) }}" method="POST" class="inline"
                                      onsubmit="return confirm('Hapus kupon ini?')">
                                    @csrf
                                    <button class="text-red-600 hover:text-red-800">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Add/Edit Coupon Modal -->
        <dialog id="couponModal" class="rounded-2xl shadow-2xl p-0 w-full max-w-lg">
            <form id="couponForm" method="POST" class="p-6">
                @csrf
                <h3 class="text-xl font-bold mb-4" id="couponModalTitle">Tambah Kupon</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-semibold mb-1">Kode Kupon</label>
                        <input type="text" name="code" id="cpn_code" required
                               class="w-full border border-gray-300 rounded-lg px-3 py-2">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold mb-1">Tipe Diskon</label>
                        <select name="discount_type" id="cpn_type" required
                                class="w-full border border-gray-300 rounded-lg px-3 py-2">
                            <option value="fixed">Nominal Tetap (Rp)</option>
                            <option value="percentage">Persentase (%)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold mb-1">Nilai Diskon</label>
                        <input type="number" name="discount_value" id="cpn_value" step="0.01" required
                               class="w-full border border-gray-300 rounded-lg px-3 py-2">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold mb-1">Maksimal Penggunaan (kosongkan jika tidak terbatas)</label>
                        <input type="number" name="max_uses" id="cpn_max"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold mb-1">Kedaluwarsa (kosongkan jika tidak ada)</label>
                        <input type="date" name="expires_at" id="cpn_expires"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2">
                    </div>
                    <div class="flex items-center gap-2">
                        <input type="checkbox" name="is_active" checked id="cpn_active">
                        <label for="cpn_active" class="text-sm font-semibold">Aktif</label>
                    </div>
                </div>
                <div class="flex justify-end gap-2 mt-6">
                    <button type="button" onclick="document.getElementById('couponModal').close()"
                            class="px-4 py-2 text-gray-600 hover:text-gray-800">Batal</button>
                    <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">Simpan</button>
                </div>
            </form>
        </dialog>
    </div>

    <!-- TAB: General Settings -->
    <div x-show="tab === 'general'" x-transition.duration.300ms>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-bold mb-4">Konfigurasi API</h3>
            <form method="POST" action="{{ route('settings.save') }}">
                @csrf

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-semibold mb-1">Duitku Merchant Code</label>
                        <input type="text" name="duitku_merchant_code"
                               value="{{ $settings['duitku_merchant_code'] ?? '' }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold mb-1">Duitku API Key</label>
                        <input type="text" name="duitku_api_key"
                               value="{{ $settings['duitku_api_key'] ?? '' }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2">
                    </div>
                    <div class="flex items-center gap-2">
                        <input type="checkbox" name="duitku_sandbox" value="true" id="sandbox"
                               {{ ($settings['duitku_sandbox'] ?? 'true') === 'true' ? 'checked' : '' }}>
                        <label for="sandbox" class="text-sm font-semibold">Mode Sandbox (Pengembangan)</label>
                    </div>

                    <hr class="my-4">

                    <div>
                        <label class="block text-sm font-semibold mb-1">Moodle API URL</label>
                        <input type="url" name="moodle_api_url"
                               value="{{ $settings['moodle_api_url'] ?? 'https://lms.topexam.id/webservice/rest/server.php' }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold mb-1">Moodle API Token</label>
                        <input type="text" name="moodle_api_token"
                               value="{{ $settings['moodle_api_token'] ?? '' }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 font-mono">
                    </div>
                </div>

                <div class="mt-6">
                    <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-semibold">
                        Simpan Pengaturan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const packagesData = @json($packages->keyBy('id'));
    const couponsData = @json($coupons->keyBy('id'));

    function openAddPackage() {
        document.getElementById('packageModalTitle').textContent = 'Tambah Paket';
        document.getElementById('packageForm').action = '{{ route('settings.packages.store') }}';
        document.getElementById('pkg_name').value = '';
        document.getElementById('pkg_price').value = '';
        document.getElementById('pkg_course_id').value = '';
        document.getElementById('pkg_course_name').value = '';
        document.getElementById('pkg_description').value = '';
        document.getElementById('pkg_active').checked = true;
        document.getElementById('packageModal').showModal();
    }

    function editPackage(id) {
        const pkg = packagesData[id];
        if (!pkg) return;
        document.getElementById('packageModalTitle').textContent = 'Edit Paket';
        document.getElementById('packageForm').action = '/settings/packages/update/' + id;
        document.getElementById('pkg_name').value = pkg.name;
        document.getElementById('pkg_price').value = pkg.price;
        document.getElementById('pkg_course_id').value = pkg.course_id;
        document.getElementById('pkg_course_name').value = pkg.course_name || '';
        document.getElementById('pkg_description').value = pkg.description || '';
        document.getElementById('pkg_active').checked = pkg.is_active;
        document.getElementById('packageModal').showModal();
    }

    function openAddCoupon() {
        document.getElementById('couponModalTitle').textContent = 'Tambah Kupon';
        document.getElementById('couponForm').action = '{{ route('settings.coupons.store') }}';
        document.getElementById('cpn_code').value = '';
        document.getElementById('cpn_type').value = 'fixed';
        document.getElementById('cpn_value').value = '';
        document.getElementById('cpn_max').value = '';
        document.getElementById('cpn_expires').value = '';
        document.getElementById('cpn_active').checked = true;
        document.getElementById('couponModal').showModal();
    }

    function editCoupon(id) {
        const cpn = couponsData[id];
        if (!cpn) return;
        document.getElementById('couponModalTitle').textContent = 'Edit Kupon';
        document.getElementById('couponForm').action = '/settings/coupons/update/' + id;
        document.getElementById('cpn_code').value = cpn.code;
        document.getElementById('cpn_type').value = cpn.discount_type;
        document.getElementById('cpn_value').value = cpn.discount_value;
        document.getElementById('cpn_max').value = cpn.max_uses || '';
        document.getElementById('cpn_expires').value = cpn.expires_at ? cpn.expires_at.substring(0, 10) : '';
        document.getElementById('cpn_active').checked = cpn.is_active;
        document.getElementById('couponModal').showModal();
    }
</script>
@endsection
