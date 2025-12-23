<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'nbm',
        'nim',
        'no_hp',
        'role',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Helper opsional (biar enak dipakai di blade/controller)
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isDosen(): bool
    {
        return $this->role === 'dosen';
    }

    public function isMahasiswa(): bool
    {
        return $this->role === 'mahasiswa';
    }
    public function penempatanMahasiswa()
    {
        return $this->hasMany(Penempatan::class, 'id_mhs', 'id');
    }

    public function penempatanMentor()
    {
        return $this->hasMany(Penempatan::class, 'id_dosen_mentor', 'id');
    }

    public function penempatanAdmin()
    {
        return $this->hasMany(Penempatan::class, 'id_admin', 'id');
    }
}
