@extends('layouts.app')

@section('title', 'Dashboard Siswa dan Kursus')

@section('content')
    <div x-data="studentTable()" class="space-y-6">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <h2 class="text-2xl font-bold text-gray-800">Daftar Siswa dan Kursus</h2>

            <!-- Search Input -->
            <div class="relative w-full md:w-64">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                    </svg>
                </span>
                <input x-model="search" type="text" 
                    class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out shadow-sm" 
                    placeholder="Cari siswa, email, atau kursus...">
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-200">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th @click="sortByColumn('firstname')" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100 transition select-none">
                                <div class="flex items-center gap-1">
                                    Nama Siswa
                                    <span x-show="sortCol === 'firstname'" x-text="sortAsc ? '↑' : '↓'" class="text-gray-400"></span>
                                </div>
                            </th>
                            <th @click="sortByColumn('email')" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100 transition select-none">
                                <div class="flex items-center gap-1">
                                    Email
                                    <span x-show="sortCol === 'email'" x-text="sortAsc ? '↑' : '↓'" class="text-gray-400"></span>
                                </div>
                            </th>
                            <th @click="sortByColumn('course')" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100 transition select-none">
                                <div class="flex items-center gap-1">
                                    Kursus
                                    <span x-show="sortCol === 'course'" x-text="sortAsc ? '↑' : '↓'" class="text-gray-400"></span>
                                </div>
                            </th>
                            <th @click="sortByColumn('timecreated')" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100 transition select-none">
                                <div class="flex items-center gap-1">
                                    Tgl Pendaftaran
                                    <span x-show="sortCol === 'timecreated'" x-text="sortAsc ? '↑' : '↓'" class="text-gray-400"></span>
                                </div>
                            </th>
                            <th @click="sortByColumn('lastaccess')" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100 transition select-none">
                                <div class="flex items-center gap-1">
                                    Akses Terakhir
                                    <span x-show="sortCol === 'lastaccess'" x-text="sortAsc ? '↑' : '↓'" class="text-gray-400"></span>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <template x-for="student in filteredStudents" :key="student.userid + '-' + student.course">
                            <tr class="hover:bg-blue-50 transition duration-150 ease-in-out">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900" x-text="student.firstname + ' ' + student.lastname"></div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-500" x-text="student.email"></div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800" x-text="student.course"></span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500" x-text="formatDate(student.timecreated)"></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500" x-text="formatDate(student.lastaccess)"></td>
                            </tr>
                        </template>
                        <tr x-show="filteredStudents.length === 0">
                            <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="h-10 w-10 text-gray-300 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                    <p>Tidak ada data yang ditemukan.</p>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-3 bg-gray-50 border-t border-gray-200 text-sm text-gray-500 flex justify-between items-center">
                <span>Menampilkan <span x-text="filteredStudents.length" class="font-medium text-gray-900"></span> data</span>
            </div>
        </div>
    </div>

    <script>
        function studentTable() {
            return {
                search: '',
                sortCol: 'firstname',
                sortAsc: true,
                students: @json($students),

                get filteredStudents() {
                    let result = this.students;

                    // Search
                    if (this.search) {
                        const lowerSearch = this.search.toLowerCase();
                        result = result.filter(s => 
                            (s.firstname + ' ' + s.lastname).toLowerCase().includes(lowerSearch) ||
                            (s.email && s.email.toLowerCase().includes(lowerSearch)) ||
                            (s.course && s.course.toLowerCase().includes(lowerSearch))
                        );
                    }

                    // Sort
                    result = result.sort((a, b) => {
                        let valA = a[this.sortCol];
                        let valB = b[this.sortCol];

                        // Handle nulls
                        if (valA === null) valA = '';
                        if (valB === null) valB = '';

                        // Handle strings case-insensitive
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
                },

                formatDate(timestamp) {
                    if (!timestamp || timestamp == 0) return '-';
                    const date = new Date(timestamp * 1000);
                    return date.toLocaleDateString('id-ID', { 
                        day: 'numeric', 
                        month: 'short', 
                        year: 'numeric',
                        hour: '2-digit',
                        minute: '2-digit'
                    });
                }
            }
        }
    </script>
@endsection
