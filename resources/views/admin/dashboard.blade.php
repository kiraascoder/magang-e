@extends('layouts.app')

@section('title', 'Dashboard Admin')
@section('page_title', 'Dashboard Admin')
@section('page_desc', 'Ringkasan data & akses cepat fitur utama.')

@section('content')
    <div class="space-y-6">

        {{-- STAT CARDS --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="p-4 rounded-2xl border border-gray-200 bg-white">
                <div class="text-sm text-gray-500">Total Mahasiswa</div>
                <div class="mt-1 text-2xl font-semibold text-gray-900">{{ $totalMahasiswa }}</div>
                <div class="mt-2 text-xs text-gray-500">Terdaftar di sistem</div>
            </div>

            <div class="p-4 rounded-2xl border border-gray-200 bg-white">
                <div class="text-sm text-gray-500">Total Dosen</div>
                <div class="mt-1 text-2xl font-semibold text-gray-900">{{ $totalDosen }}</div>
                <div class="mt-2 text-xs text-gray-500">Mentor/bimbingan</div>
            </div>

            <div class="p-4 rounded-2xl border border-gray-200 bg-white">
                <div class="text-sm text-gray-500">Instansi</div>
                <div class="mt-1 text-2xl font-semibold text-gray-900">{{ $totalInstansi }}</div>
                <div class="mt-2 text-xs text-gray-500">Mitra penempatan</div>
            </div>

            <div class="p-4 rounded-2xl border border-gray-200 bg-white">
                <div class="text-sm text-gray-500">Penempatan Aktif</div>
                <div class="mt-1 text-2xl font-semibold text-gray-900">{{ $aktif }}</div>
                <div class="mt-2 text-xs text-gray-500">Status: aktif</div>
            </div>
        </div>

        {{-- QUICK ACTIONS + RINGKASAN --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
            {{-- Quick Actions --}}
            <div class="p-4 rounded-2xl border border-gray-200 bg-white">
                <div class="flex items-center justify-between">
                    <h3 class="font-semibold text-gray-900">Quick Actions</h3>
                    <span class="text-xs text-gray-500">Admin</span>
                </div>

                <div class="mt-4 grid grid-cols-1 gap-2">
                    <a href="{{ route('admin.users.create') }}"
                        class="px-3 py-2 rounded-lg border border-gray-200 hover:bg-gray-50 text-sm">
                        + Tambah User
                    </a>
                    <a href="{{ route('admin.instansi.create') }}"
                        class="px-3 py-2 rounded-lg border border-gray-200 hover:bg-gray-50 text-sm">
                        + Tambah Instansi
                    </a>
                    <a href="{{ route('admin.periode.create') }}"
                        class="px-3 py-2 rounded-lg border border-gray-200 hover:bg-gray-50 text-sm">
                        + Buat Periode
                    </a>
                    <a href="#" class="px-3 py-2 rounded-lg border border-gray-200 hover:bg-gray-50 text-sm">
                        + Buat Penempatan
                    </a>
                </div>                
            </div>

            {{-- Ringkasan Status --}}
            <div class="lg:col-span-2 p-4 rounded-2xl border border-gray-200 bg-white">
                <div class="flex items-center justify-between">
                    <h3 class="font-semibold text-gray-900">Ringkasan Penempatan</h3>
                    <a href="{{ route('admin.penempatan') }}" class="text-sm text-gray-700 hover:underline">Lihat semua</a>
                </div>

                <div class="mt-4 grid grid-cols-2 sm:grid-cols-4 gap-3">
                    <div class="p-3 rounded-xl bg-gray-50 border border-gray-200">
                        <div class="text-xs text-gray-500">Draft</div>
                        <div class="text-lg font-semibold">0</div>
                    </div>
                    <div class="p-3 rounded-xl bg-gray-50 border border-gray-200">
                        <div class="text-xs text-gray-500">Aktif</div>
                        <div class="text-lg font-semibold">0</div>
                    </div>
                    <div class="p-3 rounded-xl bg-gray-50 border border-gray-200">
                        <div class="text-xs text-gray-500">Selesai</div>
                        <div class="text-lg font-semibold">0</div>
                    </div>
                    <div class="p-3 rounded-xl bg-gray-50 border border-gray-200">
                        <div class="text-xs text-gray-500">Batal</div>
                        <div class="text-lg font-semibold">0</div>
                    </div>
                </div>

                {{-- Table placeholder --}}
                <div class="mt-5 overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="text-left text-gray-500 border-b">
                                <th class="py-2 pr-3">Mahasiswa</th>
                                <th class="py-2 pr-3">Mentor</th>
                                <th class="py-2 pr-3">Instansi</th>
                                <th class="py-2 pr-3">Status</th>
                                <th class="py-2 pr-3">Periode</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- sementara dummy --}}
                            <tr class="border-b">
                                <td class="py-3 pr-3 text-gray-700">-</td>
                                <td class="py-3 pr-3 text-gray-700">-</td>
                                <td class="py-3 pr-3 text-gray-700">-</td>
                                <td class="py-3 pr-3">
                                    <span
                                        class="inline-flex px-2 py-1 rounded-md text-xs bg-gray-100 border border-gray-200">
                                        draft
                                    </span>
                                </td>
                                <td class="py-3 pr-3 text-gray-700">-</td>
                            </tr>
                            <tr>
                                <td class="py-3 pr-3 text-gray-700">-</td>
                                <td class="py-3 pr-3 text-gray-700">-</td>
                                <td class="py-3 pr-3 text-gray-700">-</td>
                                <td class="py-3 pr-3">
                                    <span
                                        class="inline-flex px-2 py-1 rounded-md text-xs bg-gray-100 border border-gray-200">
                                        draft
                                    </span>
                                </td>
                                <td class="py-3 pr-3 text-gray-700">-</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
@endsection
