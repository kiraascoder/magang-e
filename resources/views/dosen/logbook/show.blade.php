@extends('layouts.app')

@section('title', 'Detail Logbook')
@section('page_title', 'Detail Logbook')
@section('page_desc', 'Review logbook dan berikan catatan.')

@section('content')
    <div class="space-y-4">

        @if (session('success'))
            <div class="p-3 rounded-lg border border-emerald-200 bg-emerald-50 text-emerald-700 text-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white border border-gray-200 rounded-2xl p-4 space-y-3">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                <div>
                    <div class="text-gray-500">Mahasiswa</div>
                    <div class="font-semibold text-gray-900">{{ $logbook->mahasiswa?->name }}</div>
                    <div class="text-xs text-gray-500">{{ $logbook->mahasiswa?->nim }}</div>
                </div>
                <div>
                    <div class="text-gray-500">Tanggal</div>
                    <div class="font-semibold text-gray-900">{{ $logbook->tanggal?->format('d-m-Y') }}</div>
                    <div class="text-xs text-gray-500 capitalize">Status: {{ $logbook->status }}</div>
                </div>
                <div>
                    <div class="text-gray-500">Instansi</div>
                    <div class="font-semibold text-gray-900">{{ $logbook->penempatan?->instansi?->nama_instansi ?? '-' }}
                    </div>
                </div>
                <div>
                    <div class="text-gray-500">Periode</div>
                    <div class="font-semibold text-gray-900">{{ $logbook->penempatan?->periode?->nama_periode ?? '-' }}
                    </div>
                </div>
            </div>

            <div class="pt-2">
                <div class="text-sm font-semibold text-gray-900">Kegiatan</div>
                <div class="mt-1 text-sm text-gray-700 whitespace-pre-line">{{ $logbook->kegiatan }}</div>
            </div>

            <div class="pt-2">
                <div class="text-sm font-semibold text-gray-900">Dokumentasi</div>
                <div class="mt-1 text-sm">
                    @if ($logbook->dokumentasi)
                        <a class="text-blue-700 hover:underline" target="_blank"
                            href="{{ asset('storage/' . $logbook->dokumentasi) }}">Buka file</a>
                    @else
                        <span class="text-gray-500">-</span>
                    @endif
                </div>
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-2xl p-4 space-y-3">
            <div class="text-sm font-semibold text-gray-900">Catatan Mentor</div>

            @if ($logbook->status === 'terkirim')
                <form method="POST" action="{{ route('dosen.logbook.approve', $logbook->id_logbook) }}" class="space-y-3">
                    @csrf
                    @method('PATCH')

                    <textarea name="catatan_mentor" rows="3" class="w-full px-3 py-2 rounded-lg border border-gray-200"
                        placeholder="Catatan (opsional)">{{ old('catatan_mentor', $logbook->catatan_mentor) }}</textarea>

                    <div class="flex flex-wrap gap-2">
                        <button class="px-4 py-2 rounded-lg bg-emerald-600 text-white hover:bg-emerald-700 text-sm">
                            Setujui
                        </button>
                        <a href="{{ route('dosen.logbook') }}"
                            class="px-4 py-2 rounded-lg border border-gray-200 hover:bg-gray-50 text-sm">
                            Kembali
                        </a>
                    </div>
                </form>

                <form method="POST" action="{{ route('dosen.logbook.reject', $logbook->id_logbook) }}"
                    class="mt-4 space-y-3">
                    @csrf
                    @method('PATCH')

                    <textarea name="catatan_mentor" rows="3" required class="w-full px-3 py-2 rounded-lg border border-gray-200"
                        placeholder="Alasan penolakan (wajib)">{{ old('catatan_mentor') }}</textarea>

                    <button class="px-4 py-2 rounded-lg border border-red-200 text-red-600 hover:bg-red-50 text-sm">
                        Tolak
                    </button>
                </form>
            @else
                <div class="text-sm text-gray-700 whitespace-pre-line">
                    {{ $logbook->catatan_mentor ?? 'Belum ada catatan.' }}
                </div>
                <a href="{{ route('dosen.logbook') }}"
                    class="inline-flex mt-3 px-4 py-2 rounded-lg border border-gray-200 hover:bg-gray-50 text-sm">
                    Kembali
                </a>
            @endif
        </div>

    </div>
@endsection
