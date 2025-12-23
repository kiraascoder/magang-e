@extends('layouts.app')

@section('title', 'Periode')
@section('page_title', 'Periode')
@section('page_desc', 'Kelola periode magang (tanggal mulai–selesai, status, dan keterangan).')

@section('content')
    <div class="space-y-4">

        <div class="flex flex-col sm:flex-row gap-3 sm:items-center sm:justify-between">
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.periode.create') }}"
                    class="inline-flex items-center gap-2 px-3 py-2 rounded-lg bg-gray-900 text-white hover:bg-gray-800 text-sm">
                    <span class="text-base">+</span>
                    <span>Tambah Periode</span>
                </a>

            </div>
            
            <form method="GET" action="{{ route('admin.periode') }}"
                class="flex flex-col sm:flex-row gap-2 w-full sm:w-auto">
                <input type="text" name="q" value="{{ request('q') }}"
                    placeholder="Cari nama periode / tahun / keterangan..."
                    class="w-full sm:w-72 px-3 py-2 rounded-lg border border-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-200">

                <select name="status"
                    class="w-full sm:w-44 px-3 py-2 rounded-lg border border-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-200">
                    <option value="">Semua Status</option>
                    <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    <option value="nonaktif" {{ request('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                </select>

                <button type="submit"
                    class="px-3 py-2 rounded-lg bg-white border border-gray-200 hover:bg-gray-50 text-sm">
                    Terapkan
                </button>
            </form>
        </div>

        {{-- STATS --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
            <div class="p-4 rounded-2xl border border-gray-200 bg-white">
                <div class="text-sm text-gray-500">Total Periode</div>
                <div class="mt-1 text-2xl font-semibold">{{ $countAll }}</div>
                <div class="mt-2 text-xs text-gray-500">Semua periode</div>
            </div>

            <div class="p-4 rounded-2xl border border-gray-200 bg-white">
                <div class="text-sm text-gray-500">Periode Aktif</div>
                <div class="mt-1 text-2xl font-semibold">{{ $countAktif }}</div>
                <div class="mt-2 text-xs text-gray-500">Sedang berjalan</div>
            </div>

            <div class="p-4 rounded-2xl border border-gray-200 bg-white">
                <div class="text-sm text-gray-500">Periode Selesai</div>
                <div class="mt-1 text-2xl font-semibold">{{ $countSelesai }}</div>
                <div class="mt-2 text-xs text-gray-500">Sudah berakhir</div>
            </div>
        </div>

        {{-- TABLE --}}
        <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden">
            <div class="px-4 py-3 border-b border-gray-200 flex items-center justify-between">
                <div class="font-semibold text-gray-900">Daftar Periode</div>
                <div class="text-xs text-gray-500">*Data masih dummy</div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-gray-600">
                        <tr class="text-left">
                            <th class="px-4 py-3">Nama Periode</th>
                            <th class="px-4 py-3">Mulai</th>
                            <th class="px-4 py-3">Selesai</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3">Keterangan</th>
                            <th class="px-4 py-3 w-40">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">
                        @forelse($periodes as $p)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 font-medium text-gray-900">{{ $p->nama_periode }}</td>
                                <td class="px-4 py-3 text-gray-700">{{ optional($p->tgl_mulai)->format('d-m-Y') }}</td>
                                <td class="px-4 py-3 text-gray-700">{{ optional($p->tgl_selesai)->format('d-m-Y') }}</td>
                                <td class="px-4 py-3">
                                    <span
                                        class="inline-flex px-2 py-1 rounded-md text-xs bg-gray-100 border border-gray-200 capitalize">
                                        {{ $p->status }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-gray-700">{{ $p->keterangan ?? '-' }}</td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('admin.periode.edit', $p->id_periode) }}"
                                            class="px-3 py-1.5 rounded-lg border border-gray-200 hover:bg-gray-50 text-xs">
                                            Edit
                                        </a>
                                        <form method="POST" action="{{ route('admin.periode.destroy', $p->id_periode) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('Yakin hapus periode ini?')"
                                                class="px-3 py-1.5 rounded-lg border border-red-200 text-red-600 hover:bg-red-50 text-xs">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-10 text-center text-gray-500">
                                    Belum ada data periode.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

            <div class="px-4 py-3 border-t border-gray-200 flex items-center justify-between text-sm text-gray-600">
                <span>Menampilkan {{ $periodes->firstItem() ?? 0 }} - {{ $periodes->lastItem() ?? 0 }} dari
                    {{ $periodes->total() }}</span>
                <div>{{ $periodes->links() }}</div>
            </div>

        </div>

    </div>
@endsection
