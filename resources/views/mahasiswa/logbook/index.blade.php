@extends('layouts.app')

@section('title', 'Logbook')
@section('page_title', 'Logbook')
@section('page_desc', 'Aktivitas harian magang kamu.')

@section('content')
    <div class="space-y-4">

        @if (session('success'))
            <div class="p-3 rounded-lg border border-emerald-200 bg-emerald-50 text-emerald-700 text-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex flex-col sm:flex-row gap-2 sm:items-center sm:justify-between">
            <a href="{{ route('mahasiswa.logbook.create') }}"
                class="inline-flex items-center gap-2 px-3 py-2 rounded-lg bg-gray-900 text-white hover:bg-gray-800 text-sm w-fit">
                <span class="text-base">+</span> Tambah Logbook
            </a>

            <form method="GET" action="{{ route('mahasiswa.logbook') }}" class="flex gap-2 w-full sm:w-auto">
                <select name="status" class="w-full sm:w-44 px-3 py-2 rounded-lg border border-gray-200">
                    <option value="">Semua Status</option>
                    @foreach (['draft', 'terkirim', 'disetujui', 'ditolak'] as $st)
                        <option value="{{ $st }}" {{ request('status') === $st ? 'selected' : '' }}>
                            {{ ucfirst($st) }}</option>
                    @endforeach
                </select>
                <button
                    class="px-3 py-2 rounded-lg bg-white border border-gray-200 hover:bg-gray-50 text-sm">Filter</button>
            </form>
        </div>

        <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden">
            <div class="px-4 py-3 border-b border-gray-200 flex items-center justify-between">
                <div class="font-semibold text-gray-900">Daftar Logbook</div>
                <div class="text-xs text-gray-500">Total: {{ $items->total() }}</div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-gray-600">
                        <tr class="text-left">
                            <th class="px-4 py-3">Tanggal</th>
                            <th class="px-4 py-3">Kegiatan</th>
                            <th class="px-4 py-3">Dokumentasi</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3 w-56">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">
                        @forelse($items as $x)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-gray-900">
                                    {{ \Carbon\Carbon::parse($x->tanggal)->format('d-m-Y') }}
                                </td>
                                <td class="px-4 py-3 text-gray-700">
                                    {{ \Illuminate\Support\Str::limit($x->kegiatan, 80) }}
                                    @if ($x->catatan_mentor)
                                        <div class="mt-1 text-xs text-amber-700">
                                            Catatan mentor: {{ \Illuminate\Support\Str::limit($x->catatan_mentor, 60) }}
                                        </div>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    @if ($x->dokumentasi)
                                        <a class="text-sm text-blue-700 hover:underline" target="_blank"
                                            href="{{ asset('storage/' . $x->dokumentasi) }}">Lihat</a>
                                    @else
                                        <span class="text-xs text-gray-500">-</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    <span
                                        class="inline-flex px-2 py-1 rounded-md text-xs bg-gray-100 border border-gray-200 capitalize">
                                        {{ $x->status }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex flex-wrap gap-2">
                                        @if (in_array($x->status, ['draft', 'ditolak']))
                                            <a href="{{ route('mahasiswa.logbook.edit', $x->id_logbook) }}"
                                                class="px-3 py-1.5 rounded-lg border border-gray-200 hover:bg-gray-50 text-xs">
                                                Edit
                                            </a>

                                            <form method="POST"
                                                action="{{ route('mahasiswa.logbook.submit', $x->id_logbook) }}">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" onclick="return confirm('Kirim logbook ke mentor?')"
                                                    class="px-3 py-1.5 rounded-lg bg-gray-900 text-white hover:bg-gray-800 text-xs">
                                                    Kirim
                                                </button>
                                            </form>
                                        @endif

                                        @if ($x->status !== 'disetujui')
                                            <form method="POST"
                                                action="{{ route('mahasiswa.logbook.destroy', $x->id_logbook) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" onclick="return confirm('Yakin hapus logbook ini?')"
                                                    class="px-3 py-1.5 rounded-lg border border-red-200 text-red-600 hover:bg-red-50 text-xs">
                                                    Hapus
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-10 text-center text-gray-500">Belum ada logbook.</td>
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
