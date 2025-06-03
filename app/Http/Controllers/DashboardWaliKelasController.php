<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Mengajar;
use App\Models\TahunAkademik;
use App\Models\WaliKelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardWaliKelasController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $guru = $user->guru;
        $error = null;

        if (!$guru) {
            return view('walikelas.dashboard', [
                'error' => 'Data guru tidak ditemukan. Silahkan hubungi admin.',
                'wali' => null,
                'tahun' => null,
                'jumlah_siswa' => 0,
                'jadwal_mengajar' => collect()
            ]);
        }

        $tahun = TahunAkademik::where('status', 'aktif')->first();
        if (!$tahun) {
            return view('walikelas.dashboard', [
                'error' => 'Tidak ada tahun akademik aktif',
                'wali' => null,
                'tahun' => null,
                'jumlah_siswa' => 0,
                'jadwal_mengajar' => collect()
            ]);
        }

        $wali = WaliKelas::where('guru_id', $guru->id)
            ->where('tahun_akademik_id', $tahun->id)
            ->first();

        if (!$wali) {
            return view('walikelas.dashboard', [
                'error' => 'Anda belum ditugaskan sebagai wali kelas untuk tahun akademik ini',
                'wali' => null,
                'tahun' => $tahun,
                'jumlah_siswa' => 0,
                'jadwal_mengajar' => collect()
            ]);
        }

        $jumlah_siswa = Kelas::find($wali->kelas_id)->siswa()->count();
        
        $jadwal_mengajar = Mengajar::with(['kelas', 'mapel'])
            ->where('guru_id', $guru->id)
            ->where('tahun_akademik_id', $tahun->id)
            ->get();

        return view('walikelas.dashboard', [
            'error' => $error,
            'wali' => $wali,
            'tahun' => $tahun,
            'jumlah_siswa' => $jumlah_siswa,
            'jadwal_mengajar' => $jadwal_mengajar
        ]);
    }
}
