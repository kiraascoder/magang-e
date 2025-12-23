@extends('layouts.app')

@section('title', 'Detail Jurnal')
@section('page_title', 'Review Jurnal Pekan')
@section('page_desc', 'Periksa jurnal harian mahasiswa dan berikan persetujuan atau penolakan.')

@section('content')
    <div class="space-y-4">

        @if (session('success'))
            <div class="p-3 rounded-lg border border-emerald-200 bg-emerald-50 text-emerald-700 text-sm">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="p-3 rounded-lg border border-red-200 bg-red-50 text-red-700 text-sm">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @php
            $jamTotal = intdiv((int) $pekan->total_menit, 60);
            $menTotal = (int) $pekan->total_menit % 60;

            $range =
                $pekan->tanggal_mulai && $pekan->tanggal_selesai
                    ? \Carbon\Carbon::parse($pekan->tanggal_mulai)->format('d M Y') .
                        ' - ' .
                        \Carbon\Carbon::parse($pekan->tanggal_selesai)->format('d M Y')
                    : '-';
        @endphp

        <div class="bg-white border border-gray-200 rounded-2xl p-5">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <div class="text-sm text-gray-500">Mahasiswa</div>
                    <div class="text-xl font-extrabold text-gray-900">{{ $pekan->mahasiswa?->name ?? '-' }}</div>
                    <div class="mt-1 text-sm text-gray-600">
                        NIM: {{ $pekan->mahasiswa?->nim ?? '-' }} • Pekan ke-{{ $pekan->pekan_ke }} • {{ $range }}
                    </div>
                    <div class="mt-1 text-sm text-gray-600">
                        Instansi: {{ $pekan->penempatan?->instansi?->nama_instansi ?? '-' }}
                        • Periode: {{ $pekan->penempatan?->periode?->nama_periode ?? '-' }}
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <span class="inline-flex px-2 py-1 rounded-md text-xs bg-gray-100 border border-gray-200 capitalize">
                        {{ $pekan->status }}
                    </span>
                </div>
            </div>

            <div class="mt-4 text-sm text-gray-700">
                Total Mingguan: <span class="font-semibold">{{ $jamTotal }} Jam {{ $menTotal }} Menit</span>
            </div>

            @if ($pekan->catatan_mentor)
                <div class="mt-4 p-3 rounded-lg border border-amber-200 bg-amber-50 text-amber-800 text-sm">
                    <div class="font-semibold">Catatan Mentor</div>
                    <div class="mt-1 whitespace-pre-line">{{ $pekan->catatan_mentor }}</div>
                </div>
            @endif
        </div>

        <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden">
            <div class="px-4 py-3 border-b border-gray-200 flex items-center justify-between">
                <div class="font-semibold text-gray-900">Detail Harian</div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-gray-600">
                        <tr class="text-left">
                            <th class="px-4 py-3 w-44">Hari/Tanggal</th>
                            <th class="px-4 py-3 w-28">Datang</th>
                            <th class="px-4 py-3 w-28">Pulang</th>
                            <th class="px-4 py-3 w-36">Jumlah Jam</th>
                            <th class="px-4 py-3">Kegiatan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($pekan->harian as $h)
                            @php
                                $hari = \Carbon\Carbon::parse($h->tanggal)->translatedFormat('l');
                                $tgl = \Carbon\Carbon::parse($h->tanggal)->format('d-m-Y');
                                $jam = intdiv((int) $h->jumlah_menit, 60);
                                $men = (int) $h->jumlah_menit % 60;
                            @endphp
                            <tr class="align-top">
                                <td class="px-4 py-3">
                                    <div class="font-medium text-gray-900">{{ $hari }}</div>
                                    <div class="text-xs text-gray-500">{{ $tgl }}</div>
                                </td>
                                <td class="px-4 py-3 text-gray-700">
                                    {{ $h->jam_datang ? \Carbon\Carbon::parse($h->jam_datang)->format('H:i') : '-' }}
                                </td>
                                <td class="px-4 py-3 text-gray-700">
                                    {{ $h->jam_pulang ? \Carbon\Carbon::parse($h->jam_pulang)->format('H:i') : '-' }}
                                </td>
                                <td class="px-4 py-3 text-gray-700">{{ $jam }}j {{ $men }}m</td>
                                <td class="px-4 py-3 text-gray-700 whitespace-pre-line">{{ $h->kegiatan ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Approve / Reject --}}
        <div class="bg-white border border-gray-200 rounded-2xl p-5">
            <div class="font-semibold text-gray-900">Keputusan Mentor</div>

            @if ($pekan->status !== 'terkirim')
                <div class="mt-2 text-sm text-gray-600">
                    Jurnal hanya bisa diproses ketika status <span class="font-semibold">terkirim</span>.
                </div>
            @else
                <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-3">
                    <form method="POST" action="{{ route('dosen.jurnal.approve', $pekan->id_jurnal_pekan) }}"
                        class="space-y-2">
                        @csrf
                        @method('PATCH')
                        <label class="text-sm font-medium text-gray-700">Catatan (opsional)</label>
                        <textarea name="catatan_mentor" rows="3" class="w-full px-3 py-2 rounded-lg border border-gray-200"
                            placeholder="Catatan untuk mahasiswa..."></textarea>
                        <button class="w-full px-3 py-2 rounded-lg bg-gray-900 text-white hover:bg-gray-800 text-sm">
                            Setujui
                        </button>
                    </form>

                    <form method="POST" action="{{ route('dosen.jurnal.reject', $pekan->id_jurnal_pekan) }}"
                        class="space-y-2">
                        @csrf
                        @method('PATCH')
                        <label class="text-sm font-medium text-gray-700">Catatan penolakan (wajib)</label>
                        <textarea name="catatan_mentor" rows="3" class="w-full px-3 py-2 rounded-lg border border-gray-200"
                            placeholder="Alasan ditolak / perbaikan yang diminta..." required></textarea>
                        <button
                            class="w-full px-3 py-2 rounded-lg border border-red-200 text-red-600 hover:bg-red-50 text-sm">
                            Tolak
                        </button>
                    </form>
                </div>
            @endif
        </div>

        <div>
            <a href="{{ route('dosen.jurnal') }}"
                class="inline-flex items-center px-4 py-2 rounded-lg border border-gray-200 hover:bg-gray-50 text-sm">
                ← Kembali
            </a>
        </div>

    </div>
@endsection
