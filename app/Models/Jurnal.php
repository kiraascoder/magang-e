<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jurnal extends Model
{
    protected $table = 'jurnals';
    protected $primaryKey = 'id_jurnal';

    protected $fillable = [
        'id_penempatan',
        'id_mhs',
        'tanggal',
        'judul',
        'isi',
    ];

    protected $casts = [
        'tanggal' => 'date',
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
