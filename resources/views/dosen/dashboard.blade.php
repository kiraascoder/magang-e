@extends('layouts.app')

@section('title', 'Dashboard Dosen')
@section('page_title', 'Dashboard Dosen')
@section('page_desc', 'Ringkasan bimbingan magang.')

@section('content')
    <div class="space-y-4">
        <div class="grid grid-cols-1 sm:grid-cols-4 gap-3">
            <div class="p-4 rounded-2xl border border-gray-200 bg-white">
                <div class="text-sm text-gray-500">Total Bimbingan</div>
                <div class="mt-1 text-2xl font-semibold">{{ $totalBimbingan }}</div>
            </div>
            <div class="p-4 rounded-2xl border border-gray-200 bg-white">
                <div class="text-sm text-gray-500">Aktif</div>
                <div class="mt-1 text-2xl font-semibold">{{ $aktif }}</div>
            </div>
            <div class="p-4 rounded-2xl border border-gray-200 bg-white">
                <div class="text-sm text-gray-500">Draft</div>
                <div class="mt-1 text-2xl font-semibold">{{ $draft }}</div>
            </div>
            <div class="p-4 rounded-2xl border border-gray-200 bg-white">
                <div class="text-sm text-gray-500">Selesai</div>
                <div class="mt-1 text-2xl font-semibold">{{ $selesai }}</div>
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden">
            <div class="px-4 py-3 border-b border-gray-200 flex items-center justify-between">
                <div class="font-semibold text-gray-900">Penempatan Terbaru</div>
                <a href="{{ route('dosen.mahasiswa') }}" class="text-sm text-gray-700 hover:underline">Lihat semua</a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-gray-600">
                        <tr class="text-left">
                            <th class="px-4 py-3">Mahasiswa</th>
                            <th class="px-4 py-3">Instansi</th>
                            <th class="px-4 py-3">Periode</th>
                            <th class="px-4 py-3">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($latest as $x)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 font-medium text-gray-900">
                                    {{ $x->mahasiswa?->name ?? '-' }}
                                    <div class="text-xs text-gray-500">{{ $x->mahasiswa?->nim ?? '-' }}</div>
                                </td>
                                <td class="px-4 py-3 text-gray-700">{{ $x->instansi?->nama_instansi ?? '-' }}</td>
                                <td class="px-4 py-3 text-gray-700">{{ $x->periode?->nama_periode ?? '-' }}</td>
                                <td class="px-4 py-3">
                                    <span
                                        class="inline-flex px-2 py-1 rounded-md text-xs bg-gray-100 border border-gray-200 capitalize">
                                        {{ $x->status }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-10 text-center text-gray-500">
                                    Belum ada data penempatan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
