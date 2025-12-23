<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    protected $table = 'nilais';
    protected $primaryKey = 'id_nilai';

    protected $fillable = [
        'id_penempatan',
        'id_mhs',
        'id_dosen',
        'nilai_angka',
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

    public function dosen()
    {
        return $this->belongsTo(User::class, 'id_dosen', 'id');
    }
}
