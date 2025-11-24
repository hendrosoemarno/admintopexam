@extends('layouts.app')

@section('title', 'Rapor Try Out TKA Quick')

@section('content')
<div class="max-w-2xl mx-auto bg-white shadow rounded-lg p-6">
    <h2 class="text-xl font-bold mb-3">
        TKA SIAP QUICK – HASIL {{ strtoupper($result->firstname) }} {{ strtoupper($result->lastname) }}
    </h2>

    <p class="text-gray-700 mb-2">
        Course: {{ $result->course }}
    </p>

    <p class="text-gray-700 mb-2">
        Tanggal Ujian: {{ $result->tanggal }}
    </p>

    <p class="text-lg font-semibold mt-3">
        Skor Keseluruhan: {{ $result->skor }}/{{ $result->total_soal }}
        ({{ $result->nilai }})
    </p>

    <div class="mt-4 space-y-1">
        <p><strong>Matematika:</strong> 
            {{ $result->math_score ?? 0 }}/{{ $result->math_total }}
        </p>

        <p><strong>Bahasa Indonesia:</strong> 
            {{ $result->bin_score ?? 0 }}/{{ $result->math_total }}
        </p>
    </div>

    <div class="mt-6 text-right">
        <a href="{{ route('students.tryoutquick') }}" 
           class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded">
           ← Kembali
        </a>
    </div>
</div>
@endsection
