<?php

namespace Database\Seeders;

use App\Models\JurnalPekan;
use App\Models\JurnalHarian;
use App\Models\Penempatan;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class JurnalSeeder extends Seeder
{
    public function run(): void
    {
        $penempatans = Penempatan::whereIn('status', ['draft','aktif'])->get();

        foreach ($penempatans as $p) {

            // cari hari Senin terdekat dari tgl_mulai penempatan
            $start = $p->tgl_mulai ? Carbon::parse($p->tgl_mulai) : now();
            $start = $start->copy()->startOfWeek(Carbon::MONDAY);

            // buat header pekan
            $pekan = JurnalPekan::updateOrCreate(
                [
                    'id_penempatan' => $p->id_penempatan,
                    'pekan_ke' => 1,
                ],
                [
                    'id_mhs' => $p->id_mhs,
                    'tanggal_mulai' => $start->toDateString(),
                    'tanggal_selesai' => $start->copy()->addDays(5)->toDateString(), // Senin-Sabtu
                    'total_menit' => 0,
                    'status' => 'terkirim', // biar dosen bisa review langsung
                    'catatan_mentor' => null,
                ]
            );

            // template jam (contoh)
            $jamDatang = '08:00';
            $jamPulang = '16:00'; // 8 jam

            $total = 0;

            // isi 6 hari (Senin-Sabtu)
            for ($i = 0; $i < 6; $i++) {
                $tgl = $start->copy()->addDays($i)->toDateString();

                // variasi kegiatan
                $kegiatan = match ($i) {
                    0 => 'Orientasi & pengenalan instansi, koordinasi mentor, setup tools kerja.',
                    1 => 'Mengerjakan modul jurnal/logbook, validasi input, dan perbaikan UI.',
                    2 => 'Implementasi relasi model & query, testing dan debugging.',
                    3 => 'Review hasil kerja, perbaikan bug, dan dokumentasi.',
                    4 => 'Pengujian fitur, penyesuaian sesuai arahan mentor, serta refactor kode.',
                    default => 'Rekap mingguan, persiapan laporan, dan sinkronisasi progress.',
                };

                $menit = $this->hitungMenit($jamDatang, $jamPulang);
                $total += $menit;

                JurnalHarian::updateOrCreate(
                    [
                        'id_jurnal_pekan' => $pekan->id_jurnal_pekan,
                        'tanggal' => $tgl,
                    ],
                    [
                        'jam_datang' => $jamDatang,
                        'jam_pulang' => $jamPulang,
                        'jumlah_menit' => $menit,
                        'kegiatan' => $kegiatan,
                    ]
                );
            }

            // update total menit pekan
            $pekan->update([
                'total_menit' => $total,
            ]);
        }
    }

    private function hitungMenit(?string $datang, ?string $pulang): int
    {
        if (!$datang || !$pulang) return 0;

        $start = Carbon::createFromFormat('H:i', $datang);
        $end   = Carbon::createFromFormat('H:i', $pulang);

        $diff = $end->diffInMinutes($start, false);
        return $diff > 0 ? $diff : 0;
    }
}
