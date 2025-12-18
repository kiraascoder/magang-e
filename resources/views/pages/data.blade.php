@extends('layouts.app')

@section('title', 'Data')
@section('page_title', 'Data')

@section('content')
    <div class="bg-white border border-gray-300 rounded overflow-hidden">
        <div class="p-3 border-b border-gray-200 flex items-center justify-between">
            <div class="text-sm text-gray-600">Data Master</div>
            <button class="px-3 py-1.5 text-sm border border-gray-300 rounded hover:bg-gray-50">
                + Tambah
            </button>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-100 border-b border-gray-200">
                    <tr>
                        <th class="p-3 text-left">Kolom 1</th>
                        <th class="p-3 text-left">Kolom 2</th>
                        <th class="p-3 text-left">Kolom 3</th>
                        <th class="p-3 text-left">Kolom 4</th>
                        <th class="p-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @for ($i = 1; $i <= 6; $i++)
                        <tr class="border-b border-gray-200 last:border-b-0">
                            <td class="p-3">Data {{ $i }}</td>
                            <td class="p-3">---</td>
                            <td class="p-3">---</td>
                            <td class="p-3">---</td>
                            <td class="p-3 text-right">
                                <button class="px-3 py-1 border border-gray-300 rounded hover:bg-gray-50">Edit</button>
                            </td>
                        </tr>
                    @endfor
                </tbody>
            </table>
        </div>
    </div>
@endsection
