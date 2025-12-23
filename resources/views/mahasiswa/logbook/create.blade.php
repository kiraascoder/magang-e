@extends('layouts.app')

@section('title', 'Tambah Logbook')
@section('page_title', 'Tambah Logbook')
@section('page_desc', 'Isi aktivitas harian magang.')

@section('content')
    <form method="POST" action="{{ route('mahasiswa.logbook.store') }}" enctype="multipart/form-data"
        class="bg-white border border-gray-200 rounded-2xl p-4 space-y-4">
        @csrf

        @if ($errors->any())
            <div class="p-3 rounded-lg border border-red-200 bg-red-50 text-red-700 text-sm">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="text-sm font-semibold">Tanggal</label>
                <input type="date" name="tanggal" value="{{ old('tanggal', now()->toDateString()) }}"
                    class="mt-1 w-full px-3 py-2 rounded-lg border border-gray-200">
            </div>

            <div class="text-sm text-gray-600">
                <div class="font-semibold text-gray-900">Penempatan</div>
                <div class="mt-1">ID Penempatan: <span class="font-medium">{{ $penempatan->id_penempatan }}</span></div>
                <div class="text-xs text-gray-500">*Dipilih otomatis dari penempatan aktif/draft kamu</div>
            </div>
        </div>

        <div>
            <label class="text-sm font-semibold">Kegiatan</label>
            <textarea name="kegiatan" rows="5" class="mt-1 w-full px-3 py-2 rounded-lg border border-gray-200"
                placeholder="Contoh: Membuat halaman login, perbaiki bug routing...">{{ old('kegiatan') }}</textarea>
        </div>

        <div>
            <label class="text-sm font-semibold">Dokumentasi (jpg/png/pdf, max 2MB)</label>
            <input type="file" name="dokumentasi" class="mt-1 w-full text-sm">
        </div>

        <div class="flex gap-2">
            <a href="{{ route('mahasiswa.logbook') }}"
                class="px-4 py-2 rounded-lg border border-gray-200 hover:bg-gray-50 text-sm">Kembali</a>
            <button class="px-4 py-2 rounded-lg bg-gray-900 text-white hover:bg-gray-800 text-sm">Simpan</button>
        </div>
    </form>
@endsection
