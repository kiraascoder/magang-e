<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PeriodesSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        $rows = [
            [
                'nama_periode' => 'Periode Magang 2025 (Genap)',
                'tgl_mulai' => '2025-02-01',
                'tgl_selesai' => '2025-06-30',
                'status' => 'selesai',
                'keterangan' => 'Periode genap tahun 2025',
            ],
            [
                'nama_periode' => 'Periode Magang 2025 (Ganjil)',
                'tgl_mulai' => '2025-08-01',
                'tgl_selesai' => '2025-12-31',
                'status' => 'aktif',
                'keterangan' => 'Periode ganjil tahun 2025',
            ],
            [
                'nama_periode' => 'Periode Magang 2026 (Genap)',
                'tgl_mulai' => '2026-02-01',
                'tgl_selesai' => '2026-06-30',
                'status' => 'nonaktif',
                'keterangan' => 'Draft periode berikutnya',
            ],
        ];

        foreach ($rows as $r) {
            DB::table('periodes')->updateOrInsert(
                ['nama_periode' => $r['nama_periode']],
                [
                    'tgl_mulai' => $r['tgl_mulai'],
                    'tgl_selesai' => $r['tgl_selesai'],
                    'status' => $r['status'],
                    'keterangan' => $r['keterangan'],
                    'created_at' => $now,
                    'updated_at' => $now,
                ]
            );
        }
    }
}
