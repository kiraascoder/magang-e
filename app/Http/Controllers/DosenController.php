<?php

namespace App\Http\Controllers;

use App\Models\JurnalPekan;
use App\Models\Logbook;
use App\Models\Penempatan;
use Illuminate\Http\Request;

class DosenController extends Controller
{
    public function dashboard()
    {
        $dosenId = auth()->id();

        $totalBimbingan = Penempatan::where('id_dosen_mentor', $dosenId)->count();
        $aktif = Penempatan::where('id_dosen_mentor', $dosenId)->where('status', 'aktif')->count();
        $draft = Penempatan::where('id_dosen_mentor', $dosenId)->where('status', 'draft')->count();
        $selesai = Penempatan::where('id_dosen_mentor', $dosenId)->where('status', 'selesai')->count();

        $latest = Penempatan::with(['mahasiswa:id,name,nim', 'instansi:id_instansi,nama_instansi', 'periode:id_periode,nama_periode'])
            ->where('id_dosen_mentor', $dosenId)
            ->orderByDesc('id_penempatan')
            ->limit(5)
            ->get();

        return view('dosen.dashboard', compact('totalBimbingan', 'aktif', 'draft', 'selesai', 'latest'));
    }

    public function mahasiswa(Request $request)
    {
        $dosenId = auth()->id();
        $q = trim((string) $request->query('q', ''));

        $items = Penempatan::with(['mahasiswa:id,name,nim,no_hp', 'instansi:id_instansi,nama_instansi', 'periode:id_periode,nama_periode'])
            ->where('id_dosen_mentor', $dosenId)
            ->when($q !== '', function ($query) use ($q) {
                $query->whereHas('mahasiswa', function ($u) use ($q) {
                    $u->where('name', 'like', "%{$q}%")
                        ->orWhere('nim', 'like', "%{$q}%");
                })->orWhereHas('instansi', function ($i) use ($q) {
                    $i->where('nama_instansi', 'like', "%{$q}%");
                });
            })
            ->orderByDesc('id_penempatan')
            ->paginate(10)
            ->withQueryString();

        return view('dosen.mahasiswa', compact('items', 'q'));
    }

    public function logbook()
    {
        // nanti kita buat tabel logbooks/jurnals -> sekarang placeholder
        return view('dosen.logbook');
    }

    public function laporan()
    {
        // nanti tabel laporan -> sekarang placeholder
        return view('dosen.laporan');
    }

    public function nilai()
    {
        // nanti tabel nilai -> sekarang placeholder
        return view('dosen.nilai');
    }
    private function dosenLogbookQuery()
    {
        return Logbook::with([
            'mahasiswa:id,name,nim',
            'penempatan:id_penempatan,id_dosen_mentor,id_instansi,id_periode',
            'penempatan.instansi:id_instansi,nama_instansi',
            'penempatan.periode:id_periode,nama_periode',
        ])
            ->whereHas('penempatan', function ($q) {
                $q->where('id_dosen_mentor', auth()->id());
            });
    }

    public function logbookIndex(Request $request)
    {
        $q = trim((string) $request->query('q', ''));
        $status = $request->query('status');

        $items = $this->dosenLogbookQuery()
            ->when($status, fn($x) => $x->where('status', $status))
            ->when($q !== '', function ($x) use ($q) {
                $x->whereHas('mahasiswa', function ($u) use ($q) {
                    $u->where('name', 'like', "%{$q}%")
                        ->orWhere('nim', 'like', "%{$q}%");
                });
            })
            ->orderByDesc('tanggal')
            ->paginate(10)
            ->withQueryString();

        return view('dosen.logbook.index', compact('items', 'q', 'status'));
    }

    public function logbookShow(Logbook $logbook)
    {
        $ok = $logbook->penempatan && ($logbook->penempatan->id_dosen_mentor == auth()->id());
        abort_if(!$ok, 403);

        $logbook->load([
            'mahasiswa:id,name,nim',
            'penempatan.instansi:id_instansi,nama_instansi',
            'penempatan.periode:id_periode,nama_periode',
        ]);

        return view('dosen.logbook.show', compact('logbook'));
    }

    public function logbookApprove(Request $request, Logbook $logbook)
    {
        $ok = $logbook->penempatan && ($logbook->penempatan->id_dosen_mentor == auth()->id());
        abort_if(!$ok, 403);
        abort_if($logbook->status !== 'terkirim', 403, 'Hanya logbook terkirim yang bisa disetujui.');

        $data = $request->validate([
            'catatan_mentor' => ['nullable', 'string', 'max:5000'],
        ]);

        $logbook->update([
            'status' => 'disetujui',
            'catatan_mentor' => $data['catatan_mentor'] ?? null,
        ]);

        return back()->with('success', 'Logbook disetujui.');
    }

