<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 text-gray-800">
    <div class="min-h-screen">

        {{-- TOPBAR --}}
        <header
            class="sticky top-0 z-30 h-14 bg-white border-b border-gray-200 flex items-center justify-between px-4 sm:px-6">
            <div class="flex items-center gap-3">
                {{-- Mobile toggle --}}
                <button id="sidebarToggle"
                    class="sm:hidden inline-flex items-center justify-center w-10 h-10 rounded-lg hover:bg-gray-100 border border-gray-200"
                    type="button" aria-label="Buka menu">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor">
                        <path stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>

                <span class="font-semibold text-gray-900 tracking-tight">Sistem Pemagangan</span>
            </div>

            <div class="flex items-center gap-3">
                <div class="hidden sm:flex flex-col leading-tight text-right">
                    <span class="text-sm font-medium">{{ auth()->user()->name ?? 'User' }}</span>
                    <span class="text-xs text-gray-500 capitalize">{{ auth()->user()->role ?? '-' }}</span>
                </div>

                <div class="w-9 h-9 rounded-full bg-gray-100 border border-gray-200 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-600" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor">
                        <path stroke-width="2" d="M20 21a8 8 0 0 0-16 0"></path>
                        <circle cx="12" cy="7" r="4" stroke-width="2"></circle>
                    </svg>
                </div>
            </div>
        </header>

        <div class="flex">
            {{-- Overlay mobile --}}
            <div id="sidebarOverlay" class="fixed inset-0 bg-black/30 z-20 hidden sm:hidden"></div>

            <aside class="w-72 sm:w-64 bg-white border-r border-gray-200">
                <div class="h-14 flex items-center px-4 border-b border-gray-200">
                    <span class="text-sm font-semibold text-gray-900">Menu</span>
                </div>

                @include('sidebar.navigation')
            </aside>


            {{-- MAIN --}}
            <main class="flex-1 min-w-0">
                <div class="p-4 sm:p-6">
                    <div class="mb-5">
                        <h1 class="text-xl sm:text-2xl font-semibold text-gray-900">
                            @yield('page_title', 'Selamat Datang')
                        </h1>
                        <p class="text-sm text-gray-500">
                            @yield('page_desc', 'Kelola aktivitas pemagangan dengan mudah.')
                        </p>
                    </div>

                    <div class="bg-white border border-gray-200 rounded-2xl p-4 sm:p-6 shadow-sm">
                        @if (session('success'))
                            <div class="mb-4 p-3 rounded-lg border border-green-200 bg-green-50 text-green-700 text-sm">
                                {{ session('success') }}
                            </div>
                        @endif
                        @yield('content')
                    </div>
                </div>
            </main>

        </div>
    </div>

    <script>
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const openBtn = document.getElementById('sidebarToggle');
        const closeBtn = document.getElementById('sidebarClose');

        function openSidebar() {
            sidebar.classList.remove('-translate-x-full');
            overlay.classList.remove('hidden');
        }

        function closeSidebar() {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        }

        if (openBtn) openBtn.addEventListener('click', openSidebar);
        if (closeBtn) closeBtn.addEventListener('click', closeSidebar);
        if (overlay) overlay.addEventListener('click', closeSidebar);
    </script>
</body>

</html>
