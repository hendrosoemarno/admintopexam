@extends('layouts.app')

@section('title', 'Nilai Siswa')

@section('content')
<h2 class="text-2xl font-semibold mb-4">Nilai Siswa (Try Out)</h2>

@if (session('error'))
<div class="bg-red-100 text-red-700 p-3 rounded mb-4">
    {{ session('error') }}
</div>
@endif

<table class="min-w-full bg-white border rounded-lg shadow">
    <thead>
        <tr class="bg-gray-100 border-b text-sm font-semibold text-gray-700">
            <th class="py-2 px-3 text-left">Nama Siswa</th>
            <th class="py-2 px-3 text-left">Course</th>
            <th class="py-2 px-3 text-left">Quiz</th>
            <th class="py-2 px-3 text-left">Kategori Soal</th>
            <th class="py-2 px-3 text-center">Hasil</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $d)
        <tr class="border-b hover:bg-gray-50 text-sm">
            <td class="py-2 px-3">{{ $d->nama_siswa }}</td>
            <td class="py-2 px-3">{{ $d->nama_course }}</td>
            <td class="py-2 px-3">{{ $d->nama_quiz }}</td>
            <td class="py-2 px-3">{{ $d->category_clean }}</td>
            <td class="py-2 px-3 text-center">
                @if ($d->status_label === 'Benar')
                    <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs font-semibold">Benar</span>
                @else
                    <span class="bg-red-100 text-red-700 px-2 py-1 rounded text-xs font-semibold">Salah</span>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
