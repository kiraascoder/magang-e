@extends('layouts.app')

@section('title', 'Jurnal Mahasiswa')
@section('page_title', 'Jurnal')
@section('page_desc', 'Review jurnal pekan mahasiswa bimbingan.')

@section('content')
    <div class="space-y-4">

        @if (session('success'))
            <div class="p-3 rounded-lg border border-emerald-200 bg-emerald-50 text-emerald-700 text-sm">
                {{ session('success') }}
            </div>
        @endif

        <form method="GET" action="{{ route('dosen.jurnal') }}" class="flex flex-col sm:flex-row gap-2">
            <input type="text" name="q" value="{{ $q ?? '' }}" placeholder="Cari nama / NIM..."
                class="w-full sm:w-80 px-3 py-2 rounded-lg border border-gray-200">
            <select name="status" class="w-full sm:w-44 px-3 py-2 rounded-lg border border-gray-200">
                <option value="">Semua Status</option>
                @foreach (['draft', 'terkirim', 'disetujui', 'ditolak'] as $st)
                    <option value="{{ $st }}" {{ request('status') === $st ? 'selected' : '' }}>{{ ucfirst($st) }}
                    </option>
                @endforeach
            </select>
            <button class="px-3 py-2 rounded-lg bg-white border border-gray-200 hover:bg-gray-50 text-sm">Filter</button>
        </form>

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
                            <th class="px-4 py-3">Mahasiswa</th>
                            <th class="px-4 py-3">Instansi</th>
                            <th class="px-4 py-3">Periode</th>
                            <th class="px-4 py-3">Total Jam</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3 w-28">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($items as $x)
                            @php
                                $jam = intdiv((int) $x->total_menit, 60);
                                $men = (int) $x->total_menit % 60;
                            @endphp
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 font-medium text-gray-900">Pekan ke-{{ $x->pekan_ke }}</td>
                                <td class="px-4 py-3">
                                    <div class="font-medium text-gray-900">{{ $x->mahasiswa?->name ?? '-' }}</div>
                                    <div class="text-xs text-gray-500">{{ $x->mahasiswa?->nim ?? '-' }}</div>
                                </td>
                                <td class="px-4 py-3 text-gray-700">{{ $x->penempatan?->instansi?->nama_instansi ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-gray-700">{{ $x->penempatan?->periode?->nama_periode ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-gray-700">{{ $jam }}j {{ $men }}m</td>
                                <td class="px-4 py-3">
                                    <span
                                        class="inline-flex px-2 py-1 rounded-md text-xs bg-gray-100 border border-gray-200 capitalize">
                                        {{ $x->status }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <a href="{{ route('dosen.jurnal.show', $x->id_jurnal_pekan) }}"
                                        class="px-3 py-1.5 rounded-lg border border-gray-200 hover:bg-gray-50 text-xs">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-10 text-center text-gray-500">Belum ada jurnal.</td>
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
