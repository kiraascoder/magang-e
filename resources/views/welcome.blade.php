<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ config('app.name', 'Sistem Pemagangan') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>

<body class="min-h-screen bg-slate-50 text-slate-900">

    {{-- TOPBAR --}}
    <div class="bg-slate-900 text-slate-100">
        <div
            class="mx-auto max-w-6xl px-4 py-2 text-xs flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex items-center gap-2">
                <span class="h-2 w-2 rounded-full bg-emerald-400"></span>
                <span>Universitas Muhammadiyah Parepare • Sistem Pemagangan</span>
            </div>
            <div class="opacity-80">Jam Layanan: Senin–Jumat 08.00–16.00</div>
        </div>
    </div>

    {{-- HEADER --}}
    <header class="sticky top-0 z-40 border-b border-slate-200 bg-white/90 backdrop-blur">
        <div class="mx-auto max-w-6xl px-4 py-4 flex items-center justify-between">
            <a href="/" class="flex items-center gap-3">
                <div class="grid h-10 w-10 place-items-center rounded-xl bg-slate-900 text-white">
                    <span class="text-sm font-black">UM</span>
                </div>
                <div class="leading-tight">
                    <div class="text-sm font-extrabold tracking-tight">
                        {{ config('app.name', 'Sistem Pemagangan') }}
                    </div>
                    <div class="text-xs text-slate-500">Universitas Muhammadiyah Parepare</div>
                </div>
            </a>

            <div class="flex items-center gap-2">
                @auth
                    {{-- arahkan sesuai role --}}
                    @php
                        $role = auth()->user()->role ?? null;
                        $to =
                            $role === 'admin'
                                ? route('admin.dashboard')
                                : ($role === 'dosen'
                                    ? route('dosen.dashboard')
                                    : route('mahasiswa.dashboard'));
                    @endphp
                    <a href="{{ $to }}"
                        class="inline-flex items-center rounded-xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:opacity-90">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}"
                        class="inline-flex items-center rounded-xl px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-100">
                        Login
                    </a>
                @endauth
            </div>
        </div>
    </header>

    {{-- HERO / JUMBOTRON FOTO KAMPUS --}}
    <main class="mx-auto max-w-6xl px-4">
        <section class="mt-6 overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
            <div class="relative">
                {{-- Gambar kampus --}}
                <img src="{{ asset('images/umpar.jpg') }}" alt="Kampus Universitas Muhammadiyah Parepare"
                    class="h-[360px] w-full object-cover">

                {{-- Overlay --}}
                <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-slate-950/35 to-transparent"></div>

                {{-- Text --}}
                <div class="absolute inset-0 flex items-end">
                    <div class="p-6 md:p-10">
                        <div
                            class="inline-flex items-center gap-2 rounded-full bg-white/10 px-3 py-1 text-xs font-semibold text-white">
                            <span class="h-2 w-2 rounded-full bg-amber-400"></span>
                            Portal Resmi
                        </div>

                        <h1 class="mt-3 text-3xl md:text-4xl font-extrabold tracking-tight text-white">
                            Sistem Informasi Pemagangan
                        </h1>
                        <p class="mt-2 max-w-2xl text-sm md:text-base text-white/85">
                            Kelola penempatan magang mahasiswa, pembimbing dosen, instansi mitra, logbook, laporan,
                            hingga penilaian dalam satu sistem.
                        </p>

                        <div class="mt-5 flex flex-col sm:flex-row gap-2">
                            <a href="{{ route('login') }}"
                                class="inline-flex items-center justify-center rounded-xl bg-amber-500 px-5 py-3 text-sm font-bold text-slate-900 hover:opacity-95">
                                Masuk Sistem
                            </a>
                            <a href="#fitur"
                                class="inline-flex items-center justify-center rounded-xl border border-white/25 bg-white/10 px-5 py-3 text-sm font-semibold text-white hover:bg-white/15">
                                Lihat Fitur
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- QUICK INFO --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 p-6 md:p-8 bg-white">
                <div class="rounded-2xl border border-slate-200 bg-slate-50 p-5">
                    <div class="text-sm font-bold">Admin</div>
                    <p class="mt-1 text-sm text-slate-600">Kelola user, instansi, periode, dan penempatan.</p>
                </div>
                <div class="rounded-2xl border border-slate-200 bg-slate-50 p-5">
                    <div class="text-sm font-bold">Dosen</div>
                    <p class="mt-1 text-sm text-slate-600">Pantau mahasiswa bimbingan & lakukan penilaian.</p>
                </div>
                <div class="rounded-2xl border border-slate-200 bg-slate-50 p-5">
                    <div class="text-sm font-bold">Mahasiswa</div>
                    <p class="mt-1 text-sm text-slate-600">Isi logbook, unggah laporan, dan lihat hasil evaluasi.</p>
                </div>
            </div>
        </section>

        {{-- FITUR SINGKAT --}}
        <section id="fitur" class="py-12">
            <div class="flex items-end justify-between gap-4">
                <div>
                    <h2 class="text-2xl font-extrabold tracking-tight">Fitur Utama</h2>
                    <p class="mt-1 text-sm text-slate-600">Ringkas, rapi, dan mudah dipakai.</p>
                </div>
            </div>

            <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                @php
                    $features = [
                        ['t' => 'Penempatan Magang', 'd' => 'Admin menentukan mentor, instansi, periode, dan status.'],
                        ['t' => 'Monitoring & Logbook', 'd' => 'Mahasiswa mencatat kegiatan, dosen memantau.'],
                        ['t' => 'Laporan & Penilaian', 'd' => 'Upload laporan dan input nilai terstruktur.'],
                    ];
                @endphp

                @foreach ($features as $f)
                    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                        <div class="text-sm font-extrabold">{{ $f['t'] }}</div>
                        <p class="mt-2 text-sm text-slate-600">{{ $f['d'] }}</p>
                    </div>
                @endforeach
            </div>
        </section>
    </main>

    {{-- FOOTER --}}
    <footer class="border-t border-slate-200 bg-white">
        <div class="mx-auto max-w-6xl px-4 py-10 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <div class="text-sm font-extrabold">{{ config('app.name', 'Sistem Pemagangan') }}</div>
                <div class="text-xs text-slate-500">© {{ date('Y') }} Universitas Muhammadiyah Parepare</div>
            </div>
            <div class="text-xs text-slate-500">
                *Ganti gambar di <span class="font-semibold">public/images/umpar.jpg</span>
            </div>
        </div>
    </footer>

</body>

</html>
