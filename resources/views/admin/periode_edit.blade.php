@extends('layouts.app')

@section('title', 'Edit Periode')
@section('page_title', 'Edit Periode')
@section('page_desc', 'Perbarui periode magang.')

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

    <form method="POST" action="{{ route('admin.periode.update', $periode->id_periode) }}" class="space-y-4">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="sm:col-span-2">
                <label class="text-sm text-gray-600">Nama Periode</label>
                <input name="nama_periode" value="{{ old('nama_periode', $periode->nama_periode) }}"
                    class="mt-1 w-full px-3 py-2 rounded-lg border border-gray-200" />
            </div>

            <div>
                <label class="text-sm text-gray-600">Tanggal Mulai</label>
                <input type="date" name="tgl_mulai"
                    value="{{ old('tgl_mulai', optional($periode->tgl_mulai)->format('Y-m-d')) }}"
                    class="mt-1 w-full px-3 py-2 rounded-lg border border-gray-200" />
            </div>

            <div>
                <label class="text-sm text-gray-600">Tanggal Selesai</label>
                <input type="date" name="tgl_selesai"
                    value="{{ old('tgl_selesai', optional($periode->tgl_selesai)->format('Y-m-d')) }}"
                    class="mt-1 w-full px-3 py-2 rounded-lg border border-gray-200" />
            </div>

            <div>
                <label class="text-sm text-gray-600">Status</label>
                <select name="status" class="mt-1 w-full px-3 py-2 rounded-lg border border-gray-200">
                    <option value="aktif" {{ old('status', $periode->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="selesai" {{ old('status', $periode->status) == 'selesai' ? 'selected' : '' }}>Selesai
                    </option>
                    <option value="nonaktif" {{ old('status', $periode->status) == 'nonaktif' ? 'selected' : '' }}>Nonaktif
                    </option>
                </select>
            </div>

            <div class="sm:col-span-2">
                <label class="text-sm text-gray-600">Keterangan (opsional)</label>
                <textarea name="keterangan" rows="3" class="mt-1 w-full px-3 py-2 rounded-lg border border-gray-200">{{ old('keterangan', $periode->keterangan) }}</textarea>
            </div>
        </div>

        <div class="flex gap-2">
            <a href="{{ route('admin.periode') }}"
                class="px-4 py-2 rounded-lg border border-gray-200 hover:bg-gray-50">Kembali</a>
            <button class="px-4 py-2 rounded-lg bg-gray-900 text-white hover:bg-gray-800">
                Update
            </button>
        </div>
    </form>
@endsection
