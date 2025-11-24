@extends('layouts.app')

@section('title', 'Detail Siswa')

@section('content')
<div class="max-w-4xl mx-auto bg-white shadow rounded-lg p-6">
    <div class="flex items-center space-x-4 mb-4">
        <img src="https://ui-avatars.com/api/?name={{ urlencode($student->firstname.' '.$student->lastname) }}&background=0D8ABC&color=fff"
             class="w-24 h-24 rounded-full shadow">
        <div>
            <h2 class="text-2xl font-semibold">{{ $student->firstname }} {{ $student->lastname }}</h2>
            <p class="text-gray-500">{{ $student->email }}</p>
            <p class="text-sm text-gray-500">
                <strong>Tanggal Registrasi:</strong>
                @if(!empty($student->timecreated))
                    {{ date('d F Y', $student->timecreated) }}
                @else
                    Tidak tersedia
                @endif
            </p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <h3 class="font-semibold mb-2 text-blue-700">Data Pribadi</h3>
            <p><strong>Tempat Lahir:</strong> {{ $extra['birth_place'] ?? '-' }}</p>
            <p><strong>Tanggal Lahir:</strong> 
                @if(isset($extra['birth_date']))
                    {{ date('d-m-Y', (int)$extra['birth_date']) }}
                @else
                    -
                @endif
            </p>
            <p><strong>Alamat:</strong> {!! $extra['address'] ?? '-' !!}</p>
            <p><strong>Kelas:</strong> {{ $extra['grade'] ?? '-' }}</p>
            <p><strong>Sekolah:</strong> {{ $extra['school'] ?? '-' }}</p>
        </div>

        <div>
            <h3 class="font-semibold mb-2 text-blue-700">Data Orang Tua</h3>
            <p><strong>Nama Orang Tua:</strong> {{ $extra['parent_name'] ?? '-' }}</p>
            <p><strong>WA Siswa:</strong> {{ $extra['student_WA'] ?? '-' }}</p>
            <p><strong>WA Orang Tua:</strong> {{ $extra['parent_wa'] ?? '-' }}</p>
        </div>
    </div>

    <div class="mt-6 text-right">
        <a href="{{ route('students.index') }}"
           class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded">
           ← Kembali
        </a>
    </div>
</div>
@endsection
