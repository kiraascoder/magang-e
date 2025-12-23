<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JurnalHarian extends Model
{
    protected $table = 'jurnal_harians';
    protected $primaryKey = 'id_jurnal_harian';

    protected $fillable = [
        'id_jurnal_pekan',
        'tanggal',
        'jam_datang',
        'jam_pulang',
        'jumlah_menit',
        'kegiatan'
    ];

    protected $casts = [
        'tanggal' => 'date',
        'jam_datang' => 'datetime:H:i',
        'jam_pulang' => 'datetime:H:i',
    ];

    public function pekan()
    {
        return $this->belongsTo(JurnalPekan::class, 'id_jurnal_pekan', 'id_jurnal_pekan');
    }
}
