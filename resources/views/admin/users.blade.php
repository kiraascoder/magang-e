@extends('layouts.app')

@section('title', 'Users')
@section('page_title', 'Kelola Users')
@section('page_desc', 'Tambah, cari, filter, dan kelola akun Admin/Dosen/Mahasiswa.')

@section('content')
    <div class="space-y-4">

        {{-- TOP ACTIONS --}}
        <div class="flex flex-col sm:flex-row gap-3 sm:items-center sm:justify-between">
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.users.create') }}"
                    class="inline-flex items-center gap-2 px-3 py-2 rounded-lg bg-gray-900 text-white hover:bg-gray-800 text-sm">
                    <span class="text-base">+</span>
                    <span>Tambah User</span>
                </a>                
            </div>

            {{-- Search + Filter --}}
            <form method="GET" action="{{ route('admin.users') }}" class="flex ...">
                <input type="text" name="q" value="{{ request('q') }}"
                    placeholder="Cari nama / email / NIM / NBM..."
                    class="w-full sm:w-72 px-3 py-2 rounded-lg border border-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-200">

                <select name="role"
                    class="w-full sm:w-44 px-3 py-2 rounded-lg border border-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-200">
                    <option value="">Semua Role</option>
                    <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="dosen" {{ request('role') == 'dosen' ? 'selected' : '' }}>Dosen</option>
                    <option value="mahasiswa" {{ request('role') == 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
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
                <div class="text-sm text-gray-500">Total User</div>
                <div class="mt-1 text-2xl font-semibold">{{ $users->count() }}</div>
                <div class="mt-2 text-xs text-gray-500">Semua role</div>
            </div>
            <div class="p-4 rounded-2xl border border-gray-200 bg-white">
                <div class="text-sm text-gray-500">Mahasiswa</div>
                <div class="mt-1 text-2xl font-semibold">{{ $countMhs }}</div>
                <div class="mt-2 text-xs text-gray-500">Role mahasiswa</div>
            </div>
            <div class="p-4 rounded-2xl border border-gray-200 bg-white">
                <div class="text-sm text-gray-500">Dosen</div>
                <div class="mt-1 text-2xl font-semibold">{{ $countDosen }}</div>
                <div class="mt-2 text-xs text-gray-500">Role dosen</div>
            </div>
        </div>

        {{-- TABLE --}}
        <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden">
            <div class="px-4 py-3 border-b border-gray-200 flex items-center justify-between">
                <div class="font-semibold text-gray-900">Daftar Users</div>
                <div class="text-xs text-gray-500">*Data masih dummy</div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-gray-600">
                        <tr class="text-left">
                            <th class="px-4 py-3">Nama</th>
                            <th class="px-4 py-3">Role</th>
                            <th class="px-4 py-3">Email</th>
                            <th class="px-4 py-3">NIM / NBM</th>
                            <th class="px-4 py-3">No HP</th>
                            <th class="px-4 py-3 w-40">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($users as $u)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 font-medium text-gray-900">{{ $u->name }}</td>

                                <td class="px-4 py-3">
                                    <span
                                        class="inline-flex px-2 py-1 rounded-md text-xs bg-gray-100 border border-gray-200 capitalize">
                                        {{ $u->role }}
                                    </span>
                                </td>

                                <td class="px-4 py-3 text-gray-700">{{ $u->email ?? '-' }}</td>

                                <td class="px-4 py-3 text-gray-700">
                                    {{ $u->role === 'dosen' ? $u->nbm ?? '-' : $u->nim ?? '-' }}
                                </td>

                                <td class="px-4 py-3 text-gray-700">{{ $u->no_hp ?? '-' }}</td>

                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('admin.users.edit', $u->id) }}"
                                            class="px-3 py-1.5 rounded-lg border border-gray-200 hover:bg-gray-50 text-xs">
                                            Edit
                                        </a>

                                        <form method="POST" action="{{ route('admin.users.destroy', $u->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('Yakin hapus user ini?')"
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
                                    Belum ada data user.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

            {{-- PAGINATION PLACEHOLDER --}}
            <div class="px-4 py-3 border-t border-gray-200 flex items-center justify-between text-sm text-gray-600">
                <span>
                    Menampilkan {{ $users->firstItem() ?? 0 }} - {{ $users->lastItem() ?? 0 }} dari {{ $users->total() }}
                </span>
                <div>{{ $users->links() }}</div>
            </div>

        </div>

    </div>
@endsection
