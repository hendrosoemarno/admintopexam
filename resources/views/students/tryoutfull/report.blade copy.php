@extends('layouts.app')

@section('title', 'Rapor Try Out TKA Full')

@section('content')
<div class="max-w-3xl mx-auto bg-white shadow rounded-lg p-6">

    {{-- Judul --}}
    <h2 class="text-xl font-bold mb-4">
        TKA SIAP Full – HASIL {{ strtoupper($result->firstname) }} {{ strtoupper($result->lastname) }}
    </h2>

    {{-- Informasi utama --}}
    <p><strong>Course:</strong> {{ $result->course }}</p>
    <p class="mb-4"><strong>Tanggal Ujian Terakhir:</strong> {{ $result->tanggal }}</p>


    {{-- ========================================= --}}
    {{-- NILAI KESELURUHAN --}}
    {{-- ========================================= --}}
    <div class="p-4 mb-6 bg-blue-50 border border-blue-200 rounded">
        <p class="text-lg font-semibold">
            Skor Keseluruhan: {{ $result->nilai }}/100 ({{ $result->total_label }})
        </p>
        <p class="text-gray-700 text-sm">
            {{ $result->total_desc }}
        </p>
    </div>


    {{-- ========================================= --}}
    {{-- MATEMATIKA --}}
    {{-- ========================================= --}}
    <div class="mb-6">
        <h3 class="font-semibold text-lg mb-2">
            Skor Matematika: {{ $result->math_final }}/100 ({{ $result->math_label }})
        </h3>
        <p class="text-gray-700 text-sm mb-3">
            {{ $result->math_desc }}
        </p>

        @if(count($result->detail_math))
            <p class="font-semibold pl-4">Dengan Rincian:</p>

            <div class="pl-6 space-y-2 mt-2">
                @foreach($result->detail_math as $item)
                    <p>
                        <strong>{{ $item['nama'] }}:</strong>
                        {{ $item['persen'] }}/100 —
                        <strong>{{ $item['label'] }}</strong>
                        ({{ $item['desc'] }})
                    </p>
                @endforeach
            </div>
        @else
            <p class="text-gray-500 text-sm pl-4 italic">Tidak ada data Matematika.</p>
        @endif
    </div>


    {{-- ========================================= --}}
    {{-- BAHASA INDONESIA --}}
    {{-- ========================================= --}}
    <div class="mb-6">
        <h3 class="font-semibold text-lg mb-2">
            Skor Bahasa Indonesia: {{ $result->bin_final }}/100 ({{ $result->bin_label }})
        </h3>
        <p class="text-gray-700 text-sm mb-3">
            {{ $result->bin_desc }}
        </p>

        @if(count($result->detail_bin))
            <p class="font-semibold pl-4">Dengan Rincian:</p>

            <div class="pl-6 space-y-2 mt-2">
                @foreach($result->detail_bin as $item)
                    <p>
                        <strong>{{ $item['nama'] }}:</strong>
                        {{ $item['persen'] }}/100 —
                        <strong>{{ $item['label'] }}</strong>
                        ({{ $item['desc'] }})
                    </p>
                @endforeach
            </div>
        @else
            <p class="text-gray-500 text-sm pl-4 italic">Tidak ada data Bahasa Indonesia.</p>
        @endif
    </div>


    {{-- Tombol kembali --}}
    <div class="text-right mt-6">
        <a href="{{ route('students.tryoutfull') }}"
           class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded">
            ← Kembali
        </a>
    </div>

</div>
@endsection
