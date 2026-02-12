@extends('layouts.app')

@section('title', 'ANALISIS WHATSAPP')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-green-700 uppercase tracking-tight">📱 Analisis WhatsApp</h2>
        <a href="{{ route('students.tryoutwhatsapp.history') }}"
            class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-xl text-sm font-bold shadow-lg transition">
            📋 Riwayat Laporan WA
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-xl border border-green-200 text-sm font-bold">
            ✅ {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-xl border border-red-200 text-sm font-bold">
            ❌ {{ session('error') }}
        </div>
    @endif

    @if (empty($data))
        <div class="bg-white p-8 rounded-xl shadow-sm text-center border">
            <p class="text-gray-500">Belum ada siswa yang mengikuti ANALISIS WHATSAPP.</p>
        </div>
    @else
        <div class="bg-white border rounded-xl shadow-sm overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50 text-xs font-bold text-gray-500 uppercase">
                    <tr>
                        <th class="py-4 px-6 text-left">Nama Siswa</th>
                        <th class="py-4 px-6 text-left">Nama Orang Tua</th>
                        <th class="py-4 px-6 text-left">WA Siswa</th>
                        <th class="py-4 px-6 text-left">WA Orang Tua</th>
                        <th class="py-4 px-6 text-left">Course</th>
                        <th class="py-4 px-6 text-center">Attempts</th>
                        <th class="py-4 px-6 text-left">Akses Terakhir</th>
                        <th class="py-4 px-6 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($data as $d)
                        <tr class="hover:bg-green-50 transition">
                            <td class="py-4 px-6 text-sm font-semibold text-gray-800">{{ $d->nama_siswa }}</td>
                            <td class="py-4 px-6 text-sm text-gray-600 whitespace-nowrap">{{ $d->parent_name }}</td>
                            <td class="py-4 px-6 text-sm text-gray-600 whitespace-nowrap">{{ $d->student_WA }}</td>
                            <td class="py-4 px-6 text-sm text-gray-600 whitespace-nowrap">{{ $d->parent_wa }}</td>
                            <td class="py-4 px-6 text-sm text-gray-600">{{ $d->nama_course }}</td>
                            <td class="py-4 px-6 text-center">
                                <span class="px-2.5 py-1 bg-green-100 text-green-800 rounded-full text-xs font-bold">
                                    {{ $d->total_attempts }} Kuis
                                </span>
                            </td>
                            <td class="py-4 px-6 text-sm text-gray-500 font-mono whitespace-nowrap">{{ $d->terakhir_akses }}</td>
                            <td class="py-4 px-6 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    {{-- Tombol Raport --}}
                                    <a href="{{ route('students.tryoutwhatsapp.select', [$d->userid, $d->courseid]) }}"
                                        class="inline-flex items-center bg-green-600 hover:bg-green-700 text-white px-4 py-1.5 rounded-lg text-xs font-bold transition shadow-sm whitespace-nowrap">
                                        📊 Raport
                                    </a>

                                    {{-- Tombol Lapor --}}
                                    <form action="{{ route('students.tryoutwhatsapp.store_report') }}" method="POST"
                                        style="margin: 0; display: inline;">
                                        @csrf
                                        <input type="hidden" name="id_user" value="{{ $d->userid }}">
                                        <input type="hidden" name="id_course" value="{{ $d->courseid }}">
                                        <input type="hidden" name="tanggal_kirim" value="{{ date('Y-m-d H:i:s') }}">
                                        <button type="submit"
                                            onclick="return confirm('Apakah Anda yakin ingin mencatat pengiriman laporan untuk {{ $d->nama_siswa }}?')"
                                            class="inline-flex items-center"
                                            style="background-color: #f97316; color: white !important; padding: 6px 16px; border-radius: 8px; font-weight: bold; border: none; cursor: pointer; font-size: 12px; transition: 0.2s; box-shadow: 0 1px 2px rgba(0,0,0,0.1); white-space: nowrap;">
                                            <span style="margin-right: 4px;">🚀</span>
                                            <span style="color: white !important; display: inline !important;">Lapor</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
@endsection