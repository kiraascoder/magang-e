@extends('layouts.app')

@section('title', 'Magang')
@section('page_title', 'Magang')

@section('content')
    <div class="space-y-3">
        <div class="flex justify-end">
            <input class="w-72 max-w-full px-3 py-2 border border-gray-300 rounded bg-white" placeholder="Cari..." />
        </div>

        <div class="bg-white border border-gray-300 rounded overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-gray-100 border-b border-gray-200">
                    <tr>
                        <th class="p-3 text-left">Nama</th>
                        <th class="p-3 text-left">Instansi</th>
                        <th class="p-3 text-left">Periode</th>
                        <th class="p-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @for ($i = 1; $i <= 4; $i++)
                        <tr class="border-b border-gray-200 last:border-b-0">
                            <td class="p-3">Mahasiswa {{ $i }}</td>
                            <td class="p-3">Instansi {{ $i }}</td>
                            <td class="p-3">2025</td>
                            <td class="p-3 text-right">
                                <button class="px-3 py-1 border border-gray-300 rounded hover:bg-gray-50">Detail</button>
                            </td>
                        </tr>
                    @endfor
                </tbody>
            </table>
        </div>
    </div>
@endsection
