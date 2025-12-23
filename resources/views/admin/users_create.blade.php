@extends('layouts.app')

@section('title', 'Tambah User')
@section('page_title', 'Tambah User')
@section('page_desc', 'Buat akun Admin/Dosen/Mahasiswa.')

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

    <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-4">
        @csrf

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="text-sm text-gray-600">Nama</label>
                <input name="name" value="{{ old('name') }}"
                    class="mt-1 w-full px-3 py-2 rounded-lg border border-gray-200" />
            </div>

            <div>
                <label class="text-sm text-gray-600">Role</label>
                <select name="role" id="role" onchange="syncRoleFields()"
                    class="mt-1 w-full px-3 py-2 rounded-lg border border-gray-200">
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="dosen" {{ old('role') == 'dosen' ? 'selected' : '' }}>Dosen</option>
                    <option value="mahasiswa" {{ old('role', 'mahasiswa') == 'mahasiswa' ? 'selected' : '' }}>Mahasiswa
                    </option>
                </select>
                <p id="roleHint" class="text-xs text-gray-500 mt-1">Admin wajib email.</p>
            </div>

            <div>
                <label class="text-sm text-gray-600">Email (untuk admin)</label>
                <input name="email" value="{{ old('email') }}"
                    class="mt-1 w-full px-3 py-2 rounded-lg border border-gray-200" />
            </div>

            <div>
                <label class="text-sm text-gray-600">NIM (untuk mahasiswa)</label>
                <input name="nim" value="{{ old('nim') }}"
                    class="mt-1 w-full px-3 py-2 rounded-lg border border-gray-200" />
            </div>

            <div>
                <label class="text-sm text-gray-600">NBM (untuk dosen)</label>
                <input name="nbm" value="{{ old('nbm') }}"
                    class="mt-1 w-full px-3 py-2 rounded-lg border border-gray-200" />
            </div>

            <div>
                <label class="text-sm text-gray-600">No HP</label>
                <input name="no_hp" value="{{ old('no_hp') }}"
                    class="mt-1 w-full px-3 py-2 rounded-lg border border-gray-200" />
            </div>

            <div class="sm:col-span-2">
                <label class="text-sm text-gray-600">Password</label>
                <input type="password" name="password" class="mt-1 w-full px-3 py-2 rounded-lg border border-gray-200" />
            </div>
        </div>

        <div class="flex gap-2">
            <a href="{{ route('admin.users') }}"
                class="px-4 py-2 rounded-lg border border-gray-200 hover:bg-gray-50">Kembali</a>
            <button class="px-4 py-2 rounded-lg bg-gray-900 text-white hover:bg-gray-800">
                Simpan
            </button>
        </div>
    </form>

    <script>
        function syncRoleFields() {
            const role = document.getElementById('role').value;
            const hint = document.getElementById('roleHint');

            if (role === 'admin') hint.textContent = 'Admin wajib email.';
            else if (role === 'dosen') hint.textContent = 'Dosen wajib NBM.';
            else hint.textContent = 'Mahasiswa wajib NIM.';
        }
        syncRoleFields();
    </script>
@endsection
