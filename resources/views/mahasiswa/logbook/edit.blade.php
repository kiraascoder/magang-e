@extends('layouts.app')

@section('title', 'Edit Logbook')
@section('page_title', 'Edit Logbook')
@section('page_desc', 'Edit logbook (hanya draft/ditolak).')

@section('content')
    <form method="POST" action="{{ route('mahasiswa.logbook.update', $logbook->id_logbook) }}" enctype="multipart/form-data"
        class="bg-white border border-gray-200 rounded-2xl p-4 space-y-4">
        @csrf
        @method('PUT')

        @if ($errors->any())
            <div class="p-3 rounded-lg border border-red-200 bg-red-50 text-red-700 text-sm">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if ($logbook->catatan_mentor)
            <div class="p-3 rounded-lg border border-amber-200 bg-amber-50 text-amber-800 text-sm">
                <div class="font-semibold">Catatan Mentor</div>
                <div class="mt-1">{{ $logbook->catatan_mentor }}</div>
            </div>
        @endif

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="text-sm font-semibold">Tanggal</label>
                <input type="date" name="tanggal" value="{{ old('tanggal', $logbook->tanggal?->toDateString()) }}"
                    class="mt-1 w-full px-3 py-2 rounded-lg border border-gray-200">
            </div>

            <div>
                <label class="text-sm font-semibold">Status</label>
                <input type="text" value="{{ $logbook->status }}" disabled
                    class="mt-1 w-full px-3 py-2 rounded-lg border border-gray-200 bg-gray-50">
            </div>
        </div>

        <div>
            <label class="text-sm font-semibold">Kegiatan</label>
            <textarea name="kegiatan" rows="5" class="mt-1 w-full px-3 py-2 rounded-lg border border-gray-200">{{ old('kegiatan', $logbook->kegiatan) }}</textarea>
        </div>

        <div class="space-y-2">
            <label class="text-sm font-semibold">Dokumentasi</label>

            @if ($logbook->dokumentasi)
                <div class="text-sm">
                    File sekarang:
                    <a class="text-blue-700 hover:underline" target="_blank"
                        href="{{ asset('storage/' . $logbook->dokumentasi) }}">Lihat</a>
                </div>

                <label class="inline-flex items-center gap-2 text-sm">
                    <input type="checkbox" name="hapus_dokumentasi" value="1">
                    Hapus dokumentasi
                </label>
            @else
                <div class="text-xs text-gray-500">Belum ada dokumentasi</div>
            @endif

            <input type="file" name="dokumentasi" class="w-full text-sm">
            <div class="text-xs text-gray-500">Upload baru akan mengganti file lama</div>
        </div>

        <div class="flex gap-2">
            <a href="{{ route('mahasiswa.logbook') }}"
                class="px-4 py-2 rounded-lg border border-gray-200 hover:bg-gray-50 text-sm">Kembali</a>
            <button class="px-4 py-2 rounded-lg bg-gray-900 text-white hover:bg-gray-800 text-sm">Update</button>
        </div>
    </form>
@endsection
