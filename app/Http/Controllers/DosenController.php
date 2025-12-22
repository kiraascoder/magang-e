<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DosenController extends Controller
{
    public function dashboard()
    {
        return view('dosen.dashboard');
    }
    public function mahasiswa()
    {
        return view('dosen.mahasiswa');
    }
    public function logbook()
    {
        return view('dosen.logbook');
    }
    public function nilai()
    {
        return view('dosen.nilai');
    }
    public function laporan()
    {
        return view('dosen.laporan');
    }
}
