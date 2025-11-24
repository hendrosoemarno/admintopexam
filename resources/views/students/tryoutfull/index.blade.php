@extends('layouts.app')

@section('title', 'TKA SIAP FULL')

@section('content')
<h2 class="text-2xl font-semibold mb-4">TKA SIAP FULL</h2>

@if (empty($data))
    <p class="text-gray-600">Belum ada siswa yang mengikuti TKA SIAP FULL.</p>
@else
<table class="min-w-full bg-white border rounded-lg shadow">
    <thead class="bg-gray-100 border-b text-sm font-semibold text-gray-700">
        <tr>
            <th class="py-2 px-3 text-left">Nama Siswa</th>
            <th class="py-2 px-3 text-left">Course</th>
            <th class="py-2 px-3 text-left">Quiz</th>
            <th class="py-2 px-3 text-left">Tanggal Akses</th>
            <th class="py-2 px-3 text-center">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $d)
        <tr class="border-b hover:bg-gray-50 text-sm">
            <td class="py-2 px-3">{{ $d->nama_siswa }}</td>
            <td class="py-2 px-3">{{ $d->nama_course }}</td>
            <td class="py-2 px-3">{{ $d->tanggal_akses }}</td>
            <td class="py-2 px-3 text-center">
                <a href="{{ route('students.tryoutfull.show', [$d->userid, $d->courseid]) }}"
                   class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-xs">
                    📄 Lihat Raport
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endif
@endsection
