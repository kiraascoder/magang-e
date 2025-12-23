<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Logbook extends Model
{
    protected $table = 'logbooks';
    protected $primaryKey = 'id_logbook';

    protected $fillable = [
        'id_penempatan',
        'id_mhs',
        'tanggal',
        'kegiatan',
        'dokumentasi',
        'status',
        'catatan_mentor',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function getRouteKeyName()
    {
        return 'id_logbook';
    }

    public function penempatan()
    {
        return $this->belongsTo(Penempatan::class, 'id_penempatan', 'id_penempatan');
    }

    public function mahasiswa()
    {
        return $this->belongsTo(User::class, 'id_mhs', 'id');
    }
}
