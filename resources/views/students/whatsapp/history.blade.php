@extends('layouts.app')

@section('title', 'Riwayat Laporan WA')

@section('content')
    <div class="max-w-6xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-2xl font-bold text-blue-700 uppercase">📋 Riwayat Laporan WhatsApp</h2>
                <p class="text-gray-500 text-sm">Daftar laporan yang telah dikirim ke siswa.</p>
            </div>
            <a href="{{ route('students.tryoutwhatsapp') }}" class="text-gray-500 hover:text-gray-800 font-medium text-sm">
                &larr; Kembali
            </a>
        </div>

        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg border border-green-200 text-sm font-medium">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white border rounded-2xl shadow-sm overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="py-4 px-6 text-left text-xs font-bold text-gray-400 uppercase">Siswa</th>
                        <th class="py-4 px-6 text-left text-xs font-bold text-gray-400 uppercase">Course</th>
                        <th class="py-4 px-6 text-left text-xs font-bold text-gray-400 uppercase">Tanggal Kirim</th>
                        <th class="py-4 px-6 text-center text-xs font-bold text-gray-400 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($data as $row)
                        <tr class="hover:bg-blue-50/50 transition"
                            x-data="{ editing: false, date: '{{ date('Y-m-d\TH:i', strtotime($row->tanggal_kirim)) }}' }">
                            <td class="py-4 px-6">
                                <div class="font-bold text-gray-800">{{ $row->nama_siswa }}</div>
                                <div class="text-xs text-gray-400">ID: {{ $row->userid }}</div>
                            </td>
                            <td class="py-4 px-6 text-sm text-gray-600">
                                {{ $row->nama_course }}
                            </td>
                            <td class="py-4 px-6 text-sm">
                                <template x-if="!editing">
                                    <span
                                        class="font-mono text-blue-600">{{ date('d-m-Y H:i', strtotime($row->tanggal_kirim)) }}</span>
                                </template>
                                <template x-if="editing">
                                    <form action="{{ route('students.tryoutwhatsapp.update_report', $row->id) }}" method="POST"
                                        class="flex items-center gap-2">
                                        @csrf
                                        <input type="datetime-local" name="tanggal_kirim" x-model="date"
                                            class="text-xs border-gray-300 rounded focus:ring-blue-500">
                                        <button type="submit" class="bg-blue-600 text-white p-1 rounded hover:bg-blue-700">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7" />
                                            </svg>
                                        </button>
                                        <button type="button" @click="editing = false"
                                            class="bg-gray-300 text-gray-700 p-1 rounded hover:bg-gray-400">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </form>
                                </template>
                            </td>
                            <td class="py-4 px-6 text-center">
                                <div class="flex justify-center gap-2">
                                    <button @click="editing = !editing" class="text-blue-500 hover:text-blue-700 p-1">
                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </button>

                                    <form action="{{ route('students.tryoutwhatsapp.delete_report', $row->id) }}" method="POST"
                                        onsubmit="return confirm('Hapus riwayat ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 p-1">
                                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-20 text-center">
                                <div class="text-gray-400 italic">Belum ada riwayat laporan yang dicatat.</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection