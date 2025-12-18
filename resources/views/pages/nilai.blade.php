@extends('layouts.app')

@section('title', 'Nilai')
@section('page_title', 'Nilai')

@section('content')
    <div class="bg-white border border-gray-300 rounded overflow-hidden">
        <div class="p-3 border-b border-gray-200 flex items-center justify-between">
            <div class="text-sm text-gray-600">Rekap Nilai</div>
            <button class="px-3 py-1.5 text-sm border border-gray-300 rounded hover:bg-gray-50">
                Export
            </button>
        </div>

        <table class="w-full text-sm">
            <thead class="bg-gray-100 border-b border-gray-200">
                <tr>
                    <th class="text-left p-3">Komponen</th>
                    <th class="text-left p-3">Nilai</th>
                    <th class="text-right p-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach (['Absensi', 'Logbook', 'Laporan', 'Presentasi'] as $idx => $k)
                    <tr class="border-b border-gray-200 last:border-b-0">
                        <td class="p-3">{{ $k }}</td>
                        <td class="p-3">{{ [90, 85, 88, 92][$idx] }}</td>
                        <td class="p-3 text-right space-x-2">
                            <button class="px-3 py-1 border border-gray-300 rounded hover:bg-gray-50">Edit</button>
                            <button class="px-3 py-1 border border-gray-300 rounded hover:bg-gray-50">Detail</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
