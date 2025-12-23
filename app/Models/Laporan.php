<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    protected $table = 'laporans';
    protected $primaryKey = 'id_laporan';

    protected $fillable = [
        'id_penempatan',
        'id_mhs',
        'judul',
        'file_path',
        'status', // draft/terkirim/disetujui/ditolak (opsional)
        
        'catatan',
    ];

    public function penempatan()
    {
        return $this->belongsTo(Penempatan::class, 'id_penempatan', 'id_penempatan');
    }

    public function mahasiswa()
    {
        return $this->belongsTo(User::class, 'id_mhs', 'id');
    }
}
