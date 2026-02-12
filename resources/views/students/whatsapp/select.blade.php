@extends('layouts.app')

@section('title', 'Pilih Kuis WhatsApp')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="mb-4 flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Pilih Kuis untuk Digabungkan</h2>
                <p class="text-gray-600">Siswa: <span class="font-semibold text-green-700">{{ $student->firstname }}
                        {{ $student->lastname }}</span></p>
                <p class="text-gray-600">Course: <span class="font-semibold">{{ $course->fullname }}</span></p>
            </div>
            <a href="{{ route('students.tryoutwhatsapp') }}" class="text-gray-500 hover:text-gray-700 text-sm">
                &larr; Kembali ke Daftar
            </a>
        </div>

        <form action="{{ route('students.tryoutwhatsapp.report') }}" method="GET">
            <div class="bg-white border rounded-xl shadow-sm overflow-hidden mb-6">
                <div class="p-4 bg-gray-50 border-b">
                    <p class="text-xs font-bold uppercase tracking-wider text-gray-500">Daftar Pengerjaan (Attempts)</p>
                </div>

                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50 text-xs font-semibold text-gray-600 uppercase">
                        <tr>
                            <th class="py-3 px-4 text-center w-16">Pilih</th>
                            <th class="py-3 px-4 text-left">Nama Kuis (Tryout)</th>
                            <th class="py-3 px-4 text-left">Waktu Selesai</th>
                            <th class="py-3 px-4 text-center">Skor (Moodle)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($attempts as $att)
                            <tr class="hover:bg-green-50 transition cursor-pointer"
                                onclick="document.getElementById('check_{{ $att->id }}').click()">
                                <td class="py-4 px-4 text-center" onclick="event.stopPropagation()">
                                    <input type="checkbox" name="ids[]" value="{{ $att->id }}" id="check_{{ $att->id }}"
                                        class="w-5 h-5 text-green-600 rounded focus:ring-green-500 cursor-pointer">
                                </td>
                                <td class="py-4 px-4 text-sm font-medium text-gray-800">
                                    {{ $att->quiz_name }}
                                </td>
                                <td class="py-4 px-4 text-sm text-gray-600">
                                    {{ $att->tanggal }}
                                </td>
                                <td class="py-4 px-4 text-center text-sm font-semibold text-blue-600">
                                    {{ round($att->sumgrades, 2) }} / {{ round($att->max_grade, 2) }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-8 text-center text-gray-500">Tidak ada pengerjaan kuis ditemukan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="flex justify-end">
                <button type="submit"
                    class="bg-green-600 hover:bg-green-700 text-white px-8 py-3 rounded-xl font-bold shadow-lg transform active:scale-95 transition">
                    📄 Buat Raport Gabungan
                </button>
            </div>
        </form>
    </div>
@endsection