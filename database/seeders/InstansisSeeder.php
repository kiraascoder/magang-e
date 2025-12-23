<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class InstansisSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        $data = [
            ['nama_instansi' => 'PT Saumata Teknosains Global', 'alamat' => 'Parepare', 'kontak' => 'saumata@demo.com', 'status' => 'aktif'],
            ['nama_instansi' => 'Dinas Kominfo Parepare', 'alamat' => 'Kantor Walikota', 'kontak' => '0812-0000-1111', 'status' => 'aktif'],
            ['nama_instansi' => 'Bappeda Parepare', 'alamat' => 'Parepare', 'kontak' => '0812-0000-2222', 'status' => 'nonaktif'],
            ['nama_instansi' => 'PT Mitra Nusantara', 'alamat' => 'Makassar', 'kontak' => 'mitra@demo.com', 'status' => 'aktif'],
            ['nama_instansi' => 'Kantor Inspektorat', 'alamat' => 'Parepare', 'kontak' => '0812-0000-3333', 'status' => 'aktif'],
        ];

        foreach ($data as $row) {
            DB::table('instansis')->updateOrInsert(
                ['nama_instansi' => $row['nama_instansi']],
                [
                    'alamat' => $row['alamat'],
                    'kontak' => $row['kontak'],
                    'status' => $row['status'],
                    'created_at' => $now,
                    'updated_at' => $now,
                ]
            );
        }
    }
}
