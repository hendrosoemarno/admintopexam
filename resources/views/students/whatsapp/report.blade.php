@extends('layouts.app')

@section('title', 'Rapor Analisis WhatsApp')

@section('content')
    <div class="max-w-3xl mx-auto bg-white shadow rounded-lg p-6">

        <h2 class="text-xl font-bold mb-4">
            Analisis WhatsApp – HASIL {{ strtoupper($result->firstname) }} {{ strtoupper($result->lastname) }}
            <span class="ml-2 px-2 py-0.5 bg-green-100 text-green-800 text-xs rounded-full uppercase">Gabungan</span>
        </h2>

        <p><strong>Course:</strong> {{ $result->course }}</p>
        <p><strong>Tanggal Ujian:</strong> {{ $result->tanggal }}</p>
        <p class="mb-4"><strong>Jumlah Kuis:</strong> {{ count($ids) }} Kuis Terpilih</p>

        {{-- SKOR TOTAL --}}
        <div class="p-4 mb-6 bg-green-50 border border-green-200 rounded">
            <p class="text-lg font-semibold text-green-800">
                Skor Keseluruhan: {{ $result->nilai }}/100
                ({{ $result->total_label }})
            </p>
            <p class="text-gray-700 text-sm">{{ $result->total_desc }}</p>
        </div>

        {{-- Analisis Detil --}}
        <div class="mb-6">
            <h2 class="font-semibold text-lg mb-2 border-b pb-1">
                Analisis Detil
            </h2>
        </div>

        {{-- BAHASA INDONESIA --}}
        <div class="mb-6">
            <h3 class="font-semibold text-lg mb-2">
                Skor Bahasa Indonesia: {{ $result->bin_final }}/100 ({{ $result->bin_label }})
            </h3>
            <p class="text-gray-700 text-sm mb-2">{{ $result->bin_desc }}</p>

            @if(count($result->detail_bin))
                <p class="font-semibold pl-4">Dengan Rincian:</p>
                <div class="pl-6 space-y-2">
                    @foreach($result->detail_bin as $item)
                        <p class="font-semibold">
                            {{ $loop->iteration }}. {{ $item['nama'] }}:
                        </p>
                        <p class="pl-8">
                            {{ $item['persen'] }}/100 — {{ $item['label'] }} ({{ $item['desc'] }})
                        </p>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- MATEMATIKA --}}
        <div class="mb-6">
            <h3 class="font-semibold text-lg mb-2">
                Skor Matematika: {{ $result->math_final }}/100 ({{ $result->math_label }})
            </h3>
            <p class="text-gray-700 text-sm mb-2">{{ $result->math_desc }}</p>

            @if(count($result->detail_math))
                <p class="font-semibold pl-4">Dengan Rincian:</p>
                <div class="pl-6 space-y-2">
                    @foreach($result->detail_math as $item)
                        <p class="font-semibold">
                            {{ $loop->iteration }}. {{ $item['nama'] }}:
                        </p>
                        <p class="pl-8">
                            {{ $item['persen'] }}/100 — {{ $item['label'] }} ({{ $item['desc'] }})
                        </p>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Rekom Belajar --}}
        <div class="mb-6">
            <h2 class="font-semibold text-lg mb-2 border-b pb-1">
                Rekomendasi Belajar
            </h2>
        </div>

        {{-- rekom BAHASA INDONESIA --}}
        <div class="mb-6">
            <h3 class="font-semibold text-lg mb-2">
                Rekomendasi Belajar Bahasa Indonesia
            </h3>

            @if(count($result->detail_bin))
                <div class="pl-6 space-y-2">
                    @foreach($result->detail_bin as $item)
                        <p>
                            <strong>{{ $loop->iteration }}. {{ $item['nama'] }}:</strong>
                            {{ $item['persen'] }}/100
                            — {{ $item['label'] }}
                        </p>
                        <div class="pl-6 text-sm text-gray-700 space-y-1">
                            @foreach(explode('•', $item['rekom']) as $poin)
                                @if(trim($poin) !== '')
                                    <p>• {{ trim($poin) }}</p>
                                @endif
                            @endforeach
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- rekom MATEMATIKA --}}
        <div class="mb-6">
            <h3 class="font-semibold text-lg mb-2">
                Rekomendasi Belajar Matematika
            </h3>

            @if(count($result->detail_math))
                <div class="pl-6 space-y-2">
                    @foreach($result->detail_math as $item)
                        <p>
                            <strong>{{ $loop->iteration }}. {{ $item['nama'] }}:</strong>
                            {{ $item['persen'] }}/100
                            — {{ $item['label'] }}
                        </p>
                        <div class="pl-6 text-sm text-gray-700 space-y-1">
                            @foreach(explode('•', $item['rekom']) as $poin)
                                @if(trim($poin) !== '')
                                    <p>• {{ trim($poin) }}</p>
                                @endif
                            @endforeach
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="mt-6 text-right">
            <a href="{{ route('students.tryoutwhatsapp.select', [$result->userid, $result->courseid]) }}"
                class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded transition">
                ← Kembali Pilih Kuis
            </a>
        </div>

    </div>
@endsection