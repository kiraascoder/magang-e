<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JurnalPekan extends Model
{
    protected $table = 'jurnal_pekans';
    protected $primaryKey = 'id_jurnal_pekan';

    protected $fillable = [
        'id_penempatan',
        'id_mhs',
        'pekan_ke',
        'tanggal_mulai',
        'tanggal_selesai',
        'total_menit',
        'status',
        'catatan_mentor'
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
    ];

    public function penempatan()
    {
        return $this->belongsTo(Penempatan::class, 'id_penempatan', 'id_penempatan');
    }

    public function mahasiswa()
    {
        return $this->belongsTo(User::class, 'id_mhs', 'id');
    }

    public function harian()
    {
        return $this->hasMany(JurnalHarian::class, 'id_jurnal_pekan', 'id_jurnal_pekan')
            ->orderBy('tanggal');
    }
}
