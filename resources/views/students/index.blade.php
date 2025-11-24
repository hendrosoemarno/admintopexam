@extends('layouts.app')

@section('title', 'Daftar Siswa')

@section('content')
<h2 class="text-2xl font-semibold mb-4">Daftar Siswa</h2>

<table class="min-w-full bg-white border rounded-lg">
    <thead>
        <tr class="bg-gray-100 border-b">
            <th class="py-2 px-3 text-left">Nama Siswa</th>
            <th class="py-2 px-3 text-left">Nama Orang Tua</th>
            <th class="py-2 px-3 text-left">WA Siswa</th>
            <th class="py-2 px-3 text-left">WA Orang Tua</th>
            <th class="py-2 px-3 text-center">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($students as $s)
            @php
                $info = $userData[$s->id] ?? [];
            @endphp
            <tr class="border-b hover:bg-gray-50">
                <td class="py-2 px-3">{{ $s->firstname }} {{ $s->lastname }}</td>
                <td class="py-2 px-3">{{ $info['parent_name'] ?? '-' }}</td>
                <td class="py-2 px-3">{{ $info['student_WA'] ?? '-' }}</td>
                <td class="py-2 px-3">{{ $info['parent_wa'] ?? '-' }}</td>
                <td class="py-2 px-3 text-center">
                    <a href="{{ route('students.show', $s->id) }}"
                       class="bg-blue-500 hover:bg-blue-600 text-white text-sm px-3 py-1 rounded">
                       Lihat Detail
                    </a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection
