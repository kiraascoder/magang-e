@extends('layouts.app')

@section('title', 'Edit User')
@section('page_title', 'Edit User')
@section('page_desc', 'Ubah data user. Password opsional.')

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

    <form method="POST" action="{{ route('admin.users.update', $user->id) }}" class="space-y-4">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="text-sm text-gray-600">Nama</label>
                <input name="name" value="{{ old('name', $user->name) }}"
                    class="mt-1 w-full px-3 py-2 rounded-lg border border-gray-200" />
            </div>

            <div>
                <label class="text-sm text-gray-600">Role</label>
                <select name="role" id="role" onchange="syncRoleFields()"
                    class="mt-1 w-full px-3 py-2 rounded-lg border border-gray-200">
                    <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="dosen" {{ old('role', $user->role) == 'dosen' ? 'selected' : '' }}>Dosen</option>
                    <option value="mahasiswa" {{ old('role', $user->role) == 'mahasiswa' ? 'selected' : '' }}>Mahasiswa
                    </option>
                </select>
                <p id="roleHint" class="text-xs text-gray-500 mt-1">-</p>
            </div>

            <div>
                <label class="text-sm text-gray-600">Email (untuk admin)</label>
                <input name="email" value="{{ old('email', $user->email) }}"
                    class="mt-1 w-full px-3 py-2 rounded-lg border border-gray-200" />
            </div>

            <div>
                <label class="text-sm text-gray-600">NIM (untuk mahasiswa)</label>
                <input name="nim" value="{{ old('nim', $user->nim) }}"
                    class="mt-1 w-full px-3 py-2 rounded-lg border border-gray-200" />
            </div>

            <div>
                <label class="text-sm text-gray-600">NBM (untuk dosen)</label>
                <input name="nbm" value="{{ old('nbm', $user->nbm) }}"
                    class="mt-1 w-full px-3 py-2 rounded-lg border border-gray-200" />
            </div>

            <div>
                <label class="text-sm text-gray-600">No HP</label>
                <input name="no_hp" value="{{ old('no_hp', $user->no_hp) }}"
                    class="mt-1 w-full px-3 py-2 rounded-lg border border-gray-200" />
            </div>

            <div class="sm:col-span-2">
                <label class="text-sm text-gray-600">Password (kosongkan jika tidak diganti)</label>
                <input type="password" name="password" class="mt-1 w-full px-3 py-2 rounded-lg border border-gray-200" />
            </div>
        </div>

        <div class="flex gap-2">
            <a href="{{ route('admin.users') }}"
                class="px-4 py-2 rounded-lg border border-gray-200 hover:bg-gray-50">Kembali</a>
            <button class="px-4 py-2 rounded-lg bg-gray-900 text-white hover:bg-gray-800">
                Update
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
