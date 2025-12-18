@extends('layouts.app')

@section('title', 'Laporan')
@section('page_title', 'Laporan')

@section('content')
    <div class="space-y-4">

        <div class="flex items-center justify-between">
            <div class="w-40 h-28 bg-white border border-gray-300 rounded"></div>
            <div class="w-24 h-10 bg-white border border-gray-300 rounded"></div>
        </div>

        <div class="bg-white border border-gray-300 rounded overflow-hidden">
            <div class="p-3 border-b border-gray-200 flex items-center justify-between">
                <div class="text-sm text-gray-600">Daftar Laporan</div>
                <button class="px-3 py-1.5 text-sm border border-gray-300 rounded hover:bg-gray-50">
                    + Tambah
                </button>
            </div>

            <table class="w-full text-sm">
                <thead class="bg-gray-100 border-b border-gray-200">
                    <tr>
                        <th class="text-left p-3">Tanggal</th>
                        <th class="text-left p-3">Judul</th>
                        <th class="text-left p-3">Status</th>
                        <th class="text-right p-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @for ($i = 1; $i <= 4; $i++)
                        <tr class="border-b border-gray-200 last:border-b-0">
                            <td class="p-3">2025-12-{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}</td>
                            <td class="p-3">Laporan Kegiatan #{{ $i }}</td>
                            <td class="p-3"><span class="px-2 py-1 border border-gray-300 rounded">Draft</span></td>
                            <td class="p-3 text-right">
                                <a class="px-2 py-1 border border-gray-300 rounded hover:bg-gray-50"
                                    href="#">Detail</a>
                            </td>
                        </tr>
                    @endfor
                </tbody>
            </table>
        </div>

    </div>
@endsection
