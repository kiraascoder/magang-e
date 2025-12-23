@extends('layouts.app')

@section('title', 'Detail Jurnal')
@section('page_title', 'Jurnal Harian')
@section('page_desc', 'Isi jurnal harian (Senin–Sabtu) dan kirim ke dosen mentor untuk review.')

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

            $editable = in_array($pekan->status, ['draft', 'ditolak']);
        @endphp

        {{-- Header pekan --}}
        <div class="bg-white border border-gray-200 rounded-2xl p-5">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <div class="text-sm text-gray-500">Pekan</div>
                    <div class="text-xl font-extrabold text-gray-900">Pekan ke-{{ $pekan->pekan_ke }}</div>
                    <div class="mt-1 text-sm text-gray-600">Tanggal: {{ $range }}</div>
                </div>

                <div class="flex items-center gap-2">
                    <span class="inline-flex px-2 py-1 rounded-md text-xs bg-gray-100 border border-gray-200 capitalize">
                        {{ $pekan->status }}
                    </span>

                    @if ($pekan->status === 'draft')
                        <form method="POST" action="{{ route('mahasiswa.jurnal.submit', $pekan->id_jurnal_pekan) }}">
                            @csrf
                            @method('PATCH')
                            <button class="px-3 py-2 rounded-lg bg-gray-900 text-white hover:bg-gray-800 text-sm">
                                Kirim ke Mentor
                            </button>
                        </form>
                    @endif

                    @if (in_array($pekan->status, ['draft', 'ditolak']))
                        <form method="POST" action="{{ route('mahasiswa.jurnal.destroy', $pekan->id_jurnal_pekan) }}"
                            onsubmit="return confirm('Yakin hapus jurnal pekan ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="px-3 py-2 rounded-lg border border-red-200 text-red-600 hover:bg-red-50 text-sm">
                                Hapus
                            </button>
                        </form>
                    @endif
                </div>
            </div>

            @if ($pekan->catatan_mentor)
                <div class="mt-4 p-3 rounded-lg border border-amber-200 bg-amber-50 text-amber-800 text-sm">
                    <div class="font-semibold">Catatan Mentor</div>
                    <div class="mt-1 whitespace-pre-line">{{ $pekan->catatan_mentor }}</div>
                </div>
            @endif
        </div>

        {{-- Tabel Jurnal --}}
        <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden">
            <div class="px-4 py-3 border-b border-gray-200 flex items-center justify-between">
                <div class="font-semibold text-gray-900">Jurnal Harian</div>
                <div class="text-sm text-gray-600">
                    Total Mingguan: <span class="font-semibold">{{ $jamTotal }} Jam {{ $menTotal }} Menit</span>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-gray-600">
                        <tr class="text-left">
                            <th class="px-4 py-3 w-44">Hari/Tanggal</th>
                            <th class="px-4 py-3 w-32">Jam Datang</th>
                            <th class="px-4 py-3 w-32">Jam Pulang</th>
                            <th class="px-4 py-3 w-36">Jumlah Jam</th>
                            <th class="px-4 py-3">Kegiatan</th>
                            <th class="px-4 py-3 w-28">Simpan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($pekan->harian as $h)
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

                                <td class="px-4 py-3">
                                    <form method="POST"
                                        action="{{ route('mahasiswa.jurnal.harian.update', $h->id_jurnal_harian) }}"
                                        class="space-y-2">
                                        @csrf
                                        @method('PUT')

                                        <input type="time" name="jam_datang"
                                            value="{{ old('jam_datang', $h->jam_datang ? \Carbon\Carbon::parse($h->jam_datang)->format('H:i') : '') }}"
                                            class="w-full px-3 py-2 rounded-lg border border-gray-200"
                                            {{ $editable ? '' : 'disabled' }}>
                                </td>

                                <td class="px-4 py-3">
                                    <input type="time" name="jam_pulang"
                                        value="{{ old('jam_pulang', $h->jam_pulang ? \Carbon\Carbon::parse($h->jam_pulang)->format('H:i') : '') }}"
                                        class="w-full px-3 py-2 rounded-lg border border-gray-200"
                                        {{ $editable ? '' : 'disabled' }}>
                                </td>

                                <td class="px-4 py-3 text-gray-700">
                                    <div class="mt-2">{{ $jam }}j {{ $men }}m</div>
                                </td>

                                <td class="px-4 py-3">
                                    <textarea name="kegiatan" rows="3" class="w-full px-3 py-2 rounded-lg border border-gray-200"
                                        placeholder="Isi kegiatan..." {{ $editable ? '' : 'disabled' }}>{{ old('kegiatan', $h->kegiatan) }}</textarea>
                                </td>

                                <td class="px-4 py-3">
                                    <button type="submit"
                                        class="w-full px-3 py-2 rounded-lg border border-gray-200 hover:bg-gray-50 text-xs"
                                        {{ $editable ? '' : 'disabled' }}>
                                        Simpan
                                    </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-10 text-center text-gray-500">
                                    Belum ada baris jurnal harian. Buat pekan dengan tanggal mulai agar otomatis dibuat.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="px-4 py-3 border-t border-gray-200 text-sm text-gray-600">
                <span class="font-semibold">Catatan:</span> Jumlah jam dihitung otomatis dari jam datang & jam pulang.
            </div>
        </div>

        <div>
            <a href="{{ route('mahasiswa.jurnal') }}"
                class="inline-flex items-center px-4 py-2 rounded-lg border border-gray-200 hover:bg-gray-50 text-sm">
                ← Kembali
            </a>
        </div>
    </div>
@endsection
