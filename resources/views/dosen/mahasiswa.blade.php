@extends('layouts.app')

@section('title', 'Mahasiswa Bimbingan')
@section('page_title', 'Mahasiswa Bimbingan')
@section('page_desc', 'Daftar mahasiswa yang kamu bimbing (berdasarkan penempatan).')

@section('content')
    <div class="space-y-4">
        <form method="GET" action="{{ route('dosen.mahasiswa') }}" class="flex flex-col sm:flex-row gap-2">
            <input type="text" name="q" value="{{ $q ?? '' }}" placeholder="Cari nama / NIM / instansi..."
                class="w-full sm:w-96 px-3 py-2 rounded-lg border border-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-200">
            <button class="px-3 py-2 rounded-lg bg-white border border-gray-200 hover:bg-gray-50 text-sm">Cari</button>
        </form>

        <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden">
            <div class="px-4 py-3 border-b border-gray-200 flex items-center justify-between">
                <div class="font-semibold text-gray-900">Daftar Bimbingan</div>
                <div class="text-xs text-gray-500">Total: {{ $items->total() }}</div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-gray-600">
                        <tr class="text-left">
                            <th class="px-4 py-3">Mahasiswa</th>
                            <th class="px-4 py-3">Instansi</th>
                            <th class="px-4 py-3">Periode</th>
                            <th class="px-4 py-3">Mulai</th>
                            <th class="px-4 py-3">Selesai</th>
                            <th class="px-4 py-3">Status</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">
                        @forelse($items as $x)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 font-medium text-gray-900">
                                    {{ $x->mahasiswa?->name ?? '-' }}
                                    <div class="text-xs text-gray-500">
                                        {{ $x->mahasiswa?->nim ?? '-' }} • {{ $x->mahasiswa?->no_hp ?? '-' }}
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-gray-700">{{ $x->instansi?->nama_instansi ?? '-' }}</td>
                                <td class="px-4 py-3 text-gray-700">{{ $x->periode?->nama_periode ?? '-' }}</td>
                                <td class="px-4 py-3 text-gray-700">
                                    {{ $x->tgl_mulai ? \Carbon\Carbon::parse($x->tgl_mulai)->format('d-m-Y') : '-' }}</td>
                                <td class="px-4 py-3 text-gray-700">
                                    {{ $x->tgl_selesai ? \Carbon\Carbon::parse($x->tgl_selesai)->format('d-m-Y') : '-' }}
                                </td>
                                <td class="px-4 py-3">
                                    <span
                                        class="inline-flex px-2 py-1 rounded-md text-xs bg-gray-100 border border-gray-200 capitalize">
                                        {{ $x->status }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-10 text-center text-gray-500">
                                    Belum ada mahasiswa bimbingan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="px-4 py-3 border-t border-gray-200 flex items-center justify-between text-sm text-gray-600">
                <span>Menampilkan {{ $items->firstItem() ?? 0 }} - {{ $items->lastItem() ?? 0 }} dari
                    {{ $items->total() }}</span>
                <div>{{ $items->links() }}</div>
            </div>
        </div>
    </div>
@endsection
