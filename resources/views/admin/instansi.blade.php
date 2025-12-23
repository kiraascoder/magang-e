@extends('layouts.app')

@section('title', 'Instansi')
@section('page_title', 'Instansi')
@section('page_desc', 'Kelola data instansi/mitra penempatan magang.')

@section('content')
    <div class="space-y-4">

        {{-- TOP ACTIONS --}}
        <div class="flex flex-col sm:flex-row gap-3 sm:items-center sm:justify-between">
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.instansi.create') }}"
                    class="inline-flex items-center gap-2 px-3 py-2 rounded-lg bg-gray-900 text-white hover:bg-gray-800 text-sm">
                    <span class="text-base">+</span>
                    <span>Tambah Instansi</span>
                </a>                
            </div>

            {{-- Search --}}
            <form method="GET" action="{{ route('admin.instansi') }}" class="flex gap-2 w-full sm:w-auto">
                <input type="text" name="q" value="{{ request('q') }}"
                    placeholder="Cari nama instansi / alamat / kontak..."
                    class="w-full sm:w-72 px-3 py-2 rounded-lg border border-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-200">

                <button type="submit"
                    class="px-3 py-2 rounded-lg bg-white border border-gray-200 hover:bg-gray-50 text-sm">
                    Cari
                </button>
            </form>
        </div>

        {{-- STATS --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
            <div class="p-4 rounded-2xl border border-gray-200 bg-white">
                <div class="text-sm text-gray-500">Total Instansi</div>
                <div class="mt-1 text-2xl font-semibold">{{ $countAll }}</div>
                <div class="mt-2 text-xs text-gray-500">Mitra terdaftar</div>
            </div>

            <div class="p-4 rounded-2xl border border-gray-200 bg-white">
                <div class="text-sm text-gray-500">Aktif</div>
                <div class="mt-1 text-2xl font-semibold">{{ $countAktif }}</div>
                <div class="mt-2 text-xs text-gray-500">Masih menerima magang</div>
            </div>

            <div class="p-4 rounded-2xl border border-gray-200 bg-white">
                <div class="text-sm text-gray-500">Nonaktif</div>
                <div class="mt-1 text-2xl font-semibold">{{ $countNonAktif }}</div>
                <div class="mt-2 text-xs text-gray-500">Tidak menerima magang</div>
            </div>
        </div>

        {{-- TABLE --}}
        <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden">
            <div class="px-4 py-3 border-b border-gray-200 flex items-center justify-between">
                <div class="font-semibold text-gray-900">Daftar Instansi</div>
                <div class="text-xs text-gray-500">*Data masih dummy</div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-gray-600">
                        <tr class="text-left">
                            <th class="px-4 py-3">Nama Instansi</th>
                            <th class="px-4 py-3">Alamat</th>
                            <th class="px-4 py-3">Kontak</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3 w-40">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">
                        @forelse($instansis as $i)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 font-medium text-gray-900">{{ $i->nama_instansi }}</td>
                                <td class="px-4 py-3 text-gray-700">{{ $i->alamat ?? '-' }}</td>
                                <td class="px-4 py-3 text-gray-700">{{ $i->kontak ?? '-' }}</td>
                                <td class="px-4 py-3">
                                    <span
                                        class="inline-flex px-2 py-1 rounded-md text-xs bg-gray-100 border border-gray-200 capitalize">
                                        {{ $i->status ?? 'aktif' }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('admin.instansi.edit', $i->id_instansi) }}"
                                            class="px-3 py-1.5 rounded-lg border border-gray-200 hover:bg-gray-50 text-xs">
                                            Edit
                                        </a>

                                        <form method="POST"
                                            action="{{ route('admin.instansi.destroy', $i->id_instansi) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('Yakin hapus instansi ini?')"
                                                class="px-3 py-1.5 rounded-lg border border-red-200 text-red-600 hover:bg-red-50 text-xs">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-10 text-center text-gray-500">
                                    Belum ada data instansi.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

            {{-- PAGINATION PLACEHOLDER --}}
            <div class="px-4 py-3 border-t border-gray-200 flex items-center justify-between text-sm text-gray-600">
                <span>Menampilkan {{ $instansis->firstItem() ?? 0 }} - {{ $instansis->lastItem() ?? 0 }} dari
                    {{ $instansis->total() }}</span>
                <div>{{ $instansis->links() }}</div>
            </div>
        </div>

    </div>
@endsection
