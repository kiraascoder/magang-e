@php
    $role = auth()->user()->role ?? 'mahasiswa';

    $menusByRole = [
        'admin' => [
            ['label' => 'Dashboard', 'icon' => 'home', 'route' => 'admin.dashboard'],
            ['label' => 'Kelola Users', 'icon' => 'users', 'route' => 'admin.users'],
            ['label' => 'Instansi', 'icon' => 'building', 'route' => 'admin.instansi'],
            ['label' => 'Periode Magang', 'icon' => 'calendar', 'route' => 'admin.periode'],
            ['label' => 'Penempatan', 'icon' => 'pin', 'route' => 'admin.penempatan'],
        ],
        'dosen' => [
            ['label' => 'Dashboard', 'icon' => 'home', 'route' => 'dosen.dashboard'],
            ['label' => 'Mahasiswa Bimbingan', 'icon' => 'users', 'route' => 'dosen.mahasiswa'],
            ['label' => 'Review Logbook', 'icon' => 'book', 'route' => 'dosen.logbook'],
            ['label' => 'Nilai', 'icon' => 'star', 'route' => 'dosen.nilai'],
            ['label' => 'Laporan', 'icon' => 'file', 'route' => 'dosen.laporan'],
        ],
        'mahasiswa' => [
            ['label' => 'Dashboard', 'icon' => 'home', 'route' => 'mahasiswa.dashboard'],
            ['label' => 'Logbook', 'icon' => 'book', 'route' => 'mahasiswa.logbook'],
            ['label' => 'Jurnal', 'icon' => 'note', 'route' => 'mahasiswa.jurnal'],
            ['label' => 'Upload Laporan', 'icon' => 'upload', 'route' => 'mahasiswa.laporan'],
            ['label' => 'Nilai', 'icon' => 'star', 'route' => 'mahasiswa.nilai'],
            ['label' => 'Profil', 'icon' => 'user', 'route' => 'mahasiswa.profil'],
        ],
    ];

    $menus = $menusByRole[$role] ?? $menusByRole['mahasiswa'];

    $href = function ($r) {
        if (!$r) {
            return '#';
        }
        try {
            return route($r);
        } catch (\Throwable $e) {
            return '#';
        }
    };

    $isActive = function ($r) {
        if (!$r) {
            return false;
        }
        try {
            return request()->routeIs($r);
        } catch (\Throwable $e) {
            return false;
        }
    };

    $icon = function ($name) {
        return match ($name) {
            'home'
                => '<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-width="2" d="M3 10.5 12 3l9 7.5V21a1 1 0 0 1-1 1h-5v-7H9v7H4a1 1 0 0 1-1-1v-10.5z"/></svg>',
            'users'
                => '<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-width="2" d="M17 21a7 7 0 0 0-14 0"/><circle cx="10" cy="7" r="4" stroke-width="2"/><path stroke-width="2" d="M23 21a6 6 0 0 0-9-5"/></svg>',
            'building'
                => '<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-width="2" d="M3 21h18"/><path stroke-width="2" d="M7 21V5a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v16"/><path stroke-width="2" d="M10 9h4M10 13h4M10 17h4"/></svg>',
            'calendar'
                => '<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect x="3" y="4" width="18" height="18" rx="2" ry="2" stroke-width="2"/><path stroke-width="2" d="M16 2v4M8 2v4M3 10h18"/></svg>',
            'pin'
                => '<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-width="2" d="M12 22s7-4.5 7-11a7 7 0 1 0-14 0c0 6.5 7 11 7 11z"/><circle cx="12" cy="11" r="2" stroke-width="2"/></svg>',
            'file'
                => '<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-width="2" d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path stroke-width="2" d="M14 2v6h6"/><path stroke-width="2" d="M8 13h8M8 17h8"/></svg>',
            'book'
                => '<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-width="2" d="M4 19a2 2 0 0 0 2 2h12"/><path stroke-width="2" d="M6 2h12a2 2 0 0 1 2 2v16a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2z"/></svg>',
            'note'
                => '<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-width="2" d="M4 4h16v16H4z"/><path stroke-width="2" d="M8 8h8M8 12h8M8 16h6"/></svg>',
            'upload'
                => '<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-width="2" d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><path stroke-width="2" d="M7 10l5-5 5 5"/><path stroke-width="2" d="M12 5v14"/></svg>',
            'star'
                => '<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-width="2" d="M12 17.27 18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>',
            'user'
                => '<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-width="2" d="M20 21a8 8 0 0 0-16 0"/><circle cx="12" cy="7" r="4" stroke-width="2"/></svg>',
            default => '<span class="w-5 h-5"></span>',
        };
    };
@endphp

<div class="p-3">
    <div class="px-3 py-2 rounded-xl bg-gray-50 border border-gray-200 mb-3">
        <div class="text-xs text-gray-500">Role</div>
        <div class="text-sm font-semibold capitalize">{{ $role }}</div>
    </div>

    <div class="space-y-1">
        @foreach ($menus as $m)
            @php $active = $isActive($m['route']); @endphp

            <a href="{{ $href($m['route']) }}"
                class="flex items-center gap-3 px-3 py-2 rounded-lg border transition
                      {{ $active ? 'bg-gray-100 border-gray-200 font-semibold' : 'border-transparent hover:bg-gray-50 hover:border-gray-200' }}">
                <span class="{{ $active ? 'text-gray-900' : 'text-gray-500' }}">{!! $icon($m['icon']) !!}</span>
                <span class="text-sm">{{ $m['label'] }}</span>
            </a>
        @endforeach
    </div>

    <div class="mt-4 pt-4 border-t border-gray-200">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="w-full flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-red-50 text-red-600">
                <span class="inline-flex w-6 h-6 items-center justify-center rounded-md bg-red-100">↩</span>
                <span class="text-sm font-medium">Logout</span>
            </button>
        </form>
    </div>
</div>
