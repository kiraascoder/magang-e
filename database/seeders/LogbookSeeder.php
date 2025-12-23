<?php

namespace Database\Seeders;

use App\Models\Logbook;
use App\Models\Penempatan;
use Illuminate\Database\Seeder;

class LogbookSeeder extends Seeder
{
    public function run(): void
    {
        $penempatans = Penempatan::all();

        foreach ($penempatans as $p) {
            $dates = [
                now()->subDays(4)->toDateString(),
                now()->subDays(3)->toDateString(),
                now()->subDays(2)->toDateString(),
                now()->subDays(1)->toDateString(),
                now()->toDateString(),
            ];

            $statuses = ['draft', 'terkirim', 'disetujui', 'ditolak', 'terkirim'];

            foreach ($dates as $i => $tgl) {
                Logbook::updateOrCreate(
                    [
                        'id_penempatan' => $p->id_penempatan,
                        'id_mhs' => $p->id_mhs,
                        'tanggal' => $tgl,
                    ],
                    [
                        'kegiatan' => 'Aktivitas harian ke-' . ($i + 1) . ': Membuat fitur logbook, testing, dan perbaikan bug.',
                        'dokumentasi' => null,
                        'status' => $statuses[$i],
                        'catatan_mentor' => $statuses[$i] === 'ditolak'
                            ? 'Tolong lengkapi detail kegiatan dan sertakan bukti dokumentasi.'
                            : ($statuses[$i] === 'disetujui' ? 'Bagus, lanjutkan.' : null),
                    ]
                );
            }
        }
    }
}
