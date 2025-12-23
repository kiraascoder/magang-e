<?php

namespace Database\Seeders;

use App\Models\LaporanAkhir;
use App\Models\Penempatan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class LaporanAkhirSeeder extends Seeder
{
    public function run(): void
    {
        Storage::disk('public')->makeDirectory('laporan_akhir');

        $penempatans = Penempatan::whereIn('status', ['draft', 'aktif'])
            ->orderBy('id_penempatan')
            ->get();

        foreach ($penempatans as $p) {
            // 1 laporan per penempatan
            $exists = LaporanAkhir::where('id_penempatan', $p->id_penempatan)->exists();
            if ($exists) continue;

            $filename = 'laporan_akhir_penempatan_' . $p->id_penempatan . '.pdf';
            $path = 'laporan_akhir/' . $filename;

            $content = "DUMMY LAPORAN AKHIR\n\n" .
                "Penempatan: #{$p->id_penempatan}\n" .
                "Mahasiswa ID: {$p->id_mhs}\n" .
                "Instansi ID: {$p->id_instansi}\n" .
                "Periode ID: {$p->id_periode}\n\n" .
                "Catatan: ini file dummy dari seeder.";

            Storage::disk('public')->put($path, $content);

            LaporanAkhir::create([
                'id_penempatan' => $p->id_penempatan,
                'id_mhs' => $p->id_mhs,
                'judul' => 'Laporan Akhir Magang (Dummy) - Penempatan #' . $p->id_penempatan,
                'file_path' => $path,
                'original_name' => $filename,
                'file_size' => Storage::disk('public')->size($path),
                'mime' => 'application/pdf',
                'status' => 'terkirim', // biar dosen bisa review
                'catatan_mentor' => null,
            ]);
        }
    }
}