    public function logbookReject(Request $request, Logbook $logbook)
    {
        $ok = $logbook->penempatan && ($logbook->penempatan->id_dosen_mentor == auth()->id());
        abort_if(!$ok, 403);
        abort_if($logbook->status !== 'terkirim', 403, 'Hanya logbook terkirim yang bisa ditolak.');

        $data = $request->validate([
            'catatan_mentor' => ['required', 'string', 'max:5000'],
        ]);

        $logbook->update([
            'status' => 'ditolak',
            'catatan_mentor' => $data['catatan_mentor'],
        ]);

        return back()->with('success', 'Logbook ditolak.');
    }
    private function dosenJurnalQuery()
    {
        return JurnalPekan::with([
            'mahasiswa:id,name,nim',
            'penempatan.instansi:id_instansi,nama_instansi',
            'penempatan.periode:id_periode,nama_periode',
            'harian'
        ])
            ->whereHas('penempatan', function ($q) {
                $q->where('id_dosen_mentor', auth()->id()); // pastikan id_dosen_mentor = users.id dosen
            });
    }

    public function jurnalIndex(Request $request)
    {
        $q = trim((string)$request->query('q', ''));
        $status = $request->query('status');

        $items = $this->dosenJurnalQuery()
            ->when($status, fn($x) => $x->where('status', $status))
            ->when($q !== '', function ($x) use ($q) {
                $x->whereHas('mahasiswa', function ($u) use ($q) {
                    $u->where('name', 'like', "%{$q}%")
                        ->orWhere('nim', 'like', "%{$q}%");
                });
            })
            ->orderByDesc('pekan_ke')
            ->paginate(10)
            ->withQueryString();

        return view('dosen.jurnal.index', compact('items', 'q', 'status'));
    }

    public function jurnalShow(JurnalPekan $pekan)
    {
        $ok = $pekan->penempatan && ($pekan->penempatan->id_dosen_mentor == auth()->id());
        abort_if(!$ok, 403);

        $pekan->load([
            'harian',
            'mahasiswa:id,name,nim',
            'penempatan.instansi',
            'penempatan.periode',
        ]);

        return view('dosen.jurnal.show', compact('pekan'));
    }

    public function jurnalApprove(Request $request, JurnalPekan $pekan)
    {
        $ok = $pekan->penempatan && ($pekan->penempatan->id_dosen_mentor == auth()->id());
        abort_if(!$ok, 403);
        abort_if($pekan->status !== 'terkirim', 403);

        $data = $request->validate([
            'catatan_mentor' => ['nullable', 'string', 'max:5000'],
        ]);

        $pekan->update([
            'status' => 'disetujui',
            'catatan_mentor' => $data['catatan_mentor'] ?? null,
        ]);

        return back()->with('success', 'Jurnal disetujui.');
    }

    public function jurnalReject(Request $request, JurnalPekan $pekan)
    {
        $ok = $pekan->penempatan && ($pekan->penempatan->id_dosen_mentor == auth()->id());
        abort_if(!$ok, 403);
        abort_if($pekan->status !== 'terkirim', 403);

        $data = $request->validate([
            'catatan_mentor' => ['required', 'string', 'max:5000'],
        ]);

        $pekan->update([
            'status' => 'ditolak',
            'catatan_mentor' => $data['catatan_mentor'],
        ]);

        return back()->with('success', 'Jurnal ditolak.');
    }
    public function laporanAkhirIndex(Request $request)
    {
        $dosenId = auth()->id();
        $q = $request->query('q');

        $items = LaporanAkhir::with(['mahasiswa:id,name,nim', 'penempatan.instansi:id_instansi,nama_instansi', 'penempatan.periode:id_periode,nama_periode'])
            ->whereHas('penempatan', fn($p) => $p->where('id_dosen_mentor', $dosenId))
            ->when($q, function ($query) use ($q) {
                $query->whereHas('mahasiswa', fn($m) => $m->where('name', 'like', "%$q%")->orWhere('nim', 'like', "%$q%"));
            })
            ->orderByDesc('id_laporan_akhir')
            ->paginate(10)
            ->withQueryString();

        return view('dosen.laporan_akhir.index', compact('items', 'q'));
    }

    public function laporanAkhirShow(LaporanAkhir $laporan)
    {
        $dosenId = auth()->id();
        abort_if($laporan->penempatan->id_dosen_mentor !== $dosenId, 403);

        $laporan->load(['mahasiswa', 'penempatan.instansi', 'penempatan.periode']);
        return view('dosen.laporan_akhir.show', compact('laporan'));
    }

    public function laporanAkhirApprove(Request $request, LaporanAkhir $laporan)
    {
        $dosenId = auth()->id();
        abort_if($laporan->penempatan->id_dosen_mentor !== $dosenId, 403);

        $laporan->update([
            'status' => 'disetujui',
            'catatan_mentor' => $request->input('catatan_mentor'),
        ]);

        return back()->with('success', 'Laporan akhir disetujui.');
    }

    public function laporanAkhirReject(Request $request, LaporanAkhir $laporan)
    {
        $dosenId = auth()->id();
        abort_if($laporan->penempatan->id_dosen_mentor !== $dosenId, 403);

        $laporan->update([
            'status' => 'ditolak',
            'catatan_mentor' => $request->input('catatan_mentor'),
        ]);

        return back()->with('success', 'Laporan akhir ditolak.');
    }
}
