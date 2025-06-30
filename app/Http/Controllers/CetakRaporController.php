<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KelasSiswa;
use App\Models\TahunAkademik;
use App\Models\WaliKelas;
use App\Models\Siswa;
use App\Models\NilaiSiswa;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class CetakRaporController extends Controller
{
    public function index()
    {
        $tahun = TahunAkademik::where('is_active', 1)->first();
        $wali = WaliKelas::where('guru_id', auth()->user()->guru->id)
                  ->where('tahun_akademik_id', $tahun->id)
                  ->first();

        $siswa = KelasSiswa::where('kelas_id', $wali->kelas_id)
                  ->where('tahun_akademik_id', $tahun->id)
                  ->with('siswa')
                  ->get();

        return view('walikelas.rapor.index', compact('siswa'));
    }

    public function show($siswa_id)
    {
        Carbon::setLocale('id');
        $tahun = TahunAkademik::where('is_active', 1)->first();
        $siswa = Siswa::findOrFail($siswa_id);
        $nilai = NilaiSiswa::where('siswa_id', $siswa_id)
                    ->where('tahun_akademik_id', $tahun->id)
                    ->with(['mapel', 'guru'])
                    ->get();

        $kelasSiswa = \App\Models\KelasSiswa::where('siswa_id', $siswa_id)
            ->where('tahun_akademik_id', $tahun->id)
            ->with('kelas')
            ->first();
        $kelas = $kelasSiswa->kelas;

        $wali = \App\Models\WaliKelas::where('kelas_id', $kelas->id)
                            ->where('tahun_akademik_id', $tahun->id)
                            ->with('guru')
                            ->first();
        $walikelas = $wali->guru;
        
        $kepsek = \App\Models\User::where('role', 'admin')->first();

        $tanggal_cetak = Carbon::now()->translatedFormat('d F Y');

        // Data Rapor Tambahan
        $catatan_walikelas = \App\Models\CatatanWalikelas::where('siswa_id', $siswa_id)
            ->where('tahun_akademik_id', $tahun->id)->first()->catatan ?? '';
        $ketidakhadiran = \App\Models\Ketidakhadiran::where('siswa_id', $siswa_id)
            ->where('tahun_akademik_id', $tahun->id)->first();
        $prestasi = \App\Models\Prestasi::where('siswa_id', $siswa_id)
            ->where('tahun_akademik_id', $tahun->id)->get();
        $ekstrakurikuler = \App\Models\EkstrakurikulerSiswa::where('siswa_id', $siswa_id)
            ->where('tahun_akademik_id', $tahun->id)->get();
    
        return Pdf::loadView('walikelas.rapor.pdf', compact(
            'siswa', 'nilai', 'kelas', 'tahun', 'walikelas', 'kepsek', 'tanggal_cetak',
            'catatan_walikelas', 'ketidakhadiran', 'prestasi', 'ekstrakurikuler'
        ))
            ->stream('rapor-'.$siswa->nama.'.pdf');
    }
}
