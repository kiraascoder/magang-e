@extends('layouts.app')

@section('title', 'Edit Penempatan')
@section('page_title', 'Edit Penempatan')
@section('page_desc', 'Perbarui data penempatan.')

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

    <form method="POST" action="{{ route('admin.penempatan.update', $penempatan->id_penempatan) }}" class="space-y-4">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="text-sm text-gray-600">Mahasiswa</label>
                <select name="id_mhs" class="mt-1 w-full px-3 py-2 rounded-lg border border-gray-200">
                    @foreach ($mahasiswas as $m)
                        <option value="{{ $m->id }}"
                            {{ old('id_mhs', $penempatan->id_mhs) == $m->id ? 'selected' : '' }}>
                            {{ $m->name }} ({{ $m->nim }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="text-sm text-gray-600">Dosen Mentor</label>
                <select name="id_dosen_mentor" class="mt-1 w-full px-3 py-2 rounded-lg border border-gray-200">
                    <option value="">-- belum ditentukan --</option>
                    @foreach ($dosens as $d)
                        <option value="{{ $d->id }}"
                            {{ old('id_dosen_mentor', $penempatan->id_dosen_mentor) == $d->id ? 'selected' : '' }}>
                            {{ $d->name }} ({{ $d->nbm }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="text-sm text-gray-600">Periode</label>
                <select name="id_periode" class="mt-1 w-full px-3 py-2 rounded-lg border border-gray-200">
                    @foreach ($periodes as $p)
                        <option value="{{ $p->id_periode }}"
                            {{ old('id_periode', $penempatan->id_periode) == $p->id_periode ? 'selected' : '' }}>
                            {{ $p->nama_periode }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="text-sm text-gray-600">Instansi</label>
                <select name="id_instansi" class="mt-1 w-full px-3 py-2 rounded-lg border border-gray-200">
                    <option value="">-- belum ditentukan --</option>
                    @foreach ($instansis as $i)
                        <option value="{{ $i->id_instansi }}"
                            {{ old('id_instansi', $penempatan->id_instansi) == $i->id_instansi ? 'selected' : '' }}>
                            {{ $i->nama_instansi }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="text-sm text-gray-600">Divisi</label>
                <input name="divisi" value="{{ old('divisi', $penempatan->divisi) }}"
                    class="mt-1 w-full px-3 py-2 rounded-lg border border-gray-200">
            </div>

            <div>
                <label class="text-sm text-gray-600">Posisi</label>
                <input name="posisi" value="{{ old('posisi', $penempatan->posisi) }}"
                    class="mt-1 w-full px-3 py-2 rounded-lg border border-gray-200">
            </div>

            <div class="sm:col-span-2">
                <label class="text-sm text-gray-600">Lokasi</label>
                <input name="lokasi" value="{{ old('lokasi', $penempatan->lokasi) }}"
                    class="mt-1 w-full px-3 py-2 rounded-lg border border-gray-200">
            </div>

            <div>
                <label class="text-sm text-gray-600">Tanggal Mulai</label>
                <input type="date" name="tgl_mulai"
                    value="{{ old('tgl_mulai', optional($penempatan->tgl_mulai)->format('Y-m-d')) }}"
                    class="mt-1 w-full px-3 py-2 rounded-lg border border-gray-200">
            </div>

            <div>
                <label class="text-sm text-gray-600">Tanggal Selesai</label>
                <input type="date" name="tgl_selesai"
                    value="{{ old('tgl_selesai', optional($penempatan->tgl_selesai)->format('Y-m-d')) }}"
                    class="mt-1 w-full px-3 py-2 rounded-lg border border-gray-200">
            </div>

            <div class="sm:col-span-2">
                <label class="text-sm text-gray-600">Status</label>
                <select name="status" class="mt-1 w-full px-3 py-2 rounded-lg border border-gray-200">
                    @foreach (['draft' => 'Draft', 'aktif' => 'Aktif', 'selesai' => 'Selesai', 'batal' => 'Batal'] as $k => $v)
                        <option value="{{ $k }}"
                            {{ old('status', $penempatan->status) == $k ? 'selected' : '' }}>
                            {{ $v }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="flex gap-2">
            <a href="{{ route('admin.penempatan') }}"
                class="px-4 py-2 rounded-lg border border-gray-200 hover:bg-gray-50">Kembali</a>
            <button class="px-4 py-2 rounded-lg bg-gray-900 text-white hover:bg-gray-800">Update</button>
        </div>
    </form>
@endsection
