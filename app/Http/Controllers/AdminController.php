<?php

namespace App\Http\Controllers;

use App\Models\Instansi;
use App\Models\Penempatan;
use App\Models\Periode;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalMahasiswa = User::where('role', 'mahasiswa')->count();
        $totalDosen     = User::where('role', 'dosen')->count();
        $totalInstansi  = Instansi::count();
        $aktif          = Penempatan::where('status', 'aktif')->count();

        $ringkas = [
            'draft' => Penempatan::where('status', 'draft')->count(),
            'aktif' => Penempatan::where('status', 'aktif')->count(),
            'selesai' => Penempatan::where('status', 'selesai')->count(),
            'batal' => Penempatan::where('status', 'batal')->count(),
        ];

        $penempatanTerbaru = Penempatan::with(['mahasiswa:id,name,nim', 'mentor:id,name,nbm', 'instansi', 'periode'])
            ->latest('id_penempatan')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalMahasiswa',
            'totalDosen',
            'totalInstansi',
            'aktif',
            'ringkas',
            'penempatanTerbaru'
        ));
    }

    public function users(Request $request)
    {
        $q    = trim((string) $request->query('q', ''));
        $role = (string) $request->query('role', ''); // admin|dosen|mahasiswa|''

        // Query utama (list users)
        $users = User::query()
            ->when($role !== '', function ($query) use ($role) {
                $query->where('role', $role);
            })
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($w) use ($q) {
                    $w->where('name', 'like', "%{$q}%")
                        ->orWhere('email', 'like', "%{$q}%")
                        ->orWhere('nim', 'like', "%{$q}%")
                        ->orWhere('nbm', 'like', "%{$q}%")
                        ->orWhere('no_hp', 'like', "%{$q}%");
                });
            })
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        // Statistik
        $countAll   = User::count();
        $countMhs   = User::where('role', 'mahasiswa')->count();
        $countDosen = User::where('role', 'dosen')->count();
        $countAdmin = User::where('role', 'admin')->count();

        return view('admin.users', compact(
            'users',
            'q',
            'role',
            'countAll',
            'countMhs',
            'countDosen',
            'countAdmin'
        ));
    }

    public function usersCreate()
    {
        return view('admin.users_create');
    }

    public function usersStore(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'role' => ['required', Rule::in(['admin', 'dosen', 'mahasiswa'])],
            'email' => ['nullable', 'email', 'max:100', 'unique:users,email'],
            'nim' => ['nullable', 'string', 'max:30', 'unique:users,nim'],
            'nbm' => ['nullable', 'string', 'max:30', 'unique:users,nbm'],
            'no_hp' => ['nullable', 'string', 'max:20'],
            'password' => ['required', 'string', 'min:6'],
        ]);

        // enforce identifier sesuai role
        if ($data['role'] === 'admin' && empty($data['email'])) {
            return back()->withErrors(['email' => 'Admin wajib menggunakan Email.'])->withInput();
        }
        if ($data['role'] === 'dosen' && empty($data['nbm'])) {
            return back()->withErrors(['nbm' => 'Dosen wajib menggunakan NBM.'])->withInput();
        }
        if ($data['role'] === 'mahasiswa' && empty($data['nim'])) {
            return back()->withErrors(['nim' => 'Mahasiswa wajib menggunakan NIM.'])->withInput();
        }

        // bersihkan field yang tidak dipakai biar rapi
        if ($data['role'] !== 'admin') $data['email'] = $data['email'] ?? null; // boleh ada, tapi opsional
        if ($data['role'] !== 'dosen') $data['nbm'] = null;
        if ($data['role'] !== 'mahasiswa') $data['nim'] = null;

        $data['password'] = Hash::make($data['password']);

        User::create($data);

        return redirect()->route('admin.users')->with('success', 'User berhasil ditambahkan.');
    }

    public function usersEdit(User $user)
    {
        return view('admin.users_edit', compact('user'));
    }

    public function usersUpdate(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'role' => ['required', Rule::in(['admin', 'dosen', 'mahasiswa'])],
            'email' => ['nullable', 'email', 'max:100', Rule::unique('users', 'email')->ignore($user->id)],
            'nim' => ['nullable', 'string', 'max:30', Rule::unique('users', 'nim')->ignore($user->id)],
            'nbm' => ['nullable', 'string', 'max:30', Rule::unique('users', 'nbm')->ignore($user->id)],
            'no_hp' => ['nullable', 'string', 'max:20'],
            'password' => ['nullable', 'string', 'min:6'],
        ]);

        // enforce identifier sesuai role
        if ($data['role'] === 'admin' && empty($data['email'])) {
            return back()->withErrors(['email' => 'Admin wajib menggunakan Email.'])->withInput();
        }
        if ($data['role'] === 'dosen' && empty($data['nbm'])) {
            return back()->withErrors(['nbm' => 'Dosen wajib menggunakan NBM.'])->withInput();
        }
        if ($data['role'] === 'mahasiswa' && empty($data['nim'])) {
            return back()->withErrors(['nim' => 'Mahasiswa wajib menggunakan NIM.'])->withInput();
        }

        // rapikan: kosongkan field yang tidak relevan
        if ($data['role'] !== 'dosen') $data['nbm'] = null;
        if ($data['role'] !== 'mahasiswa') $data['nim'] = null;

        // password optional
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);

        return redirect()->route('admin.users')->with('success', 'User berhasil diupdate.');
    }

    public function usersDestroy(User $user)
    {
        // cegah hapus diri sendiri
        if (auth()->id() === $user->id) {
            return back()->withErrors(['delete' => 'Tidak bisa menghapus akun yang sedang login.']);
        }

        $user->delete();

        return back()->with('success', 'User berhasil dihapus.');
    }
    public function instansi(Request $request)
    {
        $q = trim((string) $request->query('q', ''));

        $instansis = Instansi::query()
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($w) use ($q) {
                    $w->where('nama_instansi', 'like', "%{$q}%")
                        ->orWhere('alamat', 'like', "%{$q}%")
                        ->orWhere('kontak', 'like', "%{$q}%");
                });
            })
            ->orderByDesc('id_instansi')
            ->paginate(10)
            ->withQueryString();

        $countAll = Instansi::count();
        $countAktif = Instansi::where('status', 'aktif')->count();
        $countNonAktif = Instansi::where('status', 'nonaktif')->count();

        return view('admin.instansi', compact('instansis', 'q', 'countAll', 'countAktif', 'countNonAktif'));
    }

    public function instansiCreate()
    {
        return view('admin.instansi_create');
    }

    public function instansiStore(Request $request)
    {
        $data = $request->validate([
            'nama_instansi' => ['required', 'string', 'max:150'],
            'alamat'        => ['nullable', 'string', 'max:255'],
            'kontak'        => ['nullable', 'string', 'max:100'],
            'status'        => ['required', Rule::in(['aktif', 'nonaktif'])],
        ]);

        Instansi::create($data);

        return redirect()->route('admin.instansi')->with('success', 'Instansi berhasil ditambahkan.');
    }

    public function instansiEdit(Instansi $instansi)
    {
        return view('admin.instansi_edit', compact('instansi'));
    }

    public function instansiUpdate(Request $request, Instansi $instansi)
    {
        $data = $request->validate([
            'nama_instansi' => ['required', 'string', 'max:150'],
            'alamat'        => ['nullable', 'string', 'max:255'],
            'kontak'        => ['nullable', 'string', 'max:100'],
            'status'        => ['required', Rule::in(['aktif', 'nonaktif'])],
        ]);

        $instansi->update($data);

        return redirect()->route('admin.instansi')->with('success', 'Instansi berhasil diupdate.');
    }

    public function instansiDestroy(Instansi $instansi)
    {
        // jika instansi dipakai penempatan, delete akan gagal kalau FK restrict
        $instansi->delete();

        return back()->with('success', 'Instansi berhasil dihapus.');
    }
    public function periode(Request $request)
    {
        $q = trim((string) $request->query('q', ''));
        $status = (string) $request->query('status', '');

        $periodes = Periode::query()
            ->when($status !== '', fn($query) => $query->where('status', $status))
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($w) use ($q) {
                    $w->where('nama_periode', 'like', "%{$q}%")
                        ->orWhere('keterangan', 'like', "%{$q}%");
                });
            })
            ->orderByDesc('id_periode')
            ->paginate(10)
            ->withQueryString();

        $countAll     = Periode::count();
        $countAktif   = Periode::where('status', 'aktif')->count();
        $countSelesai = Periode::where('status', 'selesai')->count();

        return view('admin.periode', compact(
            'periodes',
            'q',
            'status',
            'countAll',
            'countAktif',
            'countSelesai'
        ));
    }

    public function periodeCreate()
    {
        return view('admin.periode_create');
    }

    public function periodeStore(Request $request)
    {
        $data = $request->validate([
            'nama_periode' => ['required', 'string', 'max:150'],
            'tgl_mulai'    => ['required', 'date'],
            'tgl_selesai'  => ['required', 'date', 'after_or_equal:tgl_mulai'],
            'status'       => ['required', Rule::in(['aktif', 'selesai', 'nonaktif'])],
            'keterangan'   => ['nullable', 'string', 'max:255'],
        ]);

        Periode::create($data);

        return redirect()->route('admin.periode')->with('success', 'Periode berhasil ditambahkan.');
    }

    public function periodeEdit(Periode $periode)
    {
        return view('admin.periode_edit', compact('periode'));
    }

    public function periodeUpdate(Request $request, Periode $periode)
    {
        $data = $request->validate([
            'nama_periode' => ['required', 'string', 'max:150'],
            'tgl_mulai'    => ['required', 'date'],
            'tgl_selesai'  => ['required', 'date', 'after_or_equal:tgl_mulai'],
            'status'       => ['required', Rule::in(['aktif', 'selesai', 'nonaktif'])],
            'keterangan'   => ['nullable', 'string', 'max:255'],
        ]);

        $periode->update($data);

        return redirect()->route('admin.periode')->with('success', 'Periode berhasil diupdate.');
    }

    public function periodeDestroy(Periode $periode)
    {
        $periode->delete();
        return back()->with('success', 'Periode berhasil dihapus.');
    }
    public function penempatan(Request $request)
    {
        $q = trim((string) $request->query('q', ''));
        $status = (string) $request->query('status', '');
        $periode = (string) $request->query('periode', '');

        $items = Penempatan::with([
            'mahasiswa:id,name,nim',
            'mentor:id,name,nbm',
            'instansi:id_instansi,nama_instansi',
            'periode:id_periode,nama_periode'
        ])
            ->when($status !== '', fn($qq) => $qq->where('status', $status))
            ->when($periode !== '', fn($qq) => $qq->where('id_periode', $periode))
            ->when($q !== '', function ($qq) use ($q) {
                $qq->whereHas('mahasiswa', fn($u) => $u->where('name', 'like', "%$q%")->orWhere('nim', 'like', "%$q%"))
                    ->orWhereHas('mentor', fn($u) => $u->where('name', 'like', "%$q%")->orWhere('nbm', 'like', "%$q%"))
                    ->orWhereHas('instansi', fn($i) => $i->where('nama_instansi', 'like', "%$q%"));
            })
            ->orderByDesc('id_penempatan')
            ->paginate(10)
            ->withQueryString();

        $periodes = Periode::orderByDesc('id_periode')->get(['id_periode', 'nama_periode']);

        return view('admin.penempatan', compact('items', 'q', 'status', 'periode', 'periodes'));
    }

    public function penempatanCreate()
    {
        $mahasiswas = User::where('role', 'mahasiswa')->orderBy('name')->get(['id', 'name', 'nim']);
        $dosens = User::where('role', 'dosen')->orderBy('name')->get(['id', 'name', 'nbm']);
        $instansis = Instansi::orderBy('nama_instansi')->get(['id_instansi', 'nama_instansi']);
        $periodes = Periode::orderByDesc('id_periode')->get(['id_periode', 'nama_periode', 'tgl_mulai', 'tgl_selesai']);

        return view('admin.penempatan_create', compact('mahasiswas', 'dosens', 'instansis', 'periodes'));
    }

    public function penempatanStore(Request $request)
    {
        $data = $request->validate([
            'id_mhs'          => ['required', 'exists:users,id'],
            'id_dosen_mentor' => ['nullable', 'exists:users,id'],
            'id_instansi'     => ['nullable', 'exists:instansis,id_instansi'],
            'id_periode'      => ['required', 'exists:periodes,id_periode'],

            'divisi'          => ['nullable', 'string', 'max:100'],
            'posisi'          => ['nullable', 'string', 'max:100'],
            'lokasi'          => ['nullable', 'string', 'max:150'],
            'tgl_mulai'       => ['nullable', 'date'],
            'tgl_selesai'     => ['nullable', 'date', 'after_or_equal:tgl_mulai'],
            'status'          => ['required', Rule::in(['draft', 'aktif', 'selesai', 'batal'])],
        ]);

        // enforce role (biar ga salah pilih)
        if (User::find($data['id_mhs'])->role !== 'mahasiswa') {
            return back()->withErrors(['id_mhs' => 'User yang dipilih bukan mahasiswa.'])->withInput();
        }
        if (!empty($data['id_dosen_mentor']) && User::find($data['id_dosen_mentor'])->role !== 'dosen') {
            return back()->withErrors(['id_dosen_mentor' => 'User yang dipilih bukan dosen.'])->withInput();
        }

        // unique mhs+periode (kalau belum ada)
        $exists = Penempatan::where('id_mhs', $data['id_mhs'])
            ->where('id_periode', $data['id_periode'])
            ->exists();

        if ($exists) {
            return back()->withErrors(['id_periode' => 'Mahasiswa ini sudah punya penempatan pada periode tersebut.'])->withInput();
        }

        $data['id_admin'] = auth()->id();

        Penempatan::create($data);

        return redirect()->route('admin.penempatan')->with('success', 'Penempatan berhasil ditambahkan.');
    }

    public function penempatanEdit(Penempatan $penempatan)
    {
        $penempatan->load(['mahasiswa:id,name,nim', 'mentor:id,name,nbm', 'instansi', 'periode']);

        $mahasiswas = User::where('role', 'mahasiswa')->orderBy('name')->get(['id', 'name', 'nim']);
        $dosens = User::where('role', 'dosen')->orderBy('name')->get(['id', 'name', 'nbm']);
        $instansis = Instansi::orderBy('nama_instansi')->get(['id_instansi', 'nama_instansi']);
        $periodes = Periode::orderByDesc('id_periode')->get(['id_periode', 'nama_periode', 'tgl_mulai', 'tgl_selesai']);

        return view('admin.penempatan_edit', compact('penempatan', 'mahasiswas', 'dosens', 'instansis', 'periodes'));
    }

    public function penempatanUpdate(Request $request, Penempatan $penempatan)
    {
        $data = $request->validate([
            'id_mhs'          => ['required', 'exists:users,id'],
            'id_dosen_mentor' => ['nullable', 'exists:users,id'],
            'id_instansi'     => ['nullable', 'exists:instansis,id_instansi'],
            'id_periode'      => ['required', 'exists:periodes,id_periode'],

            'divisi'          => ['nullable', 'string', 'max:100'],
            'posisi'          => ['nullable', 'string', 'max:100'],
            'lokasi'          => ['nullable', 'string', 'max:150'],
            'tgl_mulai'       => ['nullable', 'date'],
            'tgl_selesai'     => ['nullable', 'date', 'after_or_equal:tgl_mulai'],
            'status'          => ['required', Rule::in(['draft', 'aktif', 'selesai', 'batal'])],
        ]);

        if (User::find($data['id_mhs'])->role !== 'mahasiswa') {
            return back()->withErrors(['id_mhs' => 'User yang dipilih bukan mahasiswa.'])->withInput();
        }
        if (!empty($data['id_dosen_mentor']) && User::find($data['id_dosen_mentor'])->role !== 'dosen') {
            return back()->withErrors(['id_dosen_mentor' => 'User yang dipilih bukan dosen.'])->withInput();
        }

        // cek unique mhs+periode, ignore current
        $exists = Penempatan::where('id_mhs', $data['id_mhs'])
            ->where('id_periode', $data['id_periode'])
            ->where('id_penempatan', '!=', $penempatan->id_penempatan)
            ->exists();

        if ($exists) {
            return back()->withErrors(['id_periode' => 'Mahasiswa ini sudah punya penempatan pada periode tersebut.'])->withInput();
        }

        $penempatan->update($data);

        return redirect()->route('admin.penempatan')->with('success', 'Penempatan berhasil diupdate.');
    }

    public function penempatanDestroy(Penempatan $penempatan)
    {
        $penempatan->delete();
        return back()->with('success', 'Penempatan berhasil dihapus.');
    }
}
