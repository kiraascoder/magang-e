@extends('layouts.app')

@section('title', 'Buat Pekan Jurnal')
@section('page_title', 'Buat Pekan Jurnal')
@section('page_desc', 'Buat pekan jurnal baru untuk penempatan aktif.')

@section('content')
    <div class="max-w-xl space-y-4">

        @if ($errors->any())
            <div class="p-3 rounded-lg border border-red-200 bg-red-50 text-red-700 text-sm">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white border border-gray-200 rounded-2xl p-5 space-y-3">
            <div class="text-sm text-gray-600">
                Penempatan: <span class="font-semibold text-gray-900">#{{ $penempatan->id_penempatan }}</span>
            </div>

            <form method="POST" action="{{ route('mahasiswa.jurnal.store') }}" class="space-y-3">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Pekan ke-</label>
                    <input type="number" name="pekan_ke" min="1" value="{{ old('pekan_ke', 1) }}"
                        class="w-full px-3 py-2 rounded-lg border border-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-200">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai (Senin)</label>
                    <input type="date" name="tanggal_mulai" value="{{ old('tanggal_mulai') }}"
                        class="w-full px-3 py-2 rounded-lg border border-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-200">
                    <div class="text-xs text-gray-500 mt-1">
                        Jika diisi, sistem otomatis buat 6 hari (Senin–Sabtu).
                    </div>
                </div>

                <div class="flex gap-2">
                    <a href="{{ route('mahasiswa.jurnal') }}"
                        class="px-4 py-2 rounded-lg border border-gray-200 hover:bg-gray-50 text-sm">
                        Kembali
                    </a>
                    <button type="submit" class="px-4 py-2 rounded-lg bg-gray-900 text-white hover:bg-gray-800 text-sm">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
