<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }
    public function users()
    {
        return view('admin.users');
    }
    public function instansi()
    {
        return view('admin.instansi');
    }
    public function periode()
    {
        return view('admin.periode');
    }
    public function penempatan()
    {
        return view('admin.penempatan');
    }
    
}
