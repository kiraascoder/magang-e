@extends('layouts.app')

@section('title', 'Jurnal')
@section('page_title', 'Jurnal Harian')
@section('page_desc', 'Kelola jurnal harian (per pekan).')

@section('content')
    <div class="space-y-4">

        @if (session('success'))
            <div class="p-3 rounded-lg border border-emerald-200 bg-emerald-50 text-emerald-700 text-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex items-center justify-between gap-3">
            <div class="text-sm text-gray-600">
                Penempatan: <span class="font-semibold text-gray-900">#{{ $penempatan->id_penempatan }}</span>
            </div>

            <a href="{{ route('mahasiswa.jurnal.create') }}"
                class="inline-flex items-center gap-2 px-3 py-2 rounded-lg bg-gray-900 text-white hover:bg-gray-800 text-sm">
                <span class="text-base">+</span> Buat Pekan
            </a>
        </div>

        <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden">
            <div class="px-4 py-3 border-b border-gray-200 flex items-center justify-between">
                <div class="font-semibold text-gray-900">Daftar Jurnal Pekan</div>
                <div class="text-xs text-gray-500">Total: {{ $items->total() }}</div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-gray-600">
                        <tr class="text-left">
                            <th class="px-4 py-3">Pekan</th>
                            <th class="px-4 py-3">Tanggal</th>
                            <th class="px-4 py-3">Total Jam</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3 w-36">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($items as $x)
                            @php
                                $jam = intdiv((int) $x->total_menit, 60);
                                $men = (int) $x->total_menit % 60;
                                $range =
                                    $x->tanggal_mulai && $x->tanggal_selesai
                                        ? \Carbon\Carbon::parse($x->tanggal_mulai)->format('d M Y') .
                                            ' - ' .
                                            \Carbon\Carbon::parse($x->tanggal_selesai)->format('d M Y')
                                        : '-';
                            @endphp
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 font-medium text-gray-900">Pekan ke-{{ $x->pekan_ke }}</td>
                                <td class="px-4 py-3 text-gray-700">{{ $range }}</td>
                                <td class="px-4 py-3 text-gray-700">{{ $jam }}j {{ $men }}m</td>
                                <td class="px-4 py-3">
                                    <span
                                        class="inline-flex px-2 py-1 rounded-md text-xs bg-gray-100 border border-gray-200 capitalize">
                                        {{ $x->status }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <a href="{{ route('mahasiswa.jurnal.show', $x->id_jurnal_pekan) }}"
                                        class="px-3 py-1.5 rounded-lg border border-gray-200 hover:bg-gray-50 text-xs">
                                        Buka
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-10 text-center text-gray-500">Belum ada jurnal pekan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="px-4 py-3 border-t border-gray-200 flex items-center justify-between text-sm text-gray-600">
                <span>Menampilkan {{ $items->firstItem() ?? 0 }} - {{ $items->lastItem() ?? 0 }} dari
                    {{ $items->total() }}</span>
                <div>{{ $items->links() }}</div>
            </div>
        </div>
    </div>
@endsection
