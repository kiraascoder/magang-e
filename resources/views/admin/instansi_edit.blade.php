@extends('layouts.app')

@section('title', 'Edit Instansi')
@section('page_title', 'Edit Instansi')
@section('page_desc', 'Perbarui data instansi.')

@section('content')
    @if ($errors->any())
        <div class="mb-4 p-3 rounded-lg border border-red-200 bg-red-50 text-red-700 text-sm">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.instansi.update', $instansi->id_instansi) }}" class="space-y-4">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="sm:col-span-2">
                <label class="text-sm text-gray-600">Nama Instansi</label>
                <input name="nama_instansi" value="{{ old('nama_instansi', $instansi->nama_instansi) }}"
                    class="mt-1 w-full px-3 py-2 rounded-lg border border-gray-200" />
            </div>

            <div class="sm:col-span-2">
                <label class="text-sm text-gray-600">Alamat</label>
                <textarea name="alamat" rows="3" class="mt-1 w-full px-3 py-2 rounded-lg border border-gray-200">{{ old('alamat', $instansi->alamat) }}</textarea>
            </div>

            <div>
                <label class="text-sm text-gray-600">Kontak (Telp/Email/PIC)</label>
                <input name="kontak" value="{{ old('kontak', $instansi->kontak) }}"
                    class="mt-1 w-full px-3 py-2 rounded-lg border border-gray-200" />
            </div>

            <div>
                <label class="text-sm text-gray-600">Status</label>
                <select name="status" class="mt-1 w-full px-3 py-2 rounded-lg border border-gray-200">
                    <option value="aktif" {{ old('status', $instansi->status) == 'aktif' ? 'selected' : '' }}>Aktif
                    </option>
                    <option value="nonaktif" {{ old('status', $instansi->status) == 'nonaktif' ? 'selected' : '' }}>Nonaktif
                    </option>
                </select>
            </div>
        </div>

        <div class="flex gap-2">
            <a href="{{ route('admin.instansi') }}"
                class="px-4 py-2 rounded-lg border border-gray-200 hover:bg-gray-50">Kembali</a>
            <button class="px-4 py-2 rounded-lg bg-gray-900 text-white hover:bg-gray-800">
                Update
            </button>
        </div>
    </form>
@endsection
