<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaporanAkhir extends Model
{
    protected $table = 'laporan_akhirs';
    protected $primaryKey = 'id_laporan_akhir';

    protected $fillable = [
        'id_penempatan',
        'id_mhs',
        'judul',
        'file_path',
        'original_name',
        'file_size',
        'mime',
        'status',
        'catatan_mentor',
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
