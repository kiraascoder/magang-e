<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard')</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>

<body class="bg-gray-50">
<div class="min-h-screen flex">

    {{-- SIDEBAR --}}
    <aside class="w-56 bg-gray-100 border-r border-gray-300">
        <div class="h-14 flex items-center px-4 border-b border-gray-300">
            <span class="font-semibold text-gray-700">Dashboard</span>
        </div>

        <nav class="p-2 space-y-2">
            @php
                $links = [
                    ['label'=>'Logbook', 'route'=>'app.logbook'],
                    ['label'=>'Laporan', 'route'=>'app.laporan'],
                    ['label'=>'Nilai',   'route'=>'app.nilai'],
                ];

                // untuk mockup lain (Data/Magang)
                $linksAlt = [
                    ['label'=>'Data',  'route'=>'app.data'],
                    ['label'=>'Magang','route'=>'app.magang'],
                ];

                // untuk mockup lain (Jurnal/Laporan/Nilai)
                $linksJurnal = [
                    ['label'=>'Jurnal', 'route'=>'app.jurnal'],
                    ['label'=>'Laporan','route'=>'app.laporan'],
                    ['label'=>'Nilai',  'route'=>'app.nilai'],
                ];

                // pilih menu sesuai kebutuhan (sementara tampilkan semua biar cepat)
                $menus = array_merge($links, $linksAlt, $linksJurnal);
                // hilangkan duplikat label (opsional)
                $seen = [];
                $menus = array_values(array_filter($menus, function($m) use (&$seen){
                    if(isset($seen[$m['label']])) return false;
                    $seen[$m['label']] = true;
                    return true;
                }));
            @endphp

            @foreach($menus as $m)
                <a href="{{ route($m['route']) }}"
                   class="block px-3 py-2 border border-gray-300 bg-gray-200 hover:bg-gray-300
                          text-gray-800 rounded
                          {{ request()->routeIs($m['route']) ? 'bg-gray-300 font-semibold' : '' }}">
                    {{ $m['label'] }}
                </a>
            @endforeach

            <form method="POST" action="#" class="pt-2">
                @csrf
                <button type="button"
                        class="w-full flex items-center gap-2 px-3 py-2 text-left text-gray-700 hover:bg-gray-200 rounded">
                    <span>↩</span>
                    <span>Logout</span>
                </button>
            </form>
        </nav>
    </aside>

    {{-- MAIN --}}
    <div class="flex-1">
        {{-- TOPBAR --}}
        <header class="h-14 bg-white border-b border-gray-300 flex items-center justify-between px-6">
            <h1 class="text-xl font-semibold text-gray-800">@yield('page_title', 'Selamat Datang')</h1>

            <div class="flex items-center gap-3">
                <span class="text-sm text-gray-600 hidden sm:block">User</span>
                <div class="w-9 h-9 rounded-full border border-gray-400 flex items-center justify-center">
                    {{-- icon user --}}
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-width="2" d="M20 21a8 8 0 0 0-16 0"></path>
                        <circle cx="12" cy="7" r="4" stroke-width="2"></circle>
                    </svg>
                </div>
            </div>
        </header>

        {{-- CONTENT --}}
        <main class="p-6">
            @yield('content')
        </main>
    </div>

</div>
</body>
</html>
