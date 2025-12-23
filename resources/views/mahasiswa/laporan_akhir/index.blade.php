@extends('layouts.app')

@section('title', 'Laporan Akhir')
@section('page_title', 'Laporan Akhir')
@section('page_desc', 'Upload dan kirim laporan akhir magang.')

@section('content')
    <div class="space-y-4">

        @if (session('success'))
            <div class="p-3 rounded-lg border border-emerald-200 bg-emerald-50 text-emerald-700 text-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex items-center justify-between">
            <div class="text-sm text-gray-600">
                Penempatan: <span class="font-semibold text-gray-900">#{{ $penempatan->id_penempatan }}</span>
            </div>

            @if (!$laporan)
                <a href="{{ route('mahasiswa.laporan_akhir.create') }}"
                    class="inline-flex items-center gap-2 px-3 py-2 rounded-lg bg-gray-900 text-white hover:bg-gray-800 text-sm">
                    + Upload Laporan
                </a>
            @endif
        </div>

        <div class="bg-white border border-gray-200 rounded-2xl p-5">
            @if (!$laporan)
                <div class="text-gray-600 text-sm">Belum ada laporan akhir. Silakan upload.</div>
            @else
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <div>
                        <div class="font-semibold text-gray-900">{{ $laporan->judul ?? 'Laporan Akhir Magang' }}</div>
                        <div class="text-xs text-gray-500">
                            Status:
                            <span
                                class="inline-flex px-2 py-1 rounded-md text-xs bg-gray-100 border border-gray-200 capitalize">
                                {{ $laporan->status }}
                            </span>
                            • File: {{ $laporan->original_name }}
                        </div>

                        @if ($laporan->catatan_mentor)
                            <div class="mt-2 text-sm text-amber-700 bg-amber-50 border border-amber-200 rounded-lg p-3">
                                Catatan mentor: {{ $laporan->catatan_mentor }}
                            </div>
                        @endif
                    </div>

                    <div class="flex gap-2">
                        <a href="{{ asset('storage/' . $laporan->file_path) }}" target="_blank"
                            class="px-3 py-2 rounded-lg border border-gray-200 hover:bg-gray-50 text-sm">
                            Lihat File
                        </a>

                        @if ($laporan->status === 'draft')
                            <form method="POST"
                                action="{{ route('mahasiswa.laporan_akhir.submit', $laporan->id_laporan_akhir) }}">
                                @csrf @method('PATCH')
                                <button class="px-3 py-2 rounded-lg bg-gray-900 text-white hover:bg-gray-800 text-sm">
                                    Kirim ke Mentor
                                </button>
                            </form>
                        @endif

                        @if ($laporan->status !== 'disetujui')
                            <form method="POST"
                                action="{{ route('mahasiswa.laporan_akhir.destroy', $laporan->id_laporan_akhir) }}"
                                onsubmit="return confirm('Hapus laporan akhir?')">
                                @csrf @method('DELETE')
                                <button
                                    class="px-3 py-2 rounded-lg border border-red-200 text-red-600 hover:bg-red-50 text-sm">
                                    Hapus
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @endif
        </div>

    </div>
@endsection
