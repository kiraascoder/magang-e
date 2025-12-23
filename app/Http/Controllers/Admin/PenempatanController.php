<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Penempatan;
use App\Models\User;
use App\Models\Instansi;
use App\Models\Periode;
use Illuminate\Http\Request;

class PenempatanController extends Controller
{
    public function index()
    {
        $items = Penempatan::with(['mahasiswa:id,name,nim', 'mentor:id,name,nbm', 'instansi', 'periode'])
            ->latest('id_penempatan')
            ->paginate(10);

        return view('admin.penempatan', compact('items'));
    }

    public function create()
    {
        $mahasiswas = User::where('role', 'mahasiswa')->select('id', 'name', 'nim')->orderBy('name')->get();
        $dosens     = User::where('role', 'dosen')->select('id', 'name', 'nbm')->orderBy('name')->get();
        $instansis  = Instansi::orderBy('nama_instansi')->get();
        $periodes   = Periode::orderByDesc('id_periode')->get();

        return view('admin.penempatan.create', compact('mahasiswas', 'dosens', 'instansis', 'periodes'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id_mhs' => ['required', 'integer', 'exists:users,id'],
            'id_dosen_mentor' => ['required', 'integer', 'exists:users,id'],
            'id_instansi' => ['required', 'integer', 'exists:instansis,id_instansi'],
            'id_periode' => ['required', 'integer', 'exists:periodes,id_periode'],
            'divisi' => ['nullable', 'string', 'max:100'],
            'posisi' => ['nullable', 'string', 'max:100'],
            'lokasi' => ['nullable', 'string', 'max:150'],
            'tgl_mulai' => ['nullable', 'date'],
            'tgl_selesai' => ['nullable', 'date', 'after_or_equal:tgl_mulai'],
            'status' => ['required', 'in:draft,aktif,selesai,batal'],
        ]);

        // Enforce role (penting!)
        $mhs = User::select('id', 'role')->findOrFail($data['id_mhs']);
        $dsn = User::select('id', 'role')->findOrFail($data['id_dosen_mentor']);

        if ($mhs->role !== 'mahasiswa') {
            return back()->withErrors(['id_mhs' => 'User ini bukan Mahasiswa.'])->withInput();
        }
        if ($dsn->role !== 'dosen') {
            return back()->withErrors(['id_dosen_mentor' => 'User ini bukan Dosen.'])->withInput();
        }

        $data['id_admin'] = auth()->id();

        Penempatan::create($data);

        return redirect()->route('admin.penempatan')->with('success', 'Penempatan berhasil dibuat.');
    }

    public function edit(Penempatan $penempatan)
    {
        $penempatan->load(['mahasiswa:id,name,nim', 'mentor:id,name,nbm']);

        $mahasiswas = User::where('role', 'mahasiswa')->select('id', 'name', 'nim')->orderBy('name')->get();
        $dosens     = User::where('role', 'dosen')->select('id', 'name', 'nbm')->orderBy('name')->get();
        $instansis  = Instansi::orderBy('nama_instansi')->get();
        $periodes   = Periode::orderByDesc('id_periode')->get();

        return view('admin.penempatan.edit', compact('penempatan', 'mahasiswas', 'dosens', 'instansis', 'periodes'));
    }

    public function update(Request $request, Penempatan $penempatan)
    {
        $data = $request->validate([
            'id_mhs' => ['required', 'integer', 'exists:users,id'],
            'id_dosen_mentor' => ['required', 'integer', 'exists:users,id'],
            'id_instansi' => ['required', 'integer', 'exists:instansis,id_instansi'],
            'id_periode' => ['required', 'integer', 'exists:periodes,id_periode'],
            'divisi' => ['nullable', 'string', 'max:100'],
            'posisi' => ['nullable', 'string', 'max:100'],
            'lokasi' => ['nullable', 'string', 'max:150'],
            'tgl_mulai' => ['nullable', 'date'],
            'tgl_selesai' => ['nullable', 'date', 'after_or_equal:tgl_mulai'],
            'status' => ['required', 'in:draft,aktif,selesai,batal'],
        ]);

        // enforce role
        $mhs = User::select('id', 'role')->findOrFail($data['id_mhs']);
        $dsn = User::select('id', 'role')->findOrFail($data['id_dosen_mentor']);

        if ($mhs->role !== 'mahasiswa') {
            return back()->withErrors(['id_mhs' => 'User ini bukan Mahasiswa.'])->withInput();
        }
        if ($dsn->role !== 'dosen') {
            return back()->withErrors(['id_dosen_mentor' => 'User ini bukan Dosen.'])->withInput();
        }

        $penempatan->update($data);

        return redirect()->route('admin.penempatan')->with('success', 'Penempatan berhasil diupdate.');
    }

    public function destroy(Penempatan $penempatan)
    {
        $penempatan->delete();
        return back()->with('success', 'Penempatan berhasil dihapus.');
    }
}
