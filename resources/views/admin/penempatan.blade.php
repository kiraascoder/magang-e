@extends('layouts.app')

@section('title', 'Penempatan')
@section('page_title', 'Penempatan')
@section('page_desc', 'Kelola penempatan mahasiswa: pilih mentor, instansi, periode, dan status.')

@section('content')
    <div class="space-y-4">

        {{-- TOP ACTIONS --}}
        <div class="flex flex-col sm:flex-row gap-3 sm:items-center sm:justify-between">
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.penempatan.create') }}"
                    class="inline-flex items-center gap-2 px-3 py-2 rounded-lg bg-gray-900 text-white hover:bg-gray-800 text-sm">
                    <span class="text-base">+</span>
                    <span>Tambah Penempatan</span>
                </a>                
            </div>

            {{-- Search + Filter --}}
            <form method="GET" action="{{ route('admin.penempatan') }}"
                class="flex flex-col sm:flex-row gap-2 w-full sm:w-auto">
                <input type="text" name="q" value="{{ request('q') }}"
                    placeholder="Cari mahasiswa / mentor / instansi..."
                    class="w-full sm:w-72 px-3 py-2 rounded-lg border border-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-200">

                <select name="status"
                    class="w-full sm:w-40 px-3 py-2 rounded-lg border border-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-200">
                    <option value="">Semua Status</option>
                    <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    <option value="batal" {{ request('status') == 'batal' ? 'selected' : '' }}>Batal</option>
                </select>

                <select name="periode"
                    class="w-full sm:w-56 px-3 py-2 rounded-lg border border-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-200">
                    <option value="">Semua Periode</option>
                    @foreach ($periodes as $p)
                        <option value="{{ $p->id_periode }}" {{ request('periode') == $p->id_periode ? 'selected' : '' }}>
                            {{ $p->nama_periode }}
                        </option>
                    @endforeach
                </select>

                <button type="submit"
                    class="px-3 py-2 rounded-lg bg-white border border-gray-200 hover:bg-gray-50 text-sm">
                    Terapkan
                </button>
            </form>
        </div>

        {{-- FLASH / ERROR --}}
        @if ($errors->any())
            <div class="p-3 rounded-lg border border-red-200 bg-red-50 text-red-700 text-sm">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- STATS (minimal: dari data yang sedang tampil/paginate) --}}
        @php
            $total = $items->total();
            $draft = $items->getCollection()->where('status', 'draft')->count();
            $aktif = $items->getCollection()->where('status', 'aktif')->count();
            $selesai = $items->getCollection()->where('status', 'selesai')->count();
        @endphp

        <div class="grid grid-cols-1 sm:grid-cols-4 gap-3">
            <div class="p-4 rounded-2xl border border-gray-200 bg-white">
                <div class="text-sm text-gray-500">Total Penempatan</div>
                <div class="mt-1 text-2xl font-semibold">{{ $total }}</div>
                <div class="mt-2 text-xs text-gray-500">Total hasil filter</div>
            </div>
            <div class="p-4 rounded-2xl border border-gray-200 bg-white">
                <div class="text-sm text-gray-500">Draft</div>
                <div class="mt-1 text-2xl font-semibold">{{ $draft }}</div>
                <div class="mt-2 text-xs text-gray-500">Yang tampil di halaman ini</div>
            </div>
            <div class="p-4 rounded-2xl border border-gray-200 bg-white">
                <div class="text-sm text-gray-500">Aktif</div>
                <div class="mt-1 text-2xl font-semibold">{{ $aktif }}</div>
                <div class="mt-2 text-xs text-gray-500">Yang tampil di halaman ini</div>
            </div>
            <div class="p-4 rounded-2xl border border-gray-200 bg-white">
                <div class="text-sm text-gray-500">Selesai</div>
                <div class="mt-1 text-2xl font-semibold">{{ $selesai }}</div>
                <div class="mt-2 text-xs text-gray-500">Yang tampil di halaman ini</div>
            </div>
        </div>

        {{-- TABLE --}}
        <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden">
            <div class="px-4 py-3 border-b border-gray-200 flex items-center justify-between">
                <div class="font-semibold text-gray-900">Daftar Penempatan</div>
                <div class="text-xs text-gray-500">Total: {{ $items->total() }}</div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-gray-600">
                        <tr class="text-left">
                            <th class="px-4 py-3">Mahasiswa</th>
                            <th class="px-4 py-3">Mentor</th>
                            <th class="px-4 py-3">Instansi</th>
                            <th class="px-4 py-3">Periode</th>
                            <th class="px-4 py-3">Mulai</th>
                            <th class="px-4 py-3">Selesai</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3 w-44">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">
                        @forelse($items as $x)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 font-medium text-gray-900">
                                    {{ $x->mahasiswa?->name ?? '-' }}
                                    <div class="text-xs text-gray-500">
                                        {{ $x->mahasiswa?->nim ?? '-' }}
                                    </div>
                                </td>

                                <td class="px-4 py-3 text-gray-700">
                                    {{ $x->mentor?->name ?? '-' }}
                                    <div class="text-xs text-gray-500">
                                        {{ $x->mentor?->nbm ?? '' }}
                                    </div>
                                </td>

                                <td class="px-4 py-3 text-gray-700">
                                    {{ $x->instansi?->nama_instansi ?? '-' }}
                                </td>

                                <td class="px-4 py-3 text-gray-700">
                                    {{ $x->periode?->nama_periode ?? '-' }}
                                </td>

                                <td class="px-4 py-3 text-gray-700">
                                    {{ $x->tgl_mulai ? \Carbon\Carbon::parse($x->tgl_mulai)->format('d-m-Y') : '-' }}
                                </td>

                                <td class="px-4 py-3 text-gray-700">
                                    {{ $x->tgl_selesai ? \Carbon\Carbon::parse($x->tgl_selesai)->format('d-m-Y') : '-' }}
                                </td>

                                <td class="px-4 py-3">
                                    <span
                                        class="inline-flex px-2 py-1 rounded-md text-xs bg-gray-100 border border-gray-200 capitalize">
                                        {{ $x->status }}
                                    </span>
                                </td>

                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-2">
                                        {{-- Detail belum dibuat routenya --}}
                                        <button type="button" disabled
                                            class="px-3 py-1.5 rounded-lg border border-gray-200 text-xs opacity-60 cursor-not-allowed">
                                            Detail
                                        </button>

                                        <a href="{{ route('admin.penempatan.edit', $x->id_penempatan) }}"
                                            class="px-3 py-1.5 rounded-lg border border-gray-200 hover:bg-gray-50 text-xs">
                                            Edit
                                        </a>

                                        <form method="POST"
                                            action="{{ route('admin.penempatan.destroy', $x->id_penempatan) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('Yakin hapus penempatan ini?')"
                                                class="px-3 py-1.5 rounded-lg border border-red-200 text-red-600 hover:bg-red-50 text-xs">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-4 py-10 text-center text-gray-500">
                                    Belum ada data penempatan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- PAGINATION --}}
            <div class="px-4 py-3 border-t border-gray-200 flex items-center justify-between text-sm text-gray-600">
                <span>
                    Menampilkan {{ $items->firstItem() ?? 0 }} - {{ $items->lastItem() ?? 0 }} dari {{ $items->total() }}
                </span>
                <div>{{ $items->links() }}</div>
            </div>
        </div>

    </div>
@endsection
