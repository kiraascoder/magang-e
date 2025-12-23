<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penempatan extends Model
{
    protected $table = 'penempatans';
    protected $primaryKey = 'id_penempatan';

    protected $fillable = [
        'id_mhs',
        'id_dosen_mentor',
        'id_instansi',
        'id_periode',
        'id_admin',
        'divisi',
        'posisi',
        'lokasi',
        'tgl_mulai',
        'tgl_selesai',
        'status',
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(User::class, 'id_mhs');
    }

    public function mentor()
    {
        return $this->belongsTo(User::class, 'id_dosen_mentor');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'id_admin');
    }

    // Relasi lain (pastikan modelnya ada)
    public function instansi()
    {
        return $this->belongsTo(Instansi::class, 'id_instansi');
    }

    public function periode()
    {
        return $this->belongsTo(Periode::class, 'id_periode');
    }
    public function getRouteKeyName()
    {
        return 'id_penempatan';
    }
    public function laporanAkhir()
    {
        return $this->hasOne(\App\Models\LaporanAkhir::class, 'id_penempatan', 'id_penempatan');
    }
}
