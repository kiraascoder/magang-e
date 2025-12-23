<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Periode extends Model
{
    protected $table = 'periodes';
    protected $primaryKey = 'id_periode';

    protected $fillable = [
        'nama_periode',
        'tgl_mulai',
        'tgl_selesai',
        'status',
        'keterangan',
    ];

    protected $casts = [
        'tgl_mulai' => 'date',
        'tgl_selesai' => 'date',
    ];

    public function penempatans()
    {
        return $this->hasMany(Penempatan::class, 'id_periode', 'id_periode');
    }
    public function getRouteKeyName()
    {
        return 'id_periode';
    }
}
