<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PenempatansSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        $adminId = DB::table('users')->where('role', 'admin')->value('id');
        $periodeAktif = DB::table('periodes')->where('status', 'aktif')->first();

        $dosenIds = DB::table('users')->where('role', 'dosen')->pluck('id')->values();
        $instansiIds = DB::table('instansis')->pluck('id_instansi')->values();
        $mhsIds = DB::table('users')->where('role', 'mahasiswa')->orderBy('id')->limit(8)->pluck('id')->values();

        if (!$adminId || !$periodeAktif || $dosenIds->isEmpty() || $instansiIds->isEmpty() || $mhsIds->isEmpty()) {
            // Data master belum lengkap
            return;
        }

        $statusList = ['draft', 'aktif', 'aktif', 'aktif', 'selesai', 'draft', 'aktif', 'batal'];

        foreach ($mhsIds as $idx => $mhsId) {
            $mentorId = $dosenIds[$idx % $dosenIds->count()];
            $instansiId = $instansiIds[$idx % $instansiIds->count()];
            $status = $statusList[$idx] ?? 'draft';

            // aman terhadap unique (id_mhs + id_periode)
            DB::table('penempatans')->updateOrInsert(
                [
                    'id_mhs' => $mhsId,
                    'id_periode' => $periodeAktif->id_periode,
                ],
                [
                    'id_dosen_mentor' => $mentorId,
                    'id_instansi' => $instansiId,
                    'id_admin' => $adminId,
                    'divisi' => 'IT',
                    'posisi' => 'Intern',
                    'lokasi' => 'Parepare',
                    'tgl_mulai' => $periodeAktif->tgl_mulai,
                    'tgl_selesai' => $periodeAktif->tgl_selesai,
                    'status' => $status,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]
            );
        }
    }
}
