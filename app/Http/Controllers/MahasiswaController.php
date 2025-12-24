<?php

namespace App\Http\Controllers;

use App\Models\JurnalHarian;
use App\Models\JurnalPekan;
use App\Models\LaporanAkhir;
use App\Models\Logbook;
use App\Models\Penempatan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MahasiswaController extends Controller
{
    public function dashboard()
    {
        $mhsId = auth()->id();

        $penempatanAktif = Penempatan::with([
            'mentor:id,name,nbm',
            'instansi:id_instansi,nama_instansi',
            'periode:id_periode,nama_periode',
        ])
            ->where('id_mhs', $mhsId)
            ->whereIn('status', ['aktif', 'draft'])
            ->orderByDesc('id_penempatan')
            ->first();

        $riwayat = Penempatan::with([
            'mentor:id,name,nbm',
            'instansi:id_instansi,nama_instansi',
            'periode:id_periode,nama_periode',
        ])
            ->where('id_mhs', $mhsId)
            ->orderByDesc('id_penempatan')
            ->limit(10)
            ->get();

        $total = Penempatan::where('id_mhs', $mhsId)->count();
        $aktif = Penempatan::where('id_mhs', $mhsId)->where('status', 'aktif')->count();
        $selesai = Penempatan::where('id_mhs', $mhsId)->where('status', 'selesai')->count();

        return view('mahasiswa.dashboard', compact('penempatanAktif', 'riwayat', 'total', 'aktif', 'selesai'));
    }

    public function profil()
    {
        $user = auth()->user();
        return view('mahasiswa.profil', compact('user'));
    }
    private function currentPenempatanOrFail(): Penempatan
    {
        $mhsId = auth()->id();

        $penempatan = Penempatan::where('id_mhs', $mhsId)
            ->whereIn('status', ['draft', 'aktif'])
            ->orderByDesc('id_penempatan')
            ->first();

        abort_if(!$penempatan, 403, 'Kamu belum punya penempatan aktif/draft. Hubungi admin.');
        return $penempatan;
    }

    public function logbookIndex(Request $request)
    {
        $mhsId = auth()->id();
        $status = $request->query('status');

        $items = Logbook::where('id_mhs', $mhsId)
            ->when($status, fn($q) => $q->where('status', $status))
            ->orderByDesc('tanggal')
            ->paginate(10)
            ->withQueryString();

        return view('mahasiswa.logbook.index', compact('items', 'status'));
    }

    public function logbookCreate()
    {
        $penempatan = $this->currentPenempatanOrFail();
        return view('mahasiswa.logbook.create', compact('penempatan'));
    }

    public function logbookStore(Request $request)
    {
        $penempatan = $this->currentPenempatanOrFail();

        $data = $request->validate([
            'tanggal' => ['required', 'date'],
            'kegiatan' => ['required', 'string', 'max:5000'],
            'dokumentasi' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
        ]);

        $path = null;
        if ($request->hasFile('dokumentasi')) {
            $path = $request->file('dokumentasi')->store('logbooks', 'public');
        }

        Logbook::create([
            'id_penempatan' => $penempatan->id_penempatan,
            'id_mhs' => auth()->id(),
            'tanggal' => $data['tanggal'],
            'kegiatan' => $data['kegiatan'],
            'dokumentasi' => $path,
            'status' => 'draft',
            'catatan_mentor' => null,
        ]);

        return redirect()->route('mahasiswa.logbook')->with('success', 'Logbook berhasil dibuat.');
    }

    public function logbookEdit(Logbook $logbook)
    {
        abort_if($logbook->id_mhs !== auth()->id(), 403);
        abort_if(!in_array($logbook->status, ['draft', 'ditolak']), 403, 'Logbook tidak bisa diedit.');

        return view('mahasiswa.logbook.edit', compact('logbook'));
    }

    public function logbookUpdate(Request $request, Logbook $logbook)
    {
        abort_if($logbook->id_mhs !== auth()->id(), 403);
        abort_if(!in_array($logbook->status, ['draft', 'ditolak']), 403, 'Logbook tidak bisa diedit.');

        $data = $request->validate([
            'tanggal' => ['required', 'date'],
            'kegiatan' => ['required', 'string', 'max:5000'],
            'dokumentasi' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
            'hapus_dokumentasi' => ['nullable', 'boolean'],
        ]);

        if (($data['hapus_dokumentasi'] ?? false) && $logbook->dokumentasi) {
            Storage::disk('public')->delete($logbook->dokumentasi);
            $logbook->dokumentasi = null;
        }

        if ($request->hasFile('dokumentasi')) {
            if ($logbook->dokumentasi) {
                Storage::disk('public')->delete($logbook->dokumentasi);
            }
            $logbook->dokumentasi = $request->file('dokumentasi')->store('logbooks', 'public');
        }

        $logbook->tanggal = $data['tanggal'];
        $logbook->kegiatan = $data['kegiatan'];

        // kalau sebelumnya ditolak, setelah edit kembali jadi draft
        if ($logbook->status === 'ditolak') {
            $logbook->status = 'draft';
        }

        $logbook->save();

        return redirect()->route('mahasiswa.logbook')->with('success', 'Logbook berhasil diupdate.');
    }

    public function logbookDestroy(Logbook $logbook)
    {
        abort_if($logbook->id_mhs !== auth()->id(), 403);
        abort_if($logbook->status === 'disetujui', 403, 'Logbook disetujui tidak boleh dihapus.');

        if ($logbook->dokumentasi) {
            Storage::disk('public')->delete($logbook->dokumentasi);
        }

        $logbook->delete();

        return back()->with('success', 'Logbook berhasil dihapus.');
    }

    public function logbookSubmit(Logbook $logbook)
    {
        abort_if($logbook->id_mhs !== auth()->id(), 403);
        abort_if($logbook->status !== 'draft', 403, 'Hanya logbook draft yang bisa dikirim.');

        $logbook->update(['status' => 'terkirim']);

        return back()->with('success', 'Logbook berhasil dikirim ke mentor.');
    }
    private function menitKeText(int $menit): string
    {
        $jam = intdiv($menit, 60);
        $sis = $menit % 60;
        return "{$jam} Jam {$sis} Menit";
    }

    private function hitungMenit(?string $datang, ?string $pulang): int
    {
        if (!$datang || !$pulang) return 0;
        $start = Carbon::createFromFormat('H:i', $datang);
        $end   = Carbon::createFromFormat('H:i', $pulang);
        $diff  = $end->diffInMinutes($start, false);
        return $diff > 0 ? $diff : 0;
    }

    public function jurnalIndex()
    {
        $penempatan = $this->currentPenempatanOrFail();

        $items = JurnalPekan::with('harian')
            ->where('id_penempatan', $penempatan->id_penempatan)
            ->where('id_mhs', auth()->id())
            ->orderByDesc('pekan_ke')
            ->paginate(10);

        return view('mahasiswa.jurnal.index', compact('items', 'penempatan'));
    }

    public function jurnalCreate()
    {
        $penempatan = $this->currentPenempatanOrFail();
        return view('mahasiswa.jurnal.create', compact('penempatan'));
    }

    public function jurnalStore(Request $request)
    {
        $penempatan = $this->currentPenempatanOrFail();

        $data = $request->validate([
            'pekan_ke' => ['required', 'integer', 'min:1'],
            'tanggal_mulai' => ['nullable', 'date'],
        ]);

        $pekan = JurnalPekan::create([
            'id_penempatan' => $penempatan->id_penempatan,
            'id_mhs' => auth()->id(),
            'pekan_ke' => $data['pekan_ke'],
            'tanggal_mulai' => $data['tanggal_mulai'] ?? null,
            'tanggal_selesai' => isset($data['tanggal_mulai'])
                ? Carbon::parse($data['tanggal_mulai'])->addDays(5)->toDateString() // auto 6 hari (Senin-Sabtu)
                : null,
            'status' => 'draft',
            'total_menit' => 0,
        ]);

        // Auto generate 6 baris harian jika tanggal_mulai diisi
        if (!empty($data['tanggal_mulai'])) {
            $start = Carbon::parse($data['tanggal_mulai']);
            for ($i = 0; $i < 6; $i++) {
                JurnalHarian::create([
                    'id_jurnal_pekan' => $pekan->id_jurnal_pekan,
                    'tanggal' => $start->copy()->addDays($i)->toDateString(),
                    'jam_datang' => null,
                    'jam_pulang' => null,
                    'jumlah_menit' => 0,
                    'kegiatan' => null,
                ]);
            }
        }

        return redirect()->route('mahasiswa.jurnal.show', $pekan->id_jurnal_pekan)
            ->with('success', 'Pekan jurnal berhasil dibuat.');
    }

    public function jurnalShow(JurnalPekan $pekan)
    {
        abort_if($pekan->id_mhs !== auth()->id(), 403);

        $pekan->load([
            'harian',
            'penempatan.instansi',
            'penempatan.periode',
            'penempatan',
            'mahasiswa',
        ]);

        return view('mahasiswa.jurnal.show', compact('pekan'));
    }

    public function jurnalHarianUpdate(Request $request, JurnalHarian $harian)
    {
        $pekan = JurnalPekan::findOrFail($harian->id_jurnal_pekan);
        abort_if($pekan->id_mhs !== auth()->id(), 403);
        abort_if(!in_array($pekan->status, ['draft', 'ditolak']), 403, 'Jurnal tidak bisa diedit.');

        $data = $request->validate([
            'jam_datang' => ['nullable', 'date_format:H:i'],
            'jam_pulang' => ['nullable', 'date_format:H:i'],
            'kegiatan' => ['nullable', 'string', 'max:5000'],
        ]);

        $menit = $this->hitungMenit($data['jam_datang'] ?? null, $data['jam_pulang'] ?? null);

        $harian->update([
            'jam_datang' => $data['jam_datang'] ?? null,
            'jam_pulang' => $data['jam_pulang'] ?? null,
            'jumlah_menit' => $menit,
            'kegiatan' => $data['kegiatan'] ?? null,
        ]);

        // update total pekan
        $total = JurnalHarian::where('id_jurnal_pekan', $pekan->id_jurnal_pekan)->sum('jumlah_menit');
        $pekan->update(['total_menit' => $total]);

        return back()->with('success', 'Jurnal harian tersimpan.');
    }

    public function jurnalSubmit(JurnalPekan $pekan)
    {
        abort_if($pekan->id_mhs !== auth()->id(), 403);
        abort_if($pekan->status !== 'draft', 403);

        $pekan->update(['status' => 'terkirim']);
        return back()->with('success', 'Jurnal pekan berhasil dikirim ke dosen mentor.');
    }

    public function jurnalDestroy(JurnalPekan $pekan)
    {
        abort_if($pekan->id_mhs !== auth()->id(), 403);
        abort_if($pekan->status === 'disetujui', 403, 'Jurnal disetujui tidak boleh dihapus.');

        $pekan->delete(); // cascade ke harian
        return redirect()->route('mahasiswa.jurnal')->with('success', 'Jurnal pekan dihapus.');
    }
    public function laporanAkhirIndex()
    {
        $penempatan = $this->currentPenempatanOrFail();

        $laporan = LaporanAkhir::where('id_penempatan', $penempatan->id_penempatan)
            ->where('id_mhs', auth()->id())
            ->first();

        return view('mahasiswa.laporan_akhir.index', compact('penempatan', 'laporan'));
    }

    public function laporanAkhirCreate()
    {
        $penempatan = $this->currentPenempatanOrFail();

        // kalau sudah ada, arahkan ke index
        $exists = LaporanAkhir::where('id_penempatan', $penempatan->id_penempatan)->exists();
        if ($exists) return redirect()->route('mahasiswa.laporan_akhir');

        return view('mahasiswa.laporan_akhir.create', compact('penempatan'));
    }

    public function laporanAkhirStore(Request $request)
    {
        $penempatan = $this->currentPenempatanOrFail();

        $data = $request->validate([
            'judul' => ['nullable', 'string', 'max:255'],
            'file'  => ['required', 'file', 'mimes:pdf,doc,docx', 'max:10240'], // 10MB
        ]);

        // 1 laporan per penempatan
        $exists = LaporanAkhir::where('id_penempatan', $penempatan->id_penempatan)->first();
        if ($exists) {
            return back()->withErrors(['file' => 'Laporan akhir untuk penempatan ini sudah ada. Hapus/replace dulu.']);
        }

        $path = $request->file('file')->store('laporan_akhir', 'public');

        LaporanAkhir::create([
            'id_penempatan' => $penempatan->id_penempatan,
            'id_mhs' => auth()->id(),
            'judul' => $data['judul'] ?? null,
            'file_path' => $path,
            'original_name' => $request->file('file')->getClientOriginalName(),
            'file_size' => $request->file('file')->getSize(),
            'mime' => $request->file('file')->getMimeType(),
            'status' => 'draft',
            'catatan_mentor' => null,
        ]);

        return redirect()->route('mahasiswa.laporan_akhir')->with('success', 'Laporan akhir berhasil diupload (draft).');
    }

    public function laporanAkhirSubmit(LaporanAkhir $laporan)
    {
        abort_if($laporan->id_mhs !== auth()->id(), 403);
        abort_if($laporan->status !== 'draft', 403, 'Hanya draft yang bisa dikirim.');

        $laporan->update(['status' => 'terkirim']);

        return back()->with('success', 'Laporan akhir berhasil dikirim ke dosen mentor.');
    }

    public function laporanAkhirDestroy(LaporanAkhir $laporan)
    {
        abort_if($laporan->id_mhs !== auth()->id(), 403);
        abort_if($laporan->status === 'disetujui', 403, 'Laporan disetujui tidak boleh dihapus.');

        Storage::disk('public')->delete($laporan->file_path);
        $laporan->delete();

        return back()->with('success', 'Laporan akhir dihapus.');
    }
     public function nilai()
    {        
        return view('mahasiswa.nilai');
    }
    
}
