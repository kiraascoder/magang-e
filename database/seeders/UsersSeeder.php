<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        // ADMIN
        DB::table('users')->updateOrInsert(
            ['email' => 'admin@demo.com'],
            [
                'name' => 'Admin Sistem',
                'role' => 'admin',
                'email' => 'admin@demo.com',
                'nim' => null,
                'nbm' => null,
                'no_hp' => '081234567890',
                'password' => Hash::make('password123'),
                'created_at' => $now,
                'updated_at' => $now,
            ]
        );

        // DOSEN (NBM)
        $dosens = [
            ['name' => 'Dosen Mentor 1', 'nbm' => 'NBM001', 'email' => 'dosen1@demo.com', 'no_hp' => '081200000001'],
            ['name' => 'Dosen Mentor 2', 'nbm' => 'NBM002', 'email' => 'dosen2@demo.com', 'no_hp' => '081200000002'],
            ['name' => 'Dosen Mentor 3', 'nbm' => 'NBM003', 'email' => 'dosen3@demo.com', 'no_hp' => '081200000003'],
        ];

        foreach ($dosens as $d) {
            DB::table('users')->updateOrInsert(
                ['nbm' => $d['nbm']],
                [
                    'name' => $d['name'],
                    'role' => 'dosen',
                    'email' => $d['email'], // opsional
                    'nim' => null,
                    'nbm' => $d['nbm'],
                    'no_hp' => $d['no_hp'],
                    'password' => Hash::make('password123'),
                    'created_at' => $now,
                    'updated_at' => $now,
                ]
            );
        }

        // MAHASISWA (NIM)
        for ($i = 1; $i <= 10; $i++) {
            $nim = 'MHS' . str_pad((string)$i, 3, '0', STR_PAD_LEFT);

            DB::table('users')->updateOrInsert(
                ['nim' => $nim],
                [
                    'name' => 'Mahasiswa ' . $i,
                    'role' => 'mahasiswa',
                    'email' => "mhs{$i}@demo.com", // opsional
                    'nim' => $nim,
                    'nbm' => null,
                    'no_hp' => '0813000000' . str_pad((string)$i, 2, '0', STR_PAD_LEFT),
                    'password' => Hash::make('password123'),
                    'created_at' => $now,
                    'updated_at' => $now,
                ]
            );
        }
    }
}
