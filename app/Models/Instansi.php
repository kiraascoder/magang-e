<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Instansi extends Model
{
    protected $table = 'instansis';
    protected $primaryKey = 'id_instansi';

    protected $fillable = [
        'nama_instansi',
        'alamat',        
        'kontak',
        'status',
    ];

    public function penempatans()
    {
        return $this->hasMany(Penempatan::class, 'id_instansi', 'id_instansi');
    }
    public function getRouteKeyName()
    {
        return 'id_instansi';
    }
}
