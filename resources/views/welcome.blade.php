<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>

<body class="min-h-screen bg-slate-50 text-slate-900">
    <!-- Top Info Bar -->
    <div class="bg-slate-900 text-slate-100">
        <div
            class="mx-auto flex max-w-6xl flex-col gap-2 px-4 py-2 text-xs sm:flex-row sm:items-center sm:justify-between">
            <div class="flex flex-wrap items-center gap-x-4 gap-y-1">
                <span class="inline-flex items-center gap-2">
                    <span class="h-2 w-2 rounded-full bg-emerald-400"></span>
                    Portal Akademik • Sistem Informasi
                </span>
                <span class="opacity-80">Jam Layanan: Senin–Jumat 08.00–16.00</span>
            </div>
            <div class="flex items-center gap-3">
                <span class="opacity-80">Email: akademik@kampus.ac.id</span>
                <span class="opacity-50">|</span>
                <span class="opacity-80">Telp: (000) 123-456</span>
            </div>
        </div>
    </div>

    <!-- Header -->
    <header class="sticky top-0 z-40 border-b border-slate-200 bg-white">
        <div class="mx-auto flex max-w-6xl items-center justify-between px-4 py-4">
            <!-- Brand -->
            <a href="/" class="flex items-center gap-3">
                <!-- Logo placeholder -->
                <div class="grid h-11 w-11 place-items-center rounded-xl bg-slate-900 text-white shadow-sm">
                    <span class="text-sm font-black tracking-tight">K</span>
                </div>
                <div class="leading-tight">
                    <div class="text-sm font-bold tracking-tight text-slate-900">
                        {{ config('app.name', 'Portal Kampus') }}
                    </div>
                    <div class="text-xs text-slate-500">Website Resmi • Informasi Akademik</div>
                </div>
            </a>

            <!-- Menu + Auth -->
            <div class="hidden items-center gap-6 md:flex">
                <a href="#pengumuman" class="text-sm font-semibold text-slate-700 hover:text-slate-900">Pengumuman</a>
                <a href="#layanan" class="text-sm font-semibold text-slate-700 hover:text-slate-900">Layanan</a>
                <a href="#profil" class="text-sm font-semibold text-slate-700 hover:text-slate-900">Profil</a>
                <a href="#kontak" class="text-sm font-semibold text-slate-700 hover:text-slate-900">Kontak</a>
            </div>

            @if (Route::has('login'))
                <div class="flex items-center gap-2">
                    @auth
                        <a href="{{ url('/dashboard') }}"
                            class="inline-flex items-center gap-2 rounded-xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:opacity-90">
                            Dashboard
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none">
                                <path d="M7 17L17 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                <path d="M9 7h8v8" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                            </svg>
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                            class="inline-flex items-center rounded-xl px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-100">
                            Login
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                                class="inline-flex items-center rounded-xl bg-amber-500 px-4 py-2 text-sm font-bold text-slate-900 shadow-sm transition hover:opacity-95">
                                Daftar
                            </a>
                        @endif
                    @endauth
                </div>
            @endif
        </div>
    </header>

    <!-- Hero / Banner Kampus -->
    <main class="mx-auto max-w-6xl px-4">
        <section
            class="relative overflow-hidden rounded-3xl bg-slate-900 px-6 py-12 text-white shadow-sm md:px-10 md:py-16">
            <!-- Accent -->
            <div class="pointer-events-none absolute -right-16 -top-16 h-64 w-64 rounded-full bg-amber-500/20 blur-3xl">
            </div>
            <div
                class="pointer-events-none absolute -left-16 -bottom-16 h-64 w-64 rounded-full bg-emerald-400/15 blur-3xl">
            </div>

            <div class="relative grid grid-cols-1 gap-10 md:grid-cols-2 md:items-center">
                <div>
                    <div
                        class="mb-4 inline-flex w-fit items-center gap-2 rounded-full bg-white/10 px-3 py-1 text-xs font-semibold text-white/90">
                        <span class="h-2 w-2 rounded-full bg-amber-400"></span>
                        Informasi Resmi Kampus
                    </div>

                    <h1 class="text-3xl font-extrabold leading-tight tracking-tight md:text-4xl">
                        Portal Akademik & Layanan
                        <span class="text-amber-300">Mahasiswa</span>
                    </h1>

                    <p class="mt-4 max-w-xl text-sm text-white/80 md:text-base">
                        Akses cepat untuk pengumuman, layanan administrasi, informasi jadwal,
                        serta fitur sistem informasi kampus secara terstruktur dan profesional.
                    </p>

                    <div class="mt-7 flex flex-col gap-3 sm:flex-row">
                        <a href="#pengumuman"
                            class="inline-flex items-center justify-center rounded-xl bg-amber-500 px-5 py-3 text-sm font-bold text-slate-900 shadow-sm transition hover:opacity-95">
                            Lihat Pengumuman
                        </a>
                        <a href="#layanan"
                            class="inline-flex items-center justify-center rounded-xl border border-white/30 bg-white/10 px-5 py-3 text-sm font-semibold text-white backdrop-blur transition hover:bg-white/15">
                            Jelajahi Layanan
                        </a>
                    </div>

                    <div class="mt-7 grid grid-cols-3 gap-3">
                        <div class="rounded-2xl bg-white/10 p-4">
                            <div class="text-lg font-extrabold">24/7</div>
                            <div class="text-xs text-white/70">Akses portal</div>
                        </div>
                        <div class="rounded-2xl bg-white/10 p-4">
                            <div class="text-lg font-extrabold">Cepat</div>
                            <div class="text-xs text-white/70">Layanan online</div>
                        </div>
                        <div class="rounded-2xl bg-white/10 p-4">
                            <div class="text-lg font-extrabold">Rapi</div>
                            <div class="text-xs text-white/70">Dokumentasi</div>
                        </div>
                    </div>
                </div>

                <!-- Banner Card -->
                <div class="rounded-3xl bg-white/10 p-6 backdrop-blur md:p-7">
                    <div class="rounded-2xl bg-white p-5 text-slate-900">
                        <div class="flex items-center justify-between">
                            <div>
                                <div class="text-sm font-bold">Agenda & Kalender Akademik</div>
                                <div class="text-xs text-slate-500">Ringkasan informasi terbaru</div>
                            </div>
                            <span class="rounded-full bg-amber-100 px-3 py-1 text-[11px] font-bold text-amber-700">
                                Update
                            </span>
                        </div>

                        <div class="mt-4 space-y-3">
                            <div class="rounded-xl border border-slate-200 p-4">
                                <div class="text-xs font-bold text-slate-600">Minggu ini</div>
                                <div class="mt-1 text-sm font-semibold">Pengisian KRS & Konsultasi Dosen Wali</div>
                                <div class="mt-1 text-xs text-slate-500">Batas akhir: Jumat, 16.00</div>
                            </div>

                            <div class="rounded-xl border border-slate-200 p-4">
                                <div class="text-xs font-bold text-slate-600">Bulan ini</div>
                                <div class="mt-1 text-sm font-semibold">Ujian Tengah Semester (UTS)</div>
                                <div class="mt-1 text-xs text-slate-500">Cek jadwal di menu akademik</div>
                            </div>
                        </div>

                        <div class="mt-4 flex items-center justify-between text-xs text-slate-500">
                            <span>*Konten bisa kamu ganti sesuai kampus</span>
                            <span class="font-semibold text-slate-700">Akademik</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Pengumuman -->
        <section id="pengumuman" class="py-12">
            <div class="flex items-end justify-between gap-4">
                <div>
                    <h2 class="text-2xl font-extrabold tracking-tight text-slate-900">Pengumuman</h2>
                    <p class="mt-1 text-sm text-slate-600">Informasi resmi terbaru untuk mahasiswa & dosen.</p>
                </div>
                <a href="#"
                    class="hidden text-sm font-semibold text-slate-700 hover:text-slate-900 sm:inline-flex">
                    Lihat semua →
                </a>
            </div>

            <div class="mt-6 grid grid-cols-1 gap-5 md:grid-cols-3">
                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <div class="inline-flex rounded-full bg-slate-100 px-3 py-1 text-[11px] font-bold text-slate-700">
                        Akademik</div>
                    <div class="mt-3 text-sm font-extrabold">Pembukaan KRS Semester Genap</div>
                    <p class="mt-2 text-sm text-slate-600">Pengisian KRS dibuka mulai Senin. Pastikan konsultasi dosen
                        wali.</p>
                    <div class="mt-4 text-xs font-semibold text-slate-500">Dipublikasikan: {{ date('d M Y') }}</div>
                </div>

                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <div class="inline-flex rounded-full bg-amber-100 px-3 py-1 text-[11px] font-bold text-amber-700">
                        Beasiswa</div>
                    <div class="mt-3 text-sm font-extrabold">Seleksi Beasiswa Prestasi</div>
                    <p class="mt-2 text-sm text-slate-600">Unggah berkas melalui portal. Kuota terbatas, cek
                        persyaratan.</p>
                    <div class="mt-4 text-xs font-semibold text-slate-500">Deadline: 7 hari lagi</div>
                </div>

                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <div
                        class="inline-flex rounded-full bg-emerald-100 px-3 py-1 text-[11px] font-bold text-emerald-700">
                        Layanan</div>
                    <div class="mt-3 text-sm font-extrabold">Layanan Surat Aktif Kuliah Online</div>
                    <p class="mt-2 text-sm text-slate-600">Ajukan surat aktif kuliah, unduh setelah diverifikasi admin.
                    </p>
                    <div class="mt-4 text-xs font-semibold text-slate-500">Estimasi proses: 1×24 jam</div>
                </div>
            </div>
        </section>

        <!-- Layanan -->
        <section id="layanan" class="pb-12">
            <div class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm md:p-10">
                <div class="flex flex-col gap-2 md:flex-row md:items-end md:justify-between">
                    <div>
                        <h3 class="text-xl font-extrabold tracking-tight">Layanan Utama</h3>
                        <p class="mt-1 text-sm text-slate-600">Pusat layanan administrasi & akademik yang terintegrasi.
                        </p>
                    </div>
                    <div class="text-xs font-bold text-slate-500">Portal • Akademik • Administrasi</div>
                </div>

                <div class="mt-7 grid grid-cols-1 gap-5 md:grid-cols-3">
                    @php
                        $services = [
                            ['t' => 'KRS & Jadwal', 'd' => 'Pengisian KRS, jadwal kuliah, dan kelas.'],
                            ['t' => 'Surat Online', 'd' => 'Surat aktif kuliah, izin penelitian, dan lainnya.'],
                            ['t' => 'Pengajuan & Tracking', 'd' => 'Pantau status pengajuan secara terstruktur.'],
                            ['t' => 'Pengumuman Resmi', 'd' => 'Info akademik, kegiatan kampus, beasiswa.'],
                            ['t' => 'Data Mahasiswa', 'd' => 'Profil, riwayat akademik, dan dokumen penting.'],
                            ['t' => 'Laporan & Rekap', 'd' => 'Rekap layanan untuk admin & pihak terkait.'],
                        ];
                    @endphp

                    @foreach ($services as $s)
                        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-6">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <div class="text-sm font-extrabold text-slate-900">{{ $s['t'] }}</div>
                                    <p class="mt-2 text-sm text-slate-600">{{ $s['d'] }}</p>
                                </div>
                                <div class="grid h-10 w-10 place-items-center rounded-xl bg-slate-900 text-white">
                                    <span class="text-xs font-black">+</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- Profil Kampus -->
        <section id="profil" class="pb-12">
            <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                <div class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm md:col-span-2">
                    <h3 class="text-xl font-extrabold tracking-tight">Profil Singkat</h3>
                    <p class="mt-2 text-sm text-slate-600">
                        Portal ini dirancang untuk mendukung kebutuhan akademik dan administrasi dengan tampilan yang
                        rapi,
                        formal, dan mudah dipahami seperti website kampus pada umumnya.
                    </p>

                    <div class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-6">
                            <div class="text-sm font-extrabold">Visi</div>
                            <p class="mt-2 text-sm text-slate-600">
                                Menjadi layanan digital kampus yang cepat, akurat, dan terpercaya.
                            </p>
                        </div>
                        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-6">
                            <div class="text-sm font-extrabold">Misi</div>
                            <p class="mt-2 text-sm text-slate-600">
                                Mempermudah proses administrasi dan meningkatkan kualitas layanan akademik.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
                    <h3 class="text-xl font-extrabold tracking-tight">Statistik</h3>
                    <div class="mt-6 space-y-4">
                        <div class="rounded-2xl bg-slate-50 p-5">
                            <div class="text-xs font-bold text-slate-500">Mahasiswa</div>
                            <div class="mt-1 text-2xl font-extrabold">1.250</div>
                        </div>
                        <div class="rounded-2xl bg-slate-50 p-5">
                            <div class="text-xs font-bold text-slate-500">Dosen</div>
                            <div class="mt-1 text-2xl font-extrabold">85</div>
                        </div>
                        <div class="rounded-2xl bg-slate-50 p-5">
                            <div class="text-xs font-bold text-slate-500">Prodi</div>
                            <div class="mt-1 text-2xl font-extrabold">12</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Kontak -->
        <section id="kontak" class="pb-16">
            <div class="rounded-3xl bg-slate-900 p-10 text-white shadow-sm">
                <div class="flex flex-col gap-6 md:flex-row md:items-center md:justify-between">
                    <div>
                        <h3 class="text-2xl font-extrabold tracking-tight">Butuh bantuan?</h3>
                        <p class="mt-2 text-sm text-white/80">
                            Hubungi bagian akademik / admin portal untuk kendala akses atau layanan.
                        </p>
                    </div>

                    <div class="flex flex-col gap-3 sm:flex-row">
                        <a href="#"
                            class="inline-flex items-center justify-center rounded-xl bg-amber-500 px-5 py-3 text-sm font-extrabold text-slate-900 shadow-sm transition hover:opacity-95">
                            Hubungi Admin
                        </a>
                        <a href="#"
                            class="inline-flex items-center justify-center rounded-xl border border-white/30 bg-white/10 px-5 py-3 text-sm font-semibold text-white transition hover:bg-white/15">
                            Panduan Portal
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="border-t border-slate-200 bg-white">
        <div class="mx-auto max-w-6xl px-4 py-10">
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div>
                    <div class="text-sm font-extrabold text-slate-900">{{ config('app.name', 'Portal Kampus') }}</div>
                    <div class="mt-1 text-xs text-slate-500">© {{ date('Y') }} • Website resmi layanan akademik
                    </div>
                </div>
                <div class="flex flex-wrap items-center gap-4 text-sm font-semibold text-slate-700">
                    <a href="#pengumuman" class="hover:text-slate-900">Pengumuman</a>
                    <a href="#layanan" class="hover:text-slate-900">Layanan</a>
                    <a href="#profil" class="hover:text-slate-900">Profil</a>
                    <a href="#kontak" class="hover:text-slate-900">Kontak</a>
                </div>
            </div>
        </div>
    </footer>
</body>


</html>
