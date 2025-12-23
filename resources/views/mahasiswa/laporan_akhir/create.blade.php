@extends('layouts.app')

@section('title', 'Upload Laporan Akhir')
@section('page_title', 'Upload Laporan Akhir')
@section('page_desc', 'Upload file PDF/DOC/DOCX.')

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

        <div class="bg-white border border-gray-200 rounded-2xl p-5">
            <form method="POST" action="{{ route('mahasiswa.laporan_akhir.store') }}" enctype="multipart/form-data"
                class="space-y-3">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Judul (opsional)</label>
                    <input type="text" name="judul" value="{{ old('judul') }}"
                        class="w-full px-3 py-2 rounded-lg border border-gray-200">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">File Laporan</label>
                    <input type="file" name="file" accept=".pdf,.doc,.docx"
                        class="w-full px-3 py-2 rounded-lg border border-gray-200 bg-white">
                    <div class="text-xs text-gray-500 mt-1">Maks 10MB • PDF/DOC/DOCX</div>
                </div>

                <div class="flex gap-2">
                    <a href="{{ route('mahasiswa.laporan_akhir') }}"
                        class="px-4 py-2 rounded-lg border border-gray-200 hover:bg-gray-50 text-sm">
                        Kembali
                    </a>
                    <button class="px-4 py-2 rounded-lg bg-gray-900 text-white hover:bg-gray-800 text-sm">
                        Upload
                    </button>
                </div>
            </form>
        </div>

    </div>
@endsection
