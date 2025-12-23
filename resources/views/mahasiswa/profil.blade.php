@extends('layouts.app')

@section('title','Profil')
@section('page_title','Profil')
@section('page_desc','Data akun mahasiswa.')

@section('content')
<div class="bg-white border border-gray-200 rounded-2xl p-4 space-y-3">
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
        <div>
            <div class="text-gray-500">Nama</div>
            <div class="font-medium text-gray-900">{{ $user->name }}</div>
        </div>
        <div>
            <div class="text-gray-500">Role</div>
            <div class="font-medium text-gray-900 capitalize">{{ $user->role }}</div>
        </div>
        <div>
            <div class="text-gray-500">Email</div>
            <div class="font-medium text-gray-900">{{ $user->email ?? '-' }}</div>
        </div>
        <div>
            <div class="text-gray-500">NIM</div>
            <div class="font-medium text-gray-900">{{ $user->nim ?? '-' }}</div>
        </div>
        <div>
            <div class="text-gray-500">No HP</div>
            <div class="font-medium text-gray-900">{{ $user->no_hp ?? '-' }}</div>
        </div>
    </div>

    <div class="text-xs text-gray-500">
        *Edit profil bisa kita tambah setelah fitur utama (logbook/laporan/nilai) selesai.
    </div>
</div>
@endsection
