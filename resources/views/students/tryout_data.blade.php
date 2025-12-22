@extends('layouts.app')

@section('title', 'Data Try Out Siswa')

@section('content')
    <div x-data="tryoutTable()" class="space-y-6">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <h2 class="text-2xl font-bold text-gray-800">Data Try Out Siswa</h2>

            <!-- Date Filter Form -->
            <form method="GET" action="{{ route('students.tryout_data') }}"
                class="flex flex-col md:flex-row gap-2 items-end md:items-center bg-white p-3 rounded-lg shadow-sm border border-gray-200">
                <div class="flex flex-col">
                    <label for="start_date" class="text-xs text-gray-500 font-medium">Dari Tanggal</label>
                    <input type="date" name="start_date" id="start_date" value="{{ $startDate }}"
                        class="text-sm border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div class="flex flex-col">
                    <label for="end_date" class="text-xs text-gray-500 font-medium">Sampai Tanggal</label>
                    <input type="date" name="end_date" id="end_date" value="{{ $endDate }}"
                        class="text-sm border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                </div>
                <button type="submit"
                    class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 transition shadow-sm h-full mt-auto">
                    Filter
                </button>
            </form>
        </div>

        <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-200">
            <!-- Search & Info -->
            <div class="p-4 border-b border-gray-200 flex justify-between items-center bg-gray-50">
                <div class="relative w-full md:w-64">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                clip-rule="evenodd" />
                        </svg>
                    </span>
                    <input x-model="search" type="text"
                        class="w-full pl-9 pr-4 py-2 text-sm border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition"
                        placeholder="Cari siswa, course, atau quiz...">
                </div>
                <div class="text-sm text-gray-500">
                    Menampilkan data bulan ini (Default)
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th @click="sortByColumn('nama_siswa')"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100 transition select-none">
                                <div class="flex items-center gap-1">
                                    Nama Siswa
                                    <span x-show="sortCol === 'nama_siswa'" x-text="sortAsc ? '↑' : '↓'"
                                        class="text-gray-400"></span>
                                </div>
                            </th>
                            <th @click="sortByColumn('nama_course')"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100 transition select-none">
                                <div class="flex items-center gap-1">
                                    Nama Course
                                    <span x-show="sortCol === 'nama_course'" x-text="sortAsc ? '↑' : '↓'"
                                        class="text-gray-400"></span>
                                </div>
                            </th>
                            <th @click="sortByColumn('nama_quiz')"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100 transition select-none">
                                <div class="flex items-center gap-1">
                                    Nama Quiz
                                    <span x-show="sortCol === 'nama_quiz'" x-text="sortAsc ? '↑' : '↓'"
                                        class="text-gray-400"></span>
                                </div>
                            </th>
                            <th @click="sortByColumn('tanggal_akses_ts')"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100 transition select-none">
                                <div class="flex items-center gap-1">
                                    Tanggal Akses
                                    <span x-show="sortCol === 'tanggal_akses_ts'" x-text="sortAsc ? '↑' : '↓'"
                                        class="text-gray-400"></span>
                                </div>
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <template x-for="row in filteredData" :key="row.quizattemptsid">
                            <tr class="hover:bg-blue-50 transition duration-150 ease-in-out">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"
                                    x-text="row.nama_siswa"></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500" x-text="row.nama_course"></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800"
                                        x-text="row.nama_quiz"></span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500" x-text="row.tanggal_akses">
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                    <a :href="`{{ url('/students/tryoutbasic') }}/${row.quizattemptsid}`"
                                        class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded text-blue-700 bg-blue-100 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition">
                                        Raport Basic
                                    </a>
                                    <a :href="`{{ url('/students/tryoutfull') }}/${row.userid}/${row.courseid}`"
                                        class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded text-green-700 bg-green-100 hover:bg-green-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition">
                                        Raport Full
                                    </a>
                                </td>
                            </tr>
                        </template>
                        <tr x-show="filteredData.length === 0">
                            <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                Tidak ada data tryout ditemukan pada periode ini.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-3 bg-gray-50 border-t border-gray-200 text-sm text-gray-500">
                Menampilkan <span x-text="filteredData.length" class="font-bold"></span> data
            </div>
        </div>
    </div>

    <script>
        function tryoutTable() {
            return {
                search: '',
                sortCol: 'tanggal_akses_ts',
                sortAsc: false,
                data: @json($data),

                get filteredData() {
                    let result = this.data;

                    // Search
                    if (this.search) {
                        const lowerSearch = this.search.toLowerCase();
                        result = result.filter(item =>
                            (item.nama_siswa && item.nama_siswa.toLowerCase().includes(lowerSearch)) ||
                            (item.nama_course && item.nama_course.toLowerCase().includes(lowerSearch)) ||
                            (item.nama_quiz && item.nama_quiz.toLowerCase().includes(lowerSearch))
                        );
                    }

                    // Sort
                    result = result.sort((a, b) => {
                        let valA = a[this.sortCol];
                        let valB = b[this.sortCol];

                        if (valA === null) valA = '';
                        if (valB === null) valB = '';

                        if (typeof valA === 'string') valA = valA.toLowerCase();
                        if (typeof valB === 'string') valB = valB.toLowerCase();

                        if (valA < valB) return this.sortAsc ? -1 : 1;
                        if (valA > valB) return this.sortAsc ? 1 : -1;
                        return 0;
                    });

                    return result;
                },

                sortByColumn(col) {
                    if (this.sortCol === col) {
                        this.sortAsc = !this.sortAsc;
                    } else {
                        this.sortCol = col;
                        this.sortAsc = true;
                    }
                }
            }
        }
    </script>
@endsection