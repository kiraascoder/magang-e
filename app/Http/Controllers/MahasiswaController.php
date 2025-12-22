<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    public function dashboard()
    {
        return view('mahasiswa.dashboard');
    }
    public function logbook()
    {
        return view('mahasiswa.logbook');
    }
    public function jurnal()
    {
        return view('mahasiswa.jurnal');
    }
    public function laporan()
    {
        return view('mahasiswa.laporan');
    }
    public function nilai()
    {
        return view('mahasiswa.nilai');
    }
    public function profil()
    {
        return view('mahasiswa.profil');
    }
}
