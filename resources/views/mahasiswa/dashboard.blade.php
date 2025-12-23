@extends('layouts.app')

@section('title', 'Dashboard Mahasiswa')
@section('page_title', 'Dashboard Mahasiswa')
@section('page_desc', 'Ringkasan penempatan dan aktivitas magang kamu.')

@section('content')
    <div class="space-y-4">

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
            <div class="p-4 rounded-2xl border border-gray-200 bg-white">
                <div class="text-sm text-gray-500">Total Penempatan</div>
                <div class="mt-1 text-2xl font-semibold">{{ $total }}</div>
            </div>
            <div class="p-4 rounded-2xl border border-gray-200 bg-white">
                <div class="text-sm text-gray-500">Aktif</div>
                <div class="mt-1 text-2xl font-semibold">{{ $aktif }}</div>
            </div>
            <div class="p-4 rounded-2xl border border-gray-200 bg-white">
                <div class="text-sm text-gray-500">Selesai</div>
                <div class="mt-1 text-2xl font-semibold">{{ $selesai }}</div>
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden">
            <div class="px-4 py-3 border-b border-gray-200 flex items-center justify-between">
                <div class="font-semibold text-gray-900">Penempatan Aktif / Terbaru</div>
                <span class="text-xs text-gray-500">Status: {{ $penempatanAktif?->status ?? '-' }}</span>
            </div>

            <div class="p-4">
                @if ($penempatanAktif)
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                        <div>
                            <div class="text-gray-500">Mentor</div>
                            <div class="font-medium text-gray-900">
                                {{ $penempatanAktif->mentor?->name ?? '-' }}
                                <span
                                    class="text-gray-500 text-xs">{{ $penempatanAktif->mentor?->nbm ? '(' . $penempatanAktif->mentor->nbm . ')' : '' }}</span>
                            </div>
                        </div>
                        <div>
                            <div class="text-gray-500">Instansi</div>
                            <div class="font-medium text-gray-900">{{ $penempatanAktif->instansi?->nama_instansi ?? '-' }}
                            </div>
                        </div>
                        <div>
                            <div class="text-gray-500">Periode</div>
                            <div class="font-medium text-gray-900">{{ $penempatanAktif->periode?->nama_periode ?? '-' }}
                            </div>
                        </div>
                        <div>
                            <div class="text-gray-500">Durasi</div>
                            <div class="font-medium text-gray-900">
                                {{ $penempatanAktif->tgl_mulai ? \Carbon\Carbon::parse($penempatanAktif->tgl_mulai)->format('d-m-Y') : '-' }}
                                —
                                {{ $penempatanAktif->tgl_selesai ? \Carbon\Carbon::parse($penempatanAktif->tgl_selesai)->format('d-m-Y') : '-' }}
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 flex flex-wrap gap-2">
                        <a href="{{ route('mahasiswa.logbook') }}"
                            class="px-3 py-2 rounded-lg border border-gray-200 hover:bg-gray-50 text-sm">Isi Logbook</a>
                        <a href="{{ route('mahasiswa.jurnal') }}"
                            class="px-3 py-2 rounded-lg border border-gray-200 hover:bg-gray-50 text-sm">Jurnal</a>
                        <a href="{{ route('mahasiswa.laporan') }}"
                            class="px-3 py-2 rounded-lg border border-gray-200 hover:bg-gray-50 text-sm">Upload Laporan</a>
                        <a href="{{ route('mahasiswa.nilai') }}"
                            class="px-3 py-2 rounded-lg border border-gray-200 hover:bg-gray-50 text-sm">Lihat Nilai</a>
                    </div>
                @else
                    <div class="text-gray-600">
                        Kamu belum punya penempatan. Hubungi admin untuk dibuatkan penempatan.
                    </div>
                @endif
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden">
            <div class="px-4 py-3 border-b border-gray-200 flex items-center justify-between">
                <div class="font-semibold text-gray-900">Riwayat Penempatan</div>
                <div class="text-xs text-gray-500">Menampilkan {{ $riwayat->count() }} data</div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-gray-600">
                        <tr class="text-left">
                            <th class="px-4 py-3">Periode</th>
                            <th class="px-4 py-3">Instansi</th>
                            <th class="px-4 py-3">Mentor</th>
                            <th class="px-4 py-3">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($riwayat as $x)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-gray-900">{{ $x->periode?->nama_periode ?? '-' }}</td>
                                <td class="px-4 py-3 text-gray-700">{{ $x->instansi?->nama_instansi ?? '-' }}</td>
                                <td class="px-4 py-3 text-gray-700">{{ $x->mentor?->name ?? '-' }}</td>
                                <td class="px-4 py-3">
                                    <span
                                        class="inline-flex px-2 py-1 rounded-md text-xs bg-gray-100 border border-gray-200 capitalize">
                                        {{ $x->status }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-10 text-center text-gray-500">Belum ada riwayat.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection
